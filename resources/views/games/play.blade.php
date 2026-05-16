@extends('layouts.app')

@section('page-title', 'Main Game')
@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-950">
    <div class="flex items-center justify-between gap-4">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-indigo-600">Game Arena</p>
            <h1 class="mt-2 text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $game->title }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Level {{ $level->level_number ?? $level->id }}</p>
        </div>
        <a href="{{ route('games.index') }}" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">Kembali</a>
    </div>
    <div class="mt-6 rounded-3xl bg-slate-50 p-6 text-slate-600 dark:bg-slate-900 dark:text-slate-300">
        Halaman level selection belum tersedia. Nantikan pembaruan selanjutnya untuk mulai bermain.
    </div>
</div>
@endsection
