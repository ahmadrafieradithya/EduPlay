<?php

namespace App\Http\Controllers;

use App\Models\UserXP;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Display leaderboard with filtering options
     */
    public function index(Request $request): View
    {
        $filter = $request->get('filter', 'school');

        $query = UserXP::with([
            'user' => fn($q) => $q->select('id', 'name', 'email', 'avatar', 'school_id')->with('school'),
            'level'
        ])->orderBy('total_xp', 'desc')->take(100);

        // Apply filter
        if ($filter === 'school' && auth()->check()) {
            $schoolId = auth()->user()->school_id;
            if ($schoolId) {
                $query->whereHas('user', fn($q) => $q->where('school_id', $schoolId));
            }
        }
        // 'global' → no filter, show all users
        // 'weekly' → would filter by recent activity dates

        $allLeaderboard = $query->get();

        // Add rank and prepare for display (show top 20)
        $leaderboard = $allLeaderboard
            ->map(function ($entry, $index) {
                $entry->rank = $index + 1;
                return $entry;
            })
            ->take(20);

        // Get podium (top 3)
        $podium = $allLeaderboard->take(3)->map(function ($entry, $index) {
            $entry->rank = $index + 1;
            return $entry;
        });

        // Find user's rank
        $myRank = null;
        if (auth()->check()) {
            $userXp = $allLeaderboard->firstWhere('user_id', auth()->id());
            $myRank = $userXp ? $allLeaderboard->search($userXp) + 1 : null;
            $myXP = $userXp;
        }

        return view('leaderboard.index', compact('leaderboard', 'myRank', 'myXP', 'filter', 'podium', 'allLeaderboard'));
    }
}

