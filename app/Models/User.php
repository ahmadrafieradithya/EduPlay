<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'school_id', 'avatar', 'level', 'total_xp'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'level' => 'integer',
            'total_xp' => 'integer',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function xp()
    {
        return $this->hasOne(UserXP::class);
    }

    public function streak()
    {
        return $this->hasOne(Streak::class);
    }

    public function xpTransactions()
    {
        return $this->hasMany(XPTransaction::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withTimestamps()
            ->withPivot('earned_at');
    }

    public function playerRating()
    {
        return $this->hasOne(PlayerRating::class);
    }

    public function codeSnippets()
    {
        return $this->hasMany(CodeSnippet::class);
    }
}
