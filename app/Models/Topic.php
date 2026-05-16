<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
