<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService
{
    public function checkAndAward(User $user): array
    {
        $newBadges = [];

        // Check for various badge conditions
        $badges = $this->determineBadges($user);

        foreach ($badges as $badgeSlug) {
            $badge = Badge::where('slug', $badgeSlug)->first();
            if ($badge && !$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge->id, ['earned_at' => now()]);
                $newBadges[] = $badge;
            }
        }

        return $newBadges;
    }

    private function determineBadges(User $user): array
    {
        $badges = [];
        $userXp = $user->xp;
        $streak = $user->streak;
        $completedLessons = $user->progress()
            ->where('status', 'completed')
            ->count();

        // XP-based badges
        if ($userXp?->total_xp >= 100) {
            $badges[] = 'first_hundred_xp';
        }
        if ($userXp?->total_xp >= 500) {
            $badges[] = 'five_hundred_xp';
        }
        if ($userXp?->total_xp >= 1000) {
            $badges[] = 'thousand_xp';
        }

        // Lesson-based badges
        if ($completedLessons >= 1) {
            $badges[] = 'first_lesson';
        }
        if ($completedLessons >= 5) {
            $badges[] = 'five_lessons';
        }
        if ($completedLessons >= 10) {
            $badges[] = 'ten_lessons';
        }

        // Streak-based badges
        if ($streak?->current_streak >= 3) {
            $badges[] = 'three_day_streak';
        }
        if ($streak?->current_streak >= 7) {
            $badges[] = 'week_streak';
        }
        if ($streak?->longest_streak >= 30) {
            $badges[] = 'month_streak';
        }

        return array_unique($badges);
    }

    public function getUnlockedBadges(User $user)
    {
        return $user->badges()
            ->with('pivot')
            ->orderBy('user_badges.earned_at', 'desc')
            ->get();
    }

    public function getProgressBadges(User $user): array
    {
        $allBadges = Badge::all();
        $unlockedIds = $user->badges()->pluck('badge_id')->toArray();

        $badges = [];
        foreach ($allBadges as $badge) {
            $isUnlocked = in_array($badge->id, $unlockedIds);
            $progress = $this->getBadgeProgress($user, $badge->slug);

            $badges[] = [
                'badge' => $badge,
                'unlocked' => $isUnlocked,
                'progress' => $progress,
            ];
        }

        return $badges;
    }

    private function getBadgeProgress(User $user, string $slug): array
    {
        $userXp = $user->xp?->total_xp ?? 0;
        $completedLessons = $user->progress()->where('status', 'completed')->count();
        $streak = $user->streak?->current_streak ?? 0;

        return match ($slug) {
            'first_hundred_xp' => ['current' => min($userXp, 100), 'target' => 100],
            'five_hundred_xp' => ['current' => min($userXp, 500), 'target' => 500],
            'thousand_xp' => ['current' => min($userXp, 1000), 'target' => 1000],
            'first_lesson' => ['current' => min($completedLessons, 1), 'target' => 1],
            'five_lessons' => ['current' => min($completedLessons, 5), 'target' => 5],
            'ten_lessons' => ['current' => min($completedLessons, 10), 'target' => 10],
            'three_day_streak' => ['current' => min($streak, 3), 'target' => 3],
            'week_streak' => ['current' => min($streak, 7), 'target' => 7],
            'month_streak' => ['current' => min($streak, 30), 'target' => 30],
            default => ['current' => 0, 'target' => 1],
        };
    }
}
