<?php

namespace App\Livewire\Games;

use App\Models\GameLevel;
use App\Models\GameSession;
use App\Services\XPService;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Collection;

class CodePuzzleGame extends Component
{
    public GameLevel $level;
    public $gameSession;
    public array $pieces = [];
    public array $userOrder = [];
    public int $timeRemaining = 0;
    public int $totalTime = 0;
    public bool $isSubmitted = false;
    public bool $timerActive = false;
    public ?int $score = null;
    public ?int $xpEarned = null;
    public ?array $resultData = null;
    public bool $showHint = false;
    public int $hintsUsed = 0;

    public function mount(GameLevel $level)
    {
        $this->level = $level;
        
        // Parse level data
        $data = json_decode($level->content, true);
        
        // Set time based on difficulty (in seconds)
        $difficultyMultipliers = [
            'easy' => 60,
            'medium' => 45,
            'hard' => 30,
            'expert' => 20,
        ];
        
        $difficulty = strtolower($level->game->difficulty ?? 'medium');
        $this->totalTime = $difficultyMultipliers[$difficulty] ?? 45;
        $this->timeRemaining = $this->totalTime;
        
        // Shuffle pieces
        $this->pieces = collect($data['pieces'] ?? [])
            ->map(fn($piece, $index) => [
                'id' => $index,
                'content' => $piece,
                'originalIndex' => $index,
            ])
            ->shuffle()
            ->values()
            ->toArray();
        
        // Initialize user order as empty (pieces will be dragged in)
        $this->userOrder = [];
        
        // Create game session
        $this->gameSession = GameSession::create([
            'user_id' => auth()->id(),
            'game_id' => $level->game_id,
            'game_level_id' => $level->id,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
        
        $this->timerActive = true;
    }

    #[On('poll')]
    public function tick()
    {
        if (!$this->timerActive || $this->isSubmitted) {
            return;
        }

        if ($this->timeRemaining > 0) {
            $this->timeRemaining--;
        }

        // Auto-submit when time runs out
        if ($this->timeRemaining === 0) {
            $this->submitAnswer();
        }
    }

    #[On('updateOrder')]
    public function updateOrder($order)
    {
        $this->userOrder = $order;
    }

    public function submitAnswer()
    {
        if ($this->isSubmitted) {
            return;
        }

        $this->timerActive = false;
        $this->isSubmitted = true;

        // Get correct order from level data
        $data = json_decode($this->level->content, true);
        $correctOrder = $data['correct_order'] ?? [];

        // Calculate accuracy
        $userOrderIndices = array_map(function($piece) {
            return $piece['originalIndex'];
        }, $this->userOrder);

        $accuracy = 0;
        if (count($correctOrder) > 0) {
            $correctCount = 0;
            foreach ($userOrderIndices as $index => $value) {
                if (isset($correctOrder[$index]) && $correctOrder[$index] === $value) {
                    $correctCount++;
                }
            }
            $accuracy = round(($correctCount / count($correctOrder)) * 100);
        }

        // Calculate time bonus
        $timeBonus = round(($this->timeRemaining / $this->totalTime) * 100);

        // Get difficulty multiplier
        $difficultyMultipliers = [
            'easy' => 0.5,
            'medium' => 1.0,
            'hard' => 1.5,
            'expert' => 2.0,
        ];
        $difficulty = strtolower($this->level->game->difficulty ?? 'medium');
        $multiplier = $difficultyMultipliers[$difficulty] ?? 1.0;

        // Calculate final score
        $baseScore = ($accuracy + $timeBonus) / 2; // Average of accuracy and time bonus
        $this->score = (int)round($baseScore * $multiplier);

        // Calculate XP earned
        $this->xpEarned = (int)round($this->score / 10); // Convert score to XP
        
        // Award XP
        app(XPService::class)->award(
            auth()->user(),
            'puzzle_completed',
            $this->xpEarned,
            [
                'game_level_id' => $this->level->id,
                'accuracy' => $accuracy,
                'time_used' => $this->totalTime - $this->timeRemaining,
            ]
        );

        // Save game session
        $this->gameSession->update([
            'score' => $this->score,
            'completed_at' => now(),
            'status' => $accuracy === 100 ? 'passed' : 'completed',
            'metadata' => json_encode([
                'accuracy' => $accuracy,
                'time_bonus' => $timeBonus,
                'time_used' => $this->totalTime - $this->timeRemaining,
                'total_time' => $this->totalTime,
                'hints_used' => $this->hintsUsed,
            ]),
        ]);

        $this->resultData = [
            'accuracy' => $accuracy,
            'timeBonus' => $timeBonus,
            'baseScore' => $baseScore,
            'multiplier' => $multiplier,
            'passed' => $accuracy === 100,
        ];
    }

    public function showNextHint()
    {
        $data = json_decode($this->level->content, true);
        $hints = $data['hints'] ?? [];

        if ($this->hintsUsed < count($hints)) {
            $this->hintsUsed++;
            $this->showHint = true;
        }
    }

    public function getNextLevel()
    {
        $nextLevel = GameLevel::where('game_id', $this->level->game_id)
            ->where('level_number', '>', $this->level->level_number)
            ->orderBy('level_number')
            ->first();

        if ($nextLevel) {
            return route('games.play', ['game' => $this->level->game_id, 'level' => $nextLevel->id]);
        }

        // All levels completed, show congratulations
        return route('games.index');
    }

    public function tryAgain()
    {
        return route('games.play', ['game' => $this->level->game_id, 'level' => $this->level->id]);
    }

    public function render()
    {
        return view('livewire.games.code-puzzle-game');
    }
}
