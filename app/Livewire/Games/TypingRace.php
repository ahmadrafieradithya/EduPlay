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
    public string $userInput   = '';
    public string $targetText  = '';
    public array  $allTexts    = [];
    public int    $timeLeft    = 60;
    public bool   $isStarted   = false;
    public bool   $isFinished  = false;
    public bool   $roundFinished = false;
    public int    $score       = 0;
    public int    $wpm         = 0;
    public int    $accuracy    = 0;
    public int    $correctChars = 0;
    public int    $wrongChars   = 0;
    public int    $currentRound = 1;
    public int    $totalRounds  = 3;
    public int    $roundScore   = 0;

    public function mount(GameLevel $level): void
    {
        $this->level    = $level;
        $content        = is_array($level->content)
                            ? $level->content
                            : json_decode($level->content, true);
        $this->allTexts = $content['texts'] ?? $this->getDefaultTexts();
        $this->timeLeft = $level->time_limit;
        $this->pickRandomText();
    }

    private function pickRandomText(): void
    {
        $this->targetText  = $this->allTexts[array_rand($this->allTexts)];
        $this->userInput   = '';
        $this->correctChars = 0;
        $this->wrongChars   = 0;
    }

    private function getDefaultTexts(): array
    {
        return [
            '<h1>Hello World</h1>',
            '<p>Belajar HTML itu mudah!</p>',
            'echo "Hello, World!";',
            '$nama = "Ahmad";',
            'Route::get("/home", [HomeController::class, "index"]);',
            '$users = User::where("active", true)->get();',
            'return view("dashboard", compact("user"));',
        ];
    }

    public function start(): void
    {
        $this->isStarted = true;
        $this->timeLeft  = $this->level->time_limit;
        $this->dispatch('game-started');
    }

    public function updatedUserInput(string $value): void
    {
        // Hitung karakter benar dan salah
        $this->correctChars = 0;
        $this->wrongChars   = 0;
        $len = min(strlen($value), strlen($this->targetText));
        for ($i = 0; $i < $len; $i++) {
            if ($value[$i] === $this->targetText[$i]) {
                $this->correctChars++;
            } else {
                $this->wrongChars++;
            }
        }

        // Auto selesai jika teks sudah sama persis
        if ($value === $this->targetText) {
            $this->finishRound();
        }
    }

    public function finishRound(): void
    {
        if ($this->roundFinished) return;
        $this->roundFinished = true;

        $timeUsed      = max(1, $this->level->time_limit - $this->timeLeft);
        $totalChars    = strlen($this->targetText);
        $this->accuracy = $totalChars > 0
            ? (int) round(($this->correctChars / $totalChars) * 100)
            : 0;

        $wordsTyped  = str_word_count($this->userInput);
        $this->wpm   = (int) round(($wordsTyped / $timeUsed) * 60);

        $wpmBonus        = min(50, $this->wpm * 0.5);
        $this->roundScore = (int) (($this->accuracy * 0.7) + $wpmBonus);
        $this->score    += $this->roundScore;

        if ($this->currentRound >= $this->totalRounds) {
            $this->finish();
        }
    }

    public function nextRound(): void
    {
        $this->currentRound++;
        $this->roundFinished = false;
        $this->pickRandomText();
        $this->timeLeft = $this->level->time_limit;
    }

    public function tick(): void
    {
        if (!$this->isStarted || $this->isFinished || $this->roundFinished) return;
        $this->timeLeft = max(0, $this->timeLeft - 1);
        if ($this->timeLeft <= 0) {
            $this->accuracy   = strlen($this->targetText) > 0
                ? (int) round(($this->correctChars / strlen($this->targetText)) * 100)
                : 0;
            $this->wpm        = 0;
            $this->roundScore = (int) ($this->accuracy * 0.5);
            $this->score     += $this->roundScore;
            $this->roundFinished = true;

            if ($this->currentRound >= $this->totalRounds) {
                $this->finish();
            }
        }
    }

    public function finish(): void
    {
        if ($this->isFinished) return;
        $this->isFinished = true;

        $finalScore = (int) round($this->score / $this->totalRounds);
        $this->score = $finalScore;
        $isPassed   = $finalScore >= $this->level->min_score_to_pass;

        GameSession::create([
            'user_id'          => auth()->id(),
            'game_id'          => $this->level->game_id,
            'game_level_id'    => $this->level->id,
            'score'            => $finalScore,
            'is_passed'        => $isPassed,
            'duration_seconds' => $this->level->time_limit,
        ]);

        $rec = GameScore::firstOrNew([
            'user_id' => auth()->id(),
            'game_id' => $this->level->game_id,
        ]);
        if ($finalScore > ($rec->best_score ?? 0)) {
            $rec->best_score = $finalScore;
        }
        $rec->total_plays = ($rec->total_plays ?? 0) + 1;
        $rec->save();

        if ($isPassed) {
            app(XPService::class)->award(
                auth()->user(),
                'game_completed',
                $this->level->xp_reward,
                ['game_level_id' => $this->level->id]
            );
        }
    }

    public function render()
    {
        return view('livewire.games.typing-race');
    }
}