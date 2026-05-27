<?php

namespace App\Livewire\Games;

use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\GameScore;
use App\Services\XPService;
use Livewire\Component;

class CodePuzzle extends Component
{
    public GameLevel $level;
    public array $pieces = [];        // Potongan kode yang diacak
    public array $placedPieces = [];  // Potongan yang sudah ditempatkan user
    public array $correctOrder = [];  // Urutan yang benar
    public int $timeLeft = 60;
    public bool $isStarted = false;
    public bool $isFinished = false;
    public bool $isChecked = false;
    public int $score = 0;
    public int $correctCount = 0;
    public string $hint = '';
    public int $hintIndex = 0;
    public bool $showHint = false;

    public function mount(GameLevel $level): void
    {
        $this->level = $level;
        $content = is_array($level->content) ? $level->content : json_decode($level->content, true);

        $originalPieces = $content['pieces'] ?? [];
        $this->correctOrder = $content['correct_order'] ?? range(0, count($originalPieces) - 1);

        // Acak urutan pieces
        $indexed = array_map(
            fn ($i, $p) => ['index' => $i, 'text' => $p],
            array_keys($originalPieces),
            $originalPieces
        );
        shuffle($indexed);
        $this->pieces = $indexed;
        $this->placedPieces = array_fill(0, count($originalPieces), null);
        $this->timeLeft = $level->time_limit;
    }

    public function start(): void
    {
        $this->isStarted = true;
    }

    public function placePiece(int $pieceArrayIndex, int $slotIndex): void
    {
        if ($this->isFinished || $this->isChecked) return;

        $piece = $this->pieces[$pieceArrayIndex] ?? null;
        if (!$piece) return;

        // Kalau slot sudah ada isinya, kembalikan ke pool
        if ($this->placedPieces[$slotIndex] !== null) {
            $this->pieces[] = $this->placedPieces[$slotIndex];
        }

        // Tempatkan piece ke slot
        $this->placedPieces[$slotIndex] = $piece;

        // Hapus dari pool
        array_splice($this->pieces, $pieceArrayIndex, 1);
    }

    public function removePiece(int $slotIndex): void
    {
        if ($this->isFinished || $this->isChecked) return;

        $piece = $this->placedPieces[$slotIndex];
        if ($piece !== null) {
            $this->pieces[] = $piece;
            $this->placedPieces[$slotIndex] = null;
        }
    }

    public function checkAnswer(): void
    {
        if ($this->isFinished) return;
        $this->isChecked = true;

        $this->correctCount = 0;
        foreach ($this->placedPieces as $slot => $piece) {
            if ($piece !== null && isset($this->correctOrder[$slot])
                && $piece['index'] === $this->correctOrder[$slot]) {
                $this->correctCount++;
            }
        }

        $total = count($this->correctOrder);
        $accuracy = $total > 0 ? round(($this->correctCount / $total) * 100) : 0;
        $timeBonus = max(0, $this->timeLeft * 0.3);
        $this->score = (int) min(100, $accuracy + $timeBonus);

        $this->finish();
    }

    public function showNextHint(): void
    {
        $content = is_array($this->level->content)
            ? $this->level->content
            : json_decode($this->level->content, true);
        $hints = $content['hints'] ?? [];

        if (!empty($hints)) {
            $this->hint = $hints[$this->hintIndex % count($hints)];
            $this->hintIndex++;
            $this->showHint = true;
        }
    }

    public function tick(): void
    {
        if (!$this->isStarted || $this->isFinished || $this->isChecked) return;
        $this->timeLeft = max(0, $this->timeLeft - 1);
        if ($this->timeLeft <= 0) {
            $this->checkAnswer();
        }
    }

    private function finish(): void
    {
        $this->isFinished = true;
        $isPassed = $this->score >= $this->level->min_score_to_pass;

        GameSession::create([
            'user_id'          => auth()->id(),
            'game_id'          => $this->level->game_id,
            'game_level_id'    => $this->level->id,
            'score'            => $this->score,
            'is_passed'        => $isPassed,
            'duration_seconds' => $this->level->time_limit - $this->timeLeft,
        ]);

        $rec = GameScore::firstOrNew([
            'user_id' => auth()->id(),
            'game_id' => $this->level->game_id,
        ]);
        if ($this->score > ($rec->best_score ?? 0)) {
            $rec->best_score = $this->score;
        }
        $rec->total_plays = ($rec->total_plays ?? 0) + 1;
        $rec->save();

        if ($isPassed) {
            app(XPService::class)->award(
                auth()->user(),
                'game_completed',
                $this->level->xp_reward
            );
        }
    }

    public function render()
    {
        return view('livewire.games.code-puzzle');
    }
}