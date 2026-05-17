<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'order',
        'difficulty',
        'is_published',
        'estimated_hours',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('order');
    }

    public function publishedTopics(): HasMany
    {
        return $this->hasMany(Topic::class)->where('is_published', true)->orderBy('order');
    }

    public function getTotalLessonsAttribute(): int
    {
        return $this->publishedTopics->flatMap->publishedLessons->count();
    }

    public function getProgressForUser(int $userId): int
    {
        $total = $this->total_lessons;
        if ($total === 0) return 0;
        
        $completed = UserLessonProgress::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereIn('lesson_id', $this->publishedTopics->flatMap->publishedLessons->pluck('id'))
            ->count();
        
        return (int) round(($completed / $total) * 100);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}