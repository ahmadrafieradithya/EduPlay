<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
