<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XPTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'xp_amount',
        'metadata',
    ];

    protected $casts = [
        'xp_amount' => 'integer',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
