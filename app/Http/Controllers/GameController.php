<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameLevel;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * Show all published games with user progress
     */
    public function index(): View
    {
        $userId = auth()->id();

        $games = Game::published()
            ->with('levels')
            ->get()
            ->map(function ($game) use ($userId) {
                // Load user sessions directly (scores are stored in GameSession.score)
                $userSessions = $game->sessions()
                    ->where('user_id', $userId)
                    ->get();
                
                $game->user_best_score = $userSessions->max('score') ?? 0;
                $game->user_plays = $userSessions->count();
                return $game;
            });

        return view('games.index', compact('games'));
    }

    /**
     * Play a specific game level - route to appropriate game view
     */
    public function play(Game $game, GameLevel $level): View
    {
        abort_if(!$game->is_published, 404);

        // Route to the appropriate game view based on type
        $view = match ($game->type) {
            'typing_race' => 'games.play-typing',
            'quiz' => 'games.play-quiz',
            'bug_fix' => 'games.play-bug-fix',
            'code_puzzle' => 'games.play-code-puzzle',
            'output_guessing' => 'games.play-output-guessing',
            default => 'games.play',
        };

        return view($view, compact('game', 'level'));
    }
}
