<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameSession extends Model
{
    protected $fillable = [
        'game_id',
        'game_level_id',
        'user_id',
        'score',
        'duration_seconds',
        'answers',
        'played_at',
        'metadata',
    ];

    protected $casts = [
        'answers' => AsArrayObject::class,
        'metadata' => AsArrayObject::class,
        'played_at' => 'datetime',
        'score' => 'integer',
        'duration_seconds' => 'integer',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(GameLevel::class, 'game_level_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}