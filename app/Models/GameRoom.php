<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameRoom extends Model
{
    protected $fillable = [
        'game_id',
        'room_code',
        'host_id',
        'max_players',
        'status',
        'started_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'max_players' => 'integer',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(GameRoomPlayer::class, 'room_id');
    }
}