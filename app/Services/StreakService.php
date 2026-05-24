<?php

namespace App\Services;

use App\Models\User;
use App\Models\Streak;

class StreakService
{
    /**
     * Update user's learning streak
     */
    public function updateStreak(User $user): Streak
    {
        $streak = $user->streak ?? $user->streak()->create([
            'current_streak' => 0,
            'longest_streak' => 0,
            'last_activity_date' => null,
        ]);

        $now = now();
        $lastActivity = $streak->last_activity_date;

        // Check if user already did activity today
        if ($lastActivity && $lastActivity->toDateString() === $now->toDateString()) {
            return $streak;
        }

        // Check if it's a consecutive day
        if ($lastActivity && $lastActivity->diffInDays($now) === 1) {
            $streak->current_streak++;
        } elseif (!$lastActivity || $lastActivity->diffInDays($now) > 1) {
            // Reset streak if gap > 1 day
            $streak->current_streak = 1;
        }

        // Update longest streak
        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_activity_date = $now->toDateString();
        $streak->save();

        return $streak;
    }

    /**
     * Reset user's current streak
     */
    public function resetStreak(User $user): void
    {
        $streak = $user->streak;
        if ($streak) {
            $streak->update(['current_streak' => 0]);
        }
    }

    /**
     * Check if user's streak should be reset (missed activity day)
     */
    public function checkStreakReset(User $user): bool
    {
        $streak = $user->streak;
        if (!$streak || !$streak->last_activity_date) {
            return false;
        }

        $daysSinceLastActivity = $streak->last_activity_date->diffInDays(now());
        
        if ($daysSinceLastActivity > 1) {
            $this->resetStreak($user);
            return true;
        }

        return false;
    }

    /**
     * Get streak info for display
     */
    public function getStreakInfo(User $user): array
    {
        $streak = $user->streak;

        if (!$streak) {
            return [
                'current' => 0,
                'longest' => 0,
                'active' => false,
                'daysRemaining' => 0,
            ];
        }

        $isActive = !$streak->last_activity_date || 
                   $streak->last_activity_date->diffInDays(now()) <= 1;

        $daysRemaining = $isActive && $streak->last_activity_date?->toDateString() !== now()->toDateString() 
            ? 0 
            : 1;

        return [
            'current' => $streak->current_streak,
            'longest' => $streak->longest_streak,
            'active' => $isActive,
            'daysRemaining' => $daysRemaining,
            'lastActivityDate' => $streak->last_activity_date,
        ];
    }
}
