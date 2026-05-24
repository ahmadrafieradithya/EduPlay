@extends('layouts.app')
@section('page-title', $game->title . ' — ' . $level->title)
@section('content')

<div class="mb-5">
    <a href="{{ route('games.index') }}" class="flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Game Arena
    </a>
</div>

<div class="max-w-2xl mx-auto bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center">
    <div class="text-5xl mb-4">🎮</div>
    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2">{{ $game->title }}</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mb-2">{{ $level->title }}</p>
    <div class="flex items-center justify-center gap-4 text-sm text-slate-400 mb-8">
        <span>⏱ {{ $level->time_limit }} detik</span>
        <span>⭐ +{{ $level->xp_reward }} XP</span>
    </div>
    <div class="bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 rounded-xl p-4 text-sm text-amber-700 dark:text-amber-300">
        🚧 Game ini sedang dalam pengembangan. Segera hadir!
    </div>
    <a href="{{ route('games.index') }}" class="inline-block mt-6 bg-indigo-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition-colors">
        ← Kembali ke Game Arena
    </a>
</div>

@endsection