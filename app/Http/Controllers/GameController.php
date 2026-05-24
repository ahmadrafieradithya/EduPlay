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
    public function play(Game $game, GameLevel $level)
    {
        abort_if(!$game->is_published, 404);
        abort_if($level->game_id !== $game->id, 404);

    // ← INI yang kurang: load semua level untuk selector
        $allLevels = $game->levels()->orderBy('level_number')->get();

        $viewMap = [
            'typing_race'     => 'games.play-typing',
            'speed_typing'    => 'games.play-typing',
            'bug_fix'         => 'games.play-bug-fix',
            'bug_hunter'      => 'games.play-bug-fix',
            'code_puzzle'     => 'games.play-code-puzzle',
            'puzzle'          => 'games.play-code-puzzle',
            'output_guessing' => 'games.play-output-guessing',
            'mcq'             => 'games.play-output-guessing',
            'html_builder'    => 'games.play-output-guessing',
            'fill_blank'      => 'games.play-output-guessing',
        ];

        $view = $viewMap[$game->type] ?? 'games.play';

        return view($view, compact('game', 'level', 'allLevels'));
    //                                              ↑ tambah allLevels di sini
    }
}