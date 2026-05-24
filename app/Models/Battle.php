<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
    'code',
    'host_id',        // ← pastikan ada ini
    'game_level_id',
    'status',
    'max_participants',
    'winner_id',
    'started_at',
    'ended_at',
];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'max_participants' => 'integer',
    ];

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(GameLevel::class, 'game_level_id');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'battle_participants')
            ->withPivot('joined_at')
            ->withTimestamps();
    }

    public static function generateCode(): string
    {
        do {
            $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function isFull(): bool
    {
        $max = $this->max_participants ?? 2;
        return $this->participants()->count() >= $max;
    }
}
