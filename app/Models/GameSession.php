<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameSession extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'score',
        'duration_seconds',
        'answers',
        'played_at',
    ];

    protected $casts = [
        'answers' => AsArrayObject::class,
        'played_at' => 'datetime',
        'score' => 'integer',
        'duration_seconds' => 'integer',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}