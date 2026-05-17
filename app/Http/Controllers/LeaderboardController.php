<?php

namespace App\Http\Controllers;

use App\Models\UserXP;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'school');

        $query = UserXP::with([
            'user' => fn($q) => $q->with(['streak', 'school'])
        ])->orderBy('total_xp', 'desc');

        if ($filter === 'class') {
            $classId = auth()->user()->profile?->class_id;
            if ($classId) {
                $query->whereHas('user', fn($q) => $q->whereHas('classes', fn($q2) => $q2->where('id', $classId)));
            }
        } elseif ($filter === 'school') {
            $query->whereHas('user', fn($q) => $q->where('school_id', auth()->user()->school_id));
        }
        // 'global' → no additional filter
        // 'weekly' → filter by last 7 days activity

        $leaderboard = $query->get()->map(function ($entry, $index) {
            $entry->rank = $index + 1;
            $entry->movement = $this->calculateMovement($entry->user_id); // up, down, or same
            return $entry;
        });

        $myRank = $leaderboard->search(fn($e) => $e->user_id === auth()->id());
        $myRank = $myRank !== false ? $myRank + 1 : null;

        $podium = $leaderboard->take(3);

        // Tambahkan ini sebelum return view
        $myXP = UserXP::where('user_id', auth()->id())->first();

        return view('leaderboard.index', compact('leaderboard', 'myRank', 'filter', 'podium', 'myXP'));
        
    }

    private function calculateMovement($userId)
    {
        // In a real implementation, you would query yesterday's rank vs today's rank
        // For now, return 'same' as default
        return 'same'; // Can be 'up', 'down', or 'same'
    }
}
