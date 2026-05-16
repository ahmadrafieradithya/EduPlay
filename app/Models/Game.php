<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Game extends Model
{
    protected $fillable = [
        'school_id',
        'title',
        'type',
        'config',
        'course_id',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'config' => AsArrayObject::class,
        'is_active' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(GameSession::class);
    }

    public function levels(): HasMany
    {
        return $this->hasMany(GameLevel::class);
    }

    public function scores(): HasManyThrough
    {
        return $this->hasManyThrough(GameScore::class, GameSession::class, 'game_id', 'game_session_id');
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->is_active;
    }

    public function scopePublished($query)
    {
        return $query->active();
    }

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }
}