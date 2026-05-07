<?php

use App\Models\Classroom;
use App\Models\UserAchievement;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'progressCount' => UserProgress::where('user_id', auth()->id())->count(),
            'xpEarned' => UserProgress::where('user_id', auth()->id())->sum('score'),
            'achievementCount' => UserAchievement::where('user_id', auth()->id())->count(),
            'classroomCount' => Classroom::count(),
        ]);
    })->name('dashboard');
});
