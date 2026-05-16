<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameLevel;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::published()
            ->with(['levels', 'scores' => fn($q) => $q->where('user_id', auth()->id())])
            ->get()
            ->map(function ($game) {
                $game->user_best_score = $game->scores->max('score') ?? 0;
                $game->user_plays = $game->scores->count();
                return $game;
            });

        return view('games.index', compact('games'));
    }

    public function play(Game $game, GameLevel $level)
    {
        abort_if(!$game->is_published, 404);

        return view('games.play', compact('game', 'level'));
    }
}
