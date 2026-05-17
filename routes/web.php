<?php

use App\Http\Controllers\BadgeController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LearnController;
use App\Models\Classroom;
use App\Models\UserAchievement;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/belajar', [LearnController::class, 'index'])->name('learn.index');
    Route::get('/belajar/lesson/{lesson}', [LearnController::class, 'lesson'])->name('learn.lesson');
    Route::get('/belajar/bookmarks', [LearnController::class, 'bookmarks'])->name('learn.bookmarks');
    Route::get('/belajar/{path:slug}', [LearnController::class, 'path'])->name('learn.path');
    Route::get('/game', [GameController::class, 'index'])->name('games.index');
    Route::get('/game/{game}/play/{level}', [GameController::class, 'play'])->name('games.play');
    Route::get('/battle', [BattleController::class, 'index'])->name('battle.index');
    Route::get('/editor', [EditorController::class, 'index'])->name('editor.index');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/badge', [BadgeController::class, 'index'])->name('badges.index');
});
