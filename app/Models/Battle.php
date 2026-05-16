<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'challenger_id',
        'opponent_id',
        'game_level_id',
        'status',
        'winner_id',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function challenger()
    {
        return $this->belongsTo(User::class, 'challenger_id');
    }

    public function opponent()
    {
        return $this->belongsTo(User::class, 'opponent_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function gameLevel()
    {
        return $this->belongsTo(GameLevel::class);
    }

    public function results()
    {
        return $this->hasMany(BattleResult::class);
    }
}
