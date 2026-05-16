<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'battle_id',
        'user_id',
        'score',
        'is_winner',
        'accuracy',
        'time_seconds',
        'details',
    ];

    protected $casts = [
        'is_winner' => 'boolean',
        'details' => 'array',
    ];

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
