<?php

namespace App\Livewire\Games;

use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\GameScore;
use App\Services\XPService;
use Livewire\Component;

class TypingRace extends Component
{
    public GameLevel $level;
    public string $userInput = '';
    public string $targetText = '';
    public int $timeLeft = 0;
    public bool $isStarted = false;
    public bool $isFinished = false;
    public int $score = 0;
    public float $wpm = 0;
    public float $accuracy = 0;
    public int $totalTime = 0;
    public bool $passed = false;

    public function mount(GameLevel $level): void
    {
        $this->level = $level;
        $this->timeLeft = $level->time_limit ?? 120;
        $this->totalTime = $this->timeLeft;
        $this->pickRandomText();
    }

    /**
     * Pick a random text from the level content
     */
    private function pickRandomText(): void
    {
        $content = is_array($this->level->content) ? $this->level->content : json_decode($this->level->content, true);
        $texts = $content['texts'] ?? $content['content'] ?? [];
        if (!empty($texts)) {
            $this->targetText = is_array($texts) ? $texts[array_rand($texts)] : $texts;
        } else {
            $this->targetText = 'Learn to type faster with this typing challenge!';
        }
    }

    /**
     * Start the game
     */
    public function start(): void
    {
        $this->isStarted = true;
        $this->userInput = '';
    }

    /**
     * Update user input and check for completion
     */
    public function updateInput(string $value): void
    {
        $this->userInput = $value;

        // Check if user has completed the text correctly
        if ($value === $this->targetText && !$this->isFinished) {
            $this->finish();
        }
    }

    /**
     * Tick down the timer (called via wire:poll)
     */
    public function tick(): void
    {
        if (!$this->isStarted || $this->isFinished) {
            return;
        }

        $this->timeLeft--;

        // Auto finish when time runs out
        if ($this->timeLeft <= 0) {
            $this->timeLeft = 0;
            $this->finish();
        }
    }

    /**
     * Finish the game and calculate scores
     */
    public function finish(): void
    {
        if ($this->isFinished) {
            return;
        }

        $this->isFinished = true;

        // Calculate elapsed time in seconds
        $elapsedSeconds = $this->totalTime - $this->timeLeft;
        $elapsedMinutes = max($elapsedSeconds / 60, 0.1); // Prevent division by zero

        // Calculate accuracy (character match percentage)
        $correctChars = 0;
        $totalChars = strlen($this->targetText);

        for ($i = 0; $i < $totalChars; $i++) {
            if (isset($this->userInput[$i]) && $this->userInput[$i] === $this->targetText[$i]) {
                $correctChars++;
            }
        }

        $this->accuracy = $totalChars > 0 ? round(($correctChars / $totalChars) * 100, 2) : 0;

        // Calculate WPM (Words Per Minute)
        $wordsTyped = count(explode(' ', trim($this->userInput)));
        $this->wpm = round($wordsTyped / $elapsedMinutes, 2);

        // Calculate score (0-100)
        $this->score = $this->userInput === $this->targetText
            ? (int) $this->accuracy
            : (int) min($this->accuracy * 0.8, 80); // Penalty if not exact match

        // Check if passed
        $this->passed = $this->score >= ($this->level->min_score_to_pass ?? 70);

        // Save game session and score
        $this->saveGameResult($elapsedSeconds);

        // Award XP if passed
        if ($this->passed && auth()->check()) {
            app(XPService::class)->award(
                auth()->user(),
                'game_completed',
                $this->level->xp_reward,
                ['game_level_id' => $this->level->id, 'game_type' => 'typing_race']
            );
        }
    }

    /**
     * Save game result to database
     */
    private function saveGameResult(int $elapsedSeconds): void
    {
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();
        $game = $this->level->game;

        // Create game session
        $session = GameSession::create([
            'game_id' => $game->id,
            'game_level_id' => $this->level->id,
            'user_id' => $user->id,
            'score' => $this->score,
            'duration_seconds' => $elapsedSeconds,
            'answers' => [
                'target' => $this->targetText,
                'typed' => $this->userInput,
                'wpm' => $this->wpm,
                'accuracy' => $this->accuracy,
            ],
            'played_at' => now(),
        ]);

        // Create game score
        GameScore::create([
            'game_session_id' => $session->id,
            'user_id' => $user->id,
            'score' => $this->score,
            'max_score' => 100,
            'details' => [
                'wpm' => $this->wpm,
                'accuracy' => $this->accuracy,
                'passed' => $this->passed,
            ],
        ]);

        $this->dispatch('game-completed', score: $this->score);
    }

    /**
     * Reset and play again
     */
    public function playAgain(): void
    {
        $this->userInput = '';
        $this->isStarted = false;
        $this->isFinished = false;
        $this->score = 0;
        $this->wpm = 0;
        $this->accuracy = 0;
        $this->timeLeft = $this->totalTime;
        $this->pickRandomText();
    }

    public function render()
    {
        return view('livewire.games.typing-race');
    }
}
