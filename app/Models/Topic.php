<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_path_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'order',
        'estimated_minutes',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function publishedLessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->where('is_published', true)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
