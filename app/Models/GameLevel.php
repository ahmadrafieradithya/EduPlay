<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'level_number',
        'title',
        'content',
        'time_limit',
        'xp_reward',
        'min_score_to_pass',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function sessions()
    {
        return $this->hasMany(GameSession::class);
    }
}
