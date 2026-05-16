<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserXP;

class XPService
{
    public function award(User $user, string $action, int $xpAmount, array $metadata = []): UserXP
    {
        $userXp = $user->xp ?? $user->xp()->create(['total_xp' => 0]);
        $userXp->increment('total_xp', $xpAmount);

        // Log XP transaction if the model exists
        if (method_exists($user, 'xpTransactions')) {
            $user->xpTransactions()->create([
                'action' => $action,
                'xp_amount' => $xpAmount,
                'metadata' => $metadata,
            ]);
        }

        return $userXp;
    }

    public function deduct(User $user, string $action, int $xpAmount, array $metadata = []): UserXP
    {
        $userXp = $user->xp ?? $user->xp()->create(['total_xp' => 0]);
        $userXp->decrement('total_xp', max(0, $xpAmount));

        if (method_exists($user, 'xpTransactions')) {
            $user->xpTransactions()->create([
                'action' => $action,
                'xp_amount' => -$xpAmount,
                'metadata' => $metadata,
            ]);
        }

        return $userXp;
    }

    public function getUserLevel(int $totalXp): array
    {
        // Define level thresholds
        $levels = [
            1 => ['min_xp' => 0, 'max_xp' => 100, 'title' => 'Murid Baru'],
            2 => ['min_xp' => 100, 'max_xp' => 250, 'title' => 'Murid Aktif'],
            3 => ['min_xp' => 250, 'max_xp' => 500, 'title' => 'Penggiat'],
            4 => ['min_xp' => 500, 'max_xp' => 1000, 'title' => 'Juara'],
            5 => ['min_xp' => 1000, 'max_xp' => 2000, 'title' => 'Master'],
            6 => ['min_xp' => 2000, 'max_xp' => 5000, 'title' => 'Legend'],
        ];

        foreach ($levels as $levelNum => $data) {
            if ($totalXp >= $data['min_xp'] && $totalXp < $data['max_xp']) {
                return [
                    'level' => $levelNum,
                    'title' => $data['title'],
                    'min_xp' => $data['min_xp'],
                    'max_xp' => $data['max_xp'],
                    'progress' => round((($totalXp - $data['min_xp']) / ($data['max_xp'] - $data['min_xp'])) * 100, 2),
                ];
            }
        }

        // Max level reached
        return [
            'level' => count($levels),
            'title' => 'Legend',
            'min_xp' => end($levels)['min_xp'],
            'max_xp' => end($levels)['max_xp'],
            'progress' => 100,
        ];
    }
}
