<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}