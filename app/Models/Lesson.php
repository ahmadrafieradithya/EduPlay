<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'type',
        'content',
        'video_url',
        'order',
        'xp_reward',
        'is_published',
        'is_free',
        'duration_minutes',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_free' => 'boolean',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function isCompletedBy(int $userId): bool
    {
        return $this->progress()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->exists();
    }

    public function isBookmarkedBy(int $userId): bool
    {
        return $this->bookmarks()
            ->where('user_id', $userId)
            ->exists();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
