<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class GameArenaList extends Component
{
    public $games = [];

    public function mount()
    {
        $this->loadGames();
    }

    public function loadGames()
    {
        $this->games = Game::where('is_active', true)
            ->where('is_published', true)
            ->with(['levels', 'scores' => fn($q) => $q->where('user_id', auth()->id())])
            ->get()
            ->map(function ($game) {
                $game->user_best_score = $game->scores->max('score') ?? 0;
                $game->user_plays = $game->scores->count();
                $game->difficulty_color = match($game->difficulty) {
                    'easy' => 'bg-emerald-500',
                    'medium' => 'bg-yellow-500',
                    'hard' => 'bg-red-500',
                    'expert' => 'bg-purple-500',
                    default => 'bg-blue-500'
                };
                return $game;
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.game-arena-list');
    }
}
