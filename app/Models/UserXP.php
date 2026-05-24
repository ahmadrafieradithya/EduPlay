<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserXP extends Model
{
    use HasFactory;

    protected $table = 'user_xp';

    protected $fillable = [
        'user_id',
        'total_xp',
        'level_id',
    ];

    protected $casts = [
        'total_xp' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
