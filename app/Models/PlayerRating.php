<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'elo_rating',
        'wins',
        'losses',
        'rank_title',
    ];

    protected $casts = [
        'elo_rating' => 'integer',
        'wins' => 'integer',
        'losses' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getRankTitle(int $elo): string
    {
        if ($elo >= 1600) {
            return 'Platinum';
        }
        if ($elo >= 1400) {
            return 'Gold';
        }
        if ($elo >= 1200) {
            return 'Silver';
        }
        if ($elo >= 1000) {
            return 'Bronze';
        }
        return 'Pemula';
    }

    public function totalBattles(): int
    {
        return ($this->wins ?? 0) + ($this->losses ?? 0);
    }
}
