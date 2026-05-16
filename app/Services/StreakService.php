<?php

namespace App\Services;

use App\Models\User;
use App\Models\Streak;
use Carbon\Carbon;

class StreakService
{
    public function updateStreak(User $user): Streak
    {
        $streak = $user->streak ?? $user->streak()->create([
            'current_streak' => 0,
            'longest_streak' => 0,
            'last_activity_at' => null,
        ]);

        $now = now();
        $lastActivity = $streak->last_activity_at;

        // Check if user already did activity today
        if ($lastActivity && $lastActivity->toDateString() === $now->toDateString()) {
            return $streak;
        }

        // Check if it's a consecutive day
        if ($lastActivity && $lastActivity->diffInDays($now) === 1) {
            $streak->current_streak++;
        } elseif (!$lastActivity || $lastActivity->diffInDays($now) > 1) {
            $streak->current_streak = 1;
        }

        // Update longest streak
        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_activity_at = $now;
        $streak->save();

        return $streak;
    }

    public function resetStreak(User $user): void
    {
        $streak = $user->streak;
        if ($streak) {
            $streak->update(['current_streak' => 0]);
        }
    }

    public function getStreakStatus(User $user): array
    {
        $streak = $user->streak;

        if (!$streak) {
            return [
                'current' => 0,
                'longest' => 0,
                'status' => 'inactive',
                'message' => 'Mulai sekarang untuk membangun streak!',
            ];
        }

        $lastActivity = $streak->last_activity_at;
        $now = now();

        if (!$lastActivity) {
            return [
                'current' => 0,
                'longest' => $streak->longest_streak,
                'status' => 'inactive',
                'message' => 'Mulai sekarang untuk membangun streak!',
            ];
        }

        $daysSinceLastActivity = $lastActivity->diffInDays($now);

        $status = match (true) {
            $daysSinceLastActivity === 0 => 'active_today',
            $daysSinceLastActivity === 1 => 'active',
            default => 'broken',
        };

        return [
            'current' => $streak->current_streak,
            'longest' => $streak->longest_streak,
            'status' => $status,
            'message' => match ($status) {
                'active_today' => 'Kamu sudah belajar hari ini! 🔥',
                'active' => 'Streak masih berlanjut! 🔥',
                default => 'Streak putus. Mulai lagi untuk rebuild! 💪',
            },
        ];
    }
}
