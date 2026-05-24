<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BadgeController extends Controller
{
    /**
     * Display all badges with filtering by rarity
     */
    public function index(Request $request): View
    {
        $filter = $request->get('rarity', 'all');

        // Get all active badges
        $query = Badge::where('is_active', true);

        // Filter by rarity if not 'all'
        if ($filter !== 'all') {
            $query->where('rarity', $filter);
        }

        // Order by rarity (legendary first) then by category
        $rarityOrder = ['legendary' => 1, 'epic' => 2, 'rare' => 3, 'common' => 4];
        $allBadges = $query->get()
            ->sortBy(function ($badge) use ($rarityOrder) {
                return [$rarityOrder[$badge->rarity] ?? 5, $badge->category ?? '', $badge->name];
            })
            ->values();

        // Get earned badge IDs for current user
        $earnedIds = collect();
        if (auth()->check()) {
            $earnedIds = auth()->user()->badges()
                ->pluck('badge_id')
                ->collect();
        }

        // Calculate stats
        $totalBadges = Badge::where('is_active', true)->count();
        $totalEarned = $earnedIds->count();
        $xpFromBadges = $earnedIds->isNotEmpty()
            ? Badge::whereIn('id', $earnedIds)->sum('xp_reward')
            : 0;

        $latestBadge = null;
        if (auth()->check() && $earnedIds->isNotEmpty()) {
            $latestBadge = Badge::whereIn('id', $earnedIds)
                ->latest('updated_at')
                ->first();
        }

        $stats = [
            'total_earned' => $totalEarned,
            'total_badges' => $totalBadges,
            'xp_from_badges' => $xpFromBadges,
            'latest_badge' => $latestBadge,
        ];

        return view('badges.index', compact('allBadges', 'filter', 'earnedIds', 'stats'));
    }
}

