<?php

namespace App\Livewire\Games;

use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\GameScore;
use App\Services\XPService;
use Livewire\Component;

class QuizGame extends Component
{
    public GameLevel $level;
    public array $questions = [];
    public int $currentIndex = 0;
    public ?int $selectedAnswer = null;
    public int $score = 0;
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
        $this->totalTime = ($level->time_limit ?? 60) * count($this->questions);
        $this->timeLeft = $this->totalTime;
        $this->startTime = time();
    }

    /**
     * Load questions from level content
     */
    private function loadQuestions(): void
    {
        $this->questions = $this->level->content['questions'] ?? [];
    }

    /**
     * Get current question
     */
    public function getCurrentQuestion(): array
    {
        return $this->questions[$this->currentIndex] ?? [];
    }

    /**
     * Select an answer and check if correct
     */
    public function selectAnswer(int $answerIndex): void
    {
        if ($this->showExplanation || $this->isFinished) {
            return;
        }

        $this->selectedAnswer = $answerIndex;
        $currentQ = $this->getCurrentQuestion();
        $correctAnswer = $currentQ['correct'] ?? 0;

        $this->isAnswerCorrect = $answerIndex === $correctAnswer;

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
        } else {
            $this->finishGame();
        }
    }

    /**
     * Finish the game
     */
    public function finishGame(): void
    {
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
        $session = GameSession::create([
            'game_id' => $game->id,
            'game_level_id' => $this->level->id,
            'user_id' => $user->id,
            'score' => (int) $scorePercentage,
            'duration_seconds' => $elapsedSeconds,
            'answers' => [
                'correct_answers' => $this->score,
                'total_questions' => count($this->questions),
                'percentage' => $scorePercentage,
            ],
            'played_at' => now(),
        ]);

        // Create game score
        GameScore::create([
            'game_session_id' => $session->id,
            'user_id' => $user->id,
            'score' => (int) $scorePercentage,
            'max_score' => 100,
            'details' => [
                'correct_answers' => $this->score,
                'total_questions' => count($this->questions),
                'passed' => $passed,
            ],
        ]);
    }

    /**
     * Tick down the timer (called via wire:poll)
     */
    public function tick(): void
    {
        if ($this->isFinished) {
            return;
        }

        $this->timeLeft--;

        if ($this->timeLeft <= 0) {
            $this->timeLeft = 0;
            $this->finishGame();
        }
    }

    /**
     * Reset and play again
     */
    public function playAgain(): void
    {
        $this->currentIndex = 0;
        $this->selectedAnswer = null;
        $this->score = 0;
        $this->isFinished = false;
        $this->showExplanation = false;
        $this->timeLeft = $this->totalTime;
        $this->startTime = time();
    }

    public function render()
    {
        return view('livewire.games.quiz-game');
    }
}
