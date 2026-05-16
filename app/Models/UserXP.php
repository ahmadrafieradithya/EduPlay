<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserXP extends Model
{
    use HasFactory;

    protected $table = 'user_xp';

    protected $fillable = [
        'user_id',
        'total_xp',
        'level_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
