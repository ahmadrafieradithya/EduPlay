<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'rarity',
        'category',
        'condition',
        'xp_reward',
        'is_active',
    ];
    protected $casts = [
        'condition' => 'array',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withTimestamps()
            ->withPivot('earned_at');
    }
}
