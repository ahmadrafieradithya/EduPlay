<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'logo',
        'address',
        'quota_students',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quota_students' => 'integer',
    ];

    // Scope untuk sekolah aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
