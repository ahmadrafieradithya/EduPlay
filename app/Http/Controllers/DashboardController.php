<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\UserLessonProgress;
use App\Models\UserXP;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user()->load(['xp.level', 'streak', 'badges', 'school']);

        $totalXp = $user->xp?->total_xp ?? 0;
        $level = $user->xp?->level;
        $currentStreak = $user->streak?->current_streak ?? 0;

        $lessonsCompleted = UserLessonProgress::where('user_id', $user->id)
            ->where('status', 'completed')->count();

        $badgesCount = $user->badges()->count();

        // Top 5 leaderboard (school)
        $topStudents = UserXP::with('user')
            ->whereHas('user', fn($q) => $q->where('school_id', $user->school_id))
            ->orderBy('total_xp', 'desc')
            ->take(5)->get();

        // In-progress lessons
        $inProgressLessons = UserLessonProgress::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->with('lesson.topic.learningPath')
            ->latest()->take(3)->get();

        // Available games (featured)
        $featuredGames = Game::where('is_published', true)
            ->with('levels')
            ->take(3)->get();

        return view('dashboard', compact(
            'user', 'totalXp', 'level', 'currentStreak',
            'lessonsCompleted', 'badgesCount', 'topStudents',
            'inProgressLessons', 'featuredGames'
        ));
    }
}
