<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserXP;
use App\Models\Level;

class XPService
{
    /**
     * Award XP to a user
     */
    public function award(User $user, string $reason, int $amount, array $metadata = []): UserXP
    {
        $userXp = $user->xp ?? $user->xp()->create(['total_xp' => 0]);
        $userXp->increment('total_xp', $amount);

        // Refresh to get updated XP
        $userXp->refresh();

        // Check for level up
        $newLevel = Level::findLevelByXp($userXp->total_xp);
        if ($newLevel && $userXp->level_id !== $newLevel->id) {
            $userXp->update(['level_id' => $newLevel->id]);
            $user->update(['level' => $newLevel->level_number, 'total_xp' => $userXp->total_xp]);
        } else {
            $user->update(['total_xp' => $userXp->total_xp]);
        }

        // Log XP transaction if the model exists
        if (method_exists($user, 'xpTransactions')) {
            $user->xpTransactions()->create([
                'action' => $reason,
                'xp_amount' => $amount,
                'metadata' => $metadata,
            ]);
        }

        return $userXp;
    }

    /**
     * Deduct XP from a user
     */
    public function deduct(User $user, string $reason, int $amount, array $metadata = []): UserXP
    {
        $userXp = $user->xp ?? $user->xp()->create(['total_xp' => 0]);
        $newTotal = max(0, $userXp->total_xp - $amount);
        $userXp->update(['total_xp' => $newTotal]);
        $userXp->refresh();

        // Check for level down
        $newLevel = Level::findLevelByXp($newTotal);
        if ($newLevel && $userXp->level_id !== $newLevel->id) {
            $userXp->update(['level_id' => $newLevel->id]);
            $user->update(['level' => $newLevel->level_number, 'total_xp' => $newTotal]);
        } else {
            $user->update(['total_xp' => $newTotal]);
        }

        if (method_exists($user, 'xpTransactions')) {
            $user->xpTransactions()->create([
                'action' => $reason,
                'xp_amount' => -$amount,
                'metadata' => $metadata,
            ]);
        }

        return $userXp;
    }

    /**
     * Get user's current level info based on total XP
     */
    public function getUserLevel(int $totalXp): ?Level
    {
        return Level::findLevelByXp($totalXp);
    }

    /**
     * Get XP progress to next level
     */
    public function getProgressToNextLevel(User $user): array
    {
        $userXp = $user->xp;
        if (!$userXp) {
            return ['current' => 0, 'needed' => 0, 'nextLevel' => null, 'percentage' => 0];
        }

        $currentLevel = Level::findLevelByXp($userXp->total_xp);
        if (!$currentLevel) {
            return ['current' => 0, 'needed' => 0, 'nextLevel' => null, 'percentage' => 0];
        }

        $nextLevel = Level::where('level_number', '>', $currentLevel->level_number)->first();
        if (!$nextLevel) {
            return [
                'current' => $userXp->total_xp,
                'needed' => $currentLevel->max_xp,
                'nextLevel' => null,
                'percentage' => 100,
                'isMaxLevel' => true,
            ];
        }

        $xpIntoLevel = $userXp->total_xp - $currentLevel->min_xp;
        $xpForLevel = $currentLevel->max_xp - $currentLevel->min_xp;
        $percentage = $xpForLevel > 0 ? round(($xpIntoLevel / $xpForLevel) * 100, 2) : 0;

        return [
            'current' => $xpIntoLevel,
            'needed' => $xpForLevel,
            'nextLevel' => $nextLevel,
            'percentage' => $percentage,
            'isMaxLevel' => false,
        ];
    }
}
