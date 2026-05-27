<?php

namespace App\Livewire\Games;

use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\GameScore;
use App\Services\XPService;
use Livewire\Component;

class Quiz extends Component
{
    public GameLevel $level;
    public array $questions = [];
    public int $currentIndex = 0;
    public ?int $selectedAnswer = null;
    public int $score = 0;
    public bool $isStarted = false;
    public bool $isFinished = false;
    public bool $showExplanation = false;
    public bool $isAnswerCorrect = false;
    public int $totalTime = 0;
    public int $timeLeft = 0;
    public int $startTime = 0;

    public function mount(GameLevel $level): void
    {
        $this->level = $level;
        $this->loadQuestions();
        $this->timeLeft = $level->time_limit ?? 30;
    }

    /**
     * Load questions from level content
     */
    private function loadQuestions(): void
    {
        $content = is_array($this->level->content) ? $this->level->content : json_decode($this->level->content, true);
        $this->questions = $content['questions'] ?? [];
    }

    public function start(): void
    {
        $this->isStarted = true;
        $this->startTime = time();
    }

    /**
     * Get current question
     */
    public function getCurrentQuestion(): array
    {
        return $this->questions[$this->currentIndex] ?? [];
    }

    /**
     * Select an answer
     */
    public function selectAnswer(int $answerIndex): void
    {
        if ($this->showExplanation || $this->isFinished) {
            return;
        }

        $this->selectedAnswer = $answerIndex;
    }

    /**
     * Submit the answer
     */
    public function submitAnswer(): void
    {
        if ($this->selectedAnswer === null || $this->showExplanation || $this->isFinished) {
            return;
        }

        $currentQ = $this->getCurrentQuestion();
        $correctAnswer = $currentQ['correct'] ?? 0;

        $this->isAnswerCorrect = $this->selectedAnswer === $correctAnswer;

        if ($this->isAnswerCorrect) {
            $this->score++;
        }

        $this->showExplanation = true;
    }

    /**
     * Move to next question
     */
    public function nextQuestion(): void
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
            $this->selectedAnswer = null;
            $this->showExplanation = false;
            $this->isAnswerCorrect = false;
            $this->timeLeft = $this->level->time_limit ?? 30;
        } else {
            $this->finishGame();
        }
    }

    /**
     * Finish the game
     */
    public function finishGame(): void
    {
        if ($this->isFinished) return;
        $this->isFinished = true;

        // Calculate metrics
        $elapsedSeconds = time() - $this->startTime;
        $totalQuestions = count($this->questions);
        $scorePercentage = $totalQuestions > 0 ? round(($this->score / $totalQuestions) * 100, 2) : 0;
        $passed = $scorePercentage >= ($this->level->min_score_to_pass ?? 70);

        // Save game result
        $this->saveGameResult($elapsedSeconds, $scorePercentage, $passed);

        // Award XP if passed
        if ($passed && auth()->check()) {
            app(XPService::class)->award(
                auth()->user(),
                'game_completed',
                $this->level->xp_reward,
                ['game_level_id' => $this->level->id, 'game_type' => 'quiz']
            );
        }

        $this->dispatch('game-completed', score: (int) $scorePercentage);
    }

    /**
     * Save game result to database
     */
    private function saveGameResult(int $elapsedSeconds, float $scorePercentage, bool $passed): void
    {
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();
        $game = $this->level->game;

        // Create game session
        GameSession::create([
            'game_id' => $game->id,
            'game_level_id' => $this->level->id,
            'user_id' => $user->id,
            'score' => (int) $scorePercentage,
            'is_passed' => $passed,
            'duration_seconds' => $elapsedSeconds,
            'answers' => json_encode([
                'correct_answers' => $this->score,
                'total_questions' => count($this->questions),
                'percentage' => $scorePercentage,
            ]),
            'played_at' => now(),
        ]);

        // Create or update game score
        $gameScore = GameScore::firstOrNew([
            'user_id' => $user->id,
            'game_id' => $game->id,
        ]);
        
        if ((int)$scorePercentage > $gameScore->best_score) {
            $gameScore->best_score = (int)$scorePercentage;
        }
        
        $gameScore->total_plays += 1;
        $gameScore->save();
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

        if ($this->timeLeft <= 0) {
            $this->timeLeft = 0;
            if (!$this->showExplanation) {
                $this->submitAnswer();
            } else {
                $this->nextQuestion();
            }
        }
    }

    public function render()
    {
        return view('livewire.games.quiz');
    }
}
