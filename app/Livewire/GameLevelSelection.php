<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\GameLevel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class GameLevelSelection extends Component
{
    public $game;
    public $levels = [];
    public $selectedLevel = null;
    public $showGameModal = false;

    public function mount(Game $game)
    {
        $this->game = $game;
        
        $this->levels = $game->levels()
            ->orderBy('level_number')
            ->get()
            ->map(function ($level, $index) {
                $unlockedPrevious = $index === 0 || true; // TODO: Implement proper unlock logic
                return [
                    'id' => $level->id,
                    'level_number' => $level->level_number,
                    'name' => $level->name,
                    'difficulty' => $level->difficulty,
                    'xp_reward' => $level->xp_reward,
                    'is_unlocked' => $unlockedPrevious,
                    'difficulty_color' => match($level->difficulty) {
                        'easy' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                        'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        'hard' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        'expert' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                        default => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                    }
                ];
            })
            ->toArray();
    }

    public function selectLevel($levelId)
    {
        $this->selectedLevel = collect($this->levels)->firstWhere('id', $levelId);
        $this->showGameModal = true;
    }

    public function playGame()
    {
        if ($this->selectedLevel) {
            return redirect()->route('games.play', [$this->game->id, $this->selectedLevel['id']]);
        }
    }

    public function render()
    {
        return view('livewire.game-level-selection');
    }
}
