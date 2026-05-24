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
        $userId = auth()->id();
        
        $this->games = Game::where('is_active', true)
            ->where('is_published', true)
            ->with('levels')
            ->get()
            ->map(function ($game) use ($userId) {
                // Load user sessions directly (scores are stored in GameSession.score)
                $userSessions = $game->sessions()
                    ->where('user_id', $userId)
                    ->get();
                
                $game->user_best_score = $userSessions->max('score') ?? 0;
                $game->user_plays = $userSessions->count();
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
