<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = [
        'level_number',
        'title',
        'min_xp',
        'max_xp',
        'badge_icon',
        'perks',
    ];

    protected $casts = [
        'perks' => 'array',
        'level_number' => 'integer',
        'min_xp' => 'integer',
        'max_xp' => 'integer',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(UserXP::class);
    }

    public static function findLevelByXp(int $xp): ?self
    {
        return self::where('min_xp', '<=', $xp)
            ->where('max_xp', '>=', $xp)
            ->first();
    }
}