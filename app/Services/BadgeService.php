<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserLessonProgress;

class BadgeService
{
    /**
     * Check and award badges to user based on conditions
     */
    public function checkAndAward(User $user): array
    {
        $newBadges = [];

        // Get all available badges
        $badges = Badge::where('is_active', true)->get();

        foreach ($badges as $badge) {
            // Skip if user already has this badge
            if ($user->badges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }

            // Check if user meets the condition for this badge
            if ($this->meetsCondition($user, $badge->condition)) {
                $user->badges()->attach($badge->id, ['earned_at' => now()]);
                $newBadges[] = $badge;
            }
        }

        return $newBadges;
    }

    /**
     * Check if user meets a badge condition
     */
    private function meetsCondition(User $user, array $condition): bool
    {
        // lessons_completed
        if (isset($condition['lessons_completed'])) {
            $completedCount = UserLessonProgress::where('user_id', $user->id)
                ->where('status', UserLessonProgress::STATUS_COMPLETED)
                ->count();
            
            if ($completedCount < $condition['lessons_completed']) {
                return false;
            }
        }

        // total_xp
        if (isset($condition['total_xp'])) {
            if (!$user->xp || $user->xp->total_xp < $condition['total_xp']) {
                return false;
            }
        }

        // level requirement
        if (isset($condition['level'])) {
            if ($user->level < $condition['level']) {
                return false;
            }
        }

        // current_streak
        if (isset($condition['current_streak'])) {
            if (!$user->streak || $user->streak->current_streak < $condition['current_streak']) {
                return false;
            }
        }

        // games_won
        if (isset($condition['games_won'])) {
            // Requires game tracking implementation
            if (method_exists($user, 'gamesWon')) {
                $gamesWon = $user->gamesWon()->count();
                if ($gamesWon < $condition['games_won']) {
                    return false;
                }
            }
        }

        // paths_completed
        if (isset($condition['paths_completed'])) {
            // Check if user completed specific number of learning paths
            // This would require tracking completion of full paths
            if (method_exists($user, 'completedPaths')) {
                $completedPaths = $user->completedPaths()->count();
                if ($completedPaths < $condition['paths_completed']) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Award badge directly to user
     */
    public function awardBadge(User $user, Badge $badge): bool
    {
        if ($user->badges()->where('badge_id', $badge->id)->exists()) {
            return false;
        }

        $user->badges()->attach($badge->id, ['earned_at' => now()]);
        return true;
    }

    /**
     * Get badge progress for a user
     */
    public function getBadgeProgress(User $user, Badge $badge): array
    {
        $progress = [];

        if (isset($badge->condition['lessons_completed'])) {
            $completed = UserLessonProgress::where('user_id', $user->id)
                ->where('status', UserLessonProgress::STATUS_COMPLETED)
                ->count();
            $progress['lessons'] = [
                'current' => $completed,
                'needed' => $badge->condition['lessons_completed'],
            ];
        }

        if (isset($badge->condition['total_xp'])) {
            $current = $user->xp?->total_xp ?? 0;
            $progress['xp'] = [
                'current' => $current,
                'needed' => $badge->condition['total_xp'],
            ];
        }

        if (isset($badge->condition['current_streak'])) {
            $current = $user->streak?->current_streak ?? 0;
            $progress['streak'] = [
                'current' => $current,
                'needed' => $badge->condition['current_streak'],
            ];
        }

        return $progress;
    }
}
