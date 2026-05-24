<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $fillable = [
        'code',
        'host_id',
        'challenger_id',
        'game_level_id',
        'status',
        'max_participants',
        'winner_id',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    // Relasi ke user yang buat battle
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    // Relasi ke pemenang
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    // Relasi ke game level
    public function level()
    {
        return $this->belongsTo(GameLevel::class, 'game_level_id');
    }

    // Relasi ke peserta battle (TANPA joined_at)
    public function participants()
    {
        return $this->belongsToMany(User::class, 'battle_participants')
                    ->withPivot('score', 'answer', 'is_correct', 'is_ready', 'response_time_seconds', 'submitted_at')
                    ->withTimestamps();
    }

    // Generate kode unik 6 karakter
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('code', $code)->exists());
        return $code;
    }

    public function isFull(): bool
    {
        return $this->participants()->count() >= $this->max_participants;
    }
}