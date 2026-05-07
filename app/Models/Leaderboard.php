<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaderboard extends Model
{
    protected $fillable = [
        'school_id',
        'scope',
        'period',
        'data',
    ];

    protected $casts = [
        'data' => AsArrayObject::class,
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}