<?php

namespace App\Livewire\Games;

use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\GameScore;
use App\Services\XPService;
use Livewire\Component;
use Livewire\Attributes\On;

class TypingRace extends Component
{
    // Game state
    public GameLevel $level;
    public bool $isStarted = false;
    public bool $isFinished = false;
    
    // Text management
    public array $allTexts = [];
    public string $targetText = '';
    public int $textIndex = 0;
    
    // User input and feedback
    public string $userInput = '';
    public int $correctChars = 0;
    public int $wrongChars = 0;
    
    // Round management
    public int $currentRound = 1;
    public int $totalRounds = 3;
    public int $roundScore = 0;
    public bool $roundFinished = false;
    
    // Stats
    public int $timeLeft = 60;
    public int $score = 0;
    public float $wpm = 0;
    public int $accuracy = 0;
    public int $totalCorrectChars = 0;
    public int $totalWrongChars = 0;

    public function mount(GameLevel $level): void
    {
        $this->level = $level;
        $this->initializeTexts();
        $this->pickRandomText();
        $this->timeLeft = $level->time_limit;
    }

    /**
     * Initialize texts from level content
     */
    private function initializeTexts(): void
    {
        $content = is_array($this->level->content) 
            ? $this->level->content 
            : json_decode($this->level->content, true);
        
        $this->allTexts = $content['texts'] ?? $this->getDefaultTexts();
        
        // Shuffle for variety
        shuffle($this->allTexts);
    }

    /**
     * Pick a random text from available texts
     */
    private function pickRandomText(): void
    {
        if (empty($this->allTexts)) {
            $this->allTexts = $this->getDefaultTexts();
        }
        
        $this->textIndex = array_rand($this->allTexts);
        $this->targetText = $this->allTexts[$this->textIndex];
        $this->userInput = '';
        $this->correctChars = 0;
        $this->wrongChars = 0;
    }

    /**
     * Get default texts if none are configured
     */
    private function getDefaultTexts(): array
    {
        return [
            '<h1>Hello World</h1>',
            '<p>Belajar HTML itu mudah!</p>',
            'echo "Hello, World!";',
            '$nama = "Ahmad";',
            'Route::get("/home", [HomeController::class, "index"]);',
        ];
    }

    /**
     * Start the game
     */
    public function start(): void
    {
        $this->isStarted = true;
        $this->timeLeft = $this->level->time_limit;
        $this->dispatch('typing-race:started');
    }

    /**
     * Update user input and calculate character accuracy
     */
    public function updateInput(string $value): void
    {
        if (!$this->isStarted || $this->isFinished || $this->roundFinished) {
            return;
        }

        $this->userInput = $value;
        $this->calculateCharacterStats();

        // Check if text is completed correctly
        if ($value === $this->targetText) {
            $this->finishRound();
        }
    }

    /**
     * Calculate correct and wrong characters in real-time
     */
    private function calculateCharacterStats(): void
    {
        $this->correctChars = 0;
        $this->wrongChars = 0;
        
        $minLen = min(strlen($this->userInput), strlen($this->targetText));
        
        for ($i = 0; $i < $minLen; $i++) {
            if ($this->userInput[$i] === $this->targetText[$i]) {
                $this->correctChars++;
            } else {
                $this->wrongChars++;
            }
        }

        // If user typed more characters than target, extra chars are wrong
        if (strlen($this->userInput) > strlen($this->targetText)) {
            $this->wrongChars += strlen($this->userInput) - strlen($this->targetText);
        }
    }

    /**
     * Get highlighted HTML for visual feedback
     */
    public function getHighlightedText(): string
    {
        $html = '';
        $targetLen = strlen($this->targetText);
        $inputLen = strlen($this->userInput);

        for ($i = 0; $i < $targetLen; $i++) {
            $targetChar = $this->targetText[$i];
            $inputChar = $i < $inputLen ? $this->userInput[$i] : '';

            if ($i < $inputLen) {
                if ($inputChar === $targetChar) {
                    // Correct character - green
                    $html .= '<span class="text-green-500 font-semibold">' . htmlspecialchars($targetChar) . '</span>';
                } else {
                    // Wrong character - red
                    $html .= '<span class="text-red-500 font-semibold bg-red-100">' . htmlspecialchars($targetChar) . '</span>';
                }
            } else {
                // Not typed yet - gray
                $html .= '<span class="text-gray-400">' . htmlspecialchars($targetChar) . '</span>';
            }
        }

        // Show extra typed characters in red
        if ($inputLen > $targetLen) {
            for ($i = $targetLen; $i < $inputLen; $i++) {
                $html .= '<span class="text-red-600 bg-red-200 font-semibold">' . htmlspecialchars($this->userInput[$i]) . '</span>';
            }
        }

        return $html;
    }

    /**
     * Finish current round
     */
    public function finishRound(): void
    {
        if ($this->roundFinished) {
            return;
        }

        $this->roundFinished = true;
        $timeUsed = max(1, $this->level->time_limit - $this->timeLeft);

        // Calculate accuracy percentage
        $totalChars = strlen($this->targetText);
        $this->accuracy = $totalChars > 0 
            ? (int) round(($this->correctChars / $totalChars) * 100) 
            : 0;

        // Calculate Words Per Minute (WPM)
        $wordsTyped = str_word_count($this->userInput);
        $minutesUsed = $timeUsed / 60;
        $this->wpm = (float) round($wordsTyped / max(0.1, $minutesUsed), 1);

        // Calculate round score
        // Base: accuracy (0-100 points) + WPM bonus (0-50 points)
        $wpmBonus = min(50, ($this->wpm / 30) * 50); // Scale WPM to 50 points max
        $this->roundScore = (int) (($this->accuracy * 0.7) + $wpmBonus);
        $this->score += $this->roundScore;

        $this->totalCorrectChars += $this->correctChars;
        $this->totalWrongChars += $this->wrongChars;

        // Move to next round or finish
        if ($this->currentRound >= $this->totalRounds) {
            $this->finish();
        }
    }

    /**
     * Go to next round with a new random text
     */
    public function nextRound(): void
    {
        $this->currentRound++;
        $this->roundFinished = false;
        $this->pickRandomText();
        $this->timeLeft = $this->level->time_limit;
    }

    /**
     * Called every second to count down
     */
    public function tick(): void
    {
        if (!$this->isStarted || $this->isFinished || $this->roundFinished) {
            return;
        }

        $this->timeLeft = max(0, $this->timeLeft - 1);

        if ($this->timeLeft <= 0) {
            // Time's up - calculate what was typed so far
            $timeUsed = $this->level->time_limit;
            $totalChars = strlen($this->targetText);
            
            $this->accuracy = $totalChars > 0
                ? (int) round(($this->correctChars / $totalChars) * 100)
                : 0;

            $this->wpm = 0; // No WPM bonus when time runs out
            $this->roundScore = (int) ($this->accuracy * 0.5); // Reduced score for timeout
            $this->score += $this->roundScore;

            $this->totalCorrectChars += $this->correctChars;
            $this->totalWrongChars += $this->wrongChars;
            $this->roundFinished = true;

            if ($this->currentRound >= $this->totalRounds) {
                $this->finish();
            }
        }
    }

    /**
     * Finish the game and save results
     */
    public function finish(): void
    {
        if ($this->isFinished) {
            return;
        }

        $this->isFinished = true;

        // Calculate final score (average of all rounds)
        $finalScore = (int) round($this->score / $this->totalRounds);
        $this->score = $finalScore;
        $isPassed = $finalScore >= $this->level->min_score_to_pass;

        // Calculate overall statistics
        $overallAccuracy = ($this->totalCorrectChars + $this->totalWrongChars) > 0
            ? (int) round(($this->totalCorrectChars / ($this->totalCorrectChars + $this->totalWrongChars)) * 100)
            : 0;

        // Save game session
        GameSession::create([
            'user_id'           => auth()->id(),
            'game_id'           => $this->level->game_id,
            'game_level_id'     => $this->level->id,
            'score'             => $finalScore,
            'is_passed'         => $isPassed,
            'duration_seconds'  => $this->level->time_limit * $this->totalRounds,
            'metadata'          => [
                'accuracy'  => $overallAccuracy,
                'wpm'       => $this->wpm,
                'rounds'    => $this->totalRounds,
            ],
        ]);

        // Update or create best score record
        $scoreRecord = GameScore::firstOrNew([
            'user_id' => auth()->id(),
            'game_id' => $this->level->game_id,
        ]);

        if ($finalScore > ($scoreRecord->best_score ?? 0)) {
            $scoreRecord->best_score = $finalScore;
        }

        $scoreRecord->total_plays = ($scoreRecord->total_plays ?? 0) + 1;
        $scoreRecord->save();

        // Award XP if passed
        if ($isPassed) {
            app(XPService::class)->award(
                auth()->user(),
                'game_completed',
                $this->level->xp_reward,
                [
                    'game_level_id' => $this->level->id,
                    'score'         => $finalScore,
                    'accuracy'      => $overallAccuracy,
                ]
            );
        }

        $this->dispatch('typing-race:finished', [
            'score'     => $finalScore,
            'isPassed'  => $isPassed,
            'accuracy'  => $overallAccuracy,
        ]);
    }

    public function render()
    {
        return view('livewire.games.typing-race', [
            'highlightedText' => $this->getHighlightedText(),
        ]);
    }
}
