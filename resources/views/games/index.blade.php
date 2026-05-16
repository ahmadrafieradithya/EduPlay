@extends('layouts.app')

@section('page-title', 'Game Arena')
@section('content')

@php
    $gameMeta = [
        'Code Puzzle' => [
            'emoji' => '🧩',
            'description' => 'Susun potongan kode dan selesaikan tantangan logika.',
            'difficulty' => 'Sedang',
        ],
        'Bug Hunter' => [
            'emoji' => '🐛',
            'description' => 'Temukan dan perbaiki bug dalam potongan kode.',
            'difficulty' => 'Mudah',
        ],
        'Speed Typing' => [
            'emoji' => '⌨️',
            'description' => 'Ketik kode secepat mungkin sebelum waktu habis.',
            'difficulty' => 'Sedang',
        ],
        'Quiz Code' => [
            'emoji' => '❓',
            'description' => 'Tebak output atau teori pemrograman.',
            'difficulty' => 'Mudah',
        ],
        'Fill the Blank' => [
            'emoji' => '✏️',
            'description' => 'Isi bagian kode yang kosong untuk memperbaiki program.',
            'difficulty' => 'Sulit',
        ],
    ];
@endphp

<div class="space-y-5">
    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Game Arena</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900 dark:text-slate-100">Pilih tantangan gamemu</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Mainkan game edukasi dan tingkatkan skor sambil belajar.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-900">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-2">
        @forelse($games as $game)
            @php
                $meta = $gameMeta[$game->title] ?? [
                    'emoji' => '🎮',
                    'description' => $game->type ? 'Permainan ' . $game->type : 'Tantangan interaktif.',
                    'difficulty' => 'Sedang',
                ];
                $firstLevel = $game->levels->first();
                $playUrl = $firstLevel ? route('games.play', [$game, $firstLevel]) : '#';
            @endphp
            <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 transition hover:-translate-y-1 hover:shadow-md dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center justify-center w-14 h-14 rounded-3xl bg-indigo-50 text-3xl shadow-sm dark:bg-indigo-950">{{ $meta['emoji'] }}</div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $meta['difficulty'] }}</span>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $game->title }}</h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $meta['description'] }}</p>
                </div>
                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-900">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Best Score</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ number_format($game->user_best_score) }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-900">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Level tersedia</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $game->levels->count() }}</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a href="{{ $playUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Main Sekarang
                    </a>
                    @if($game->levels->isEmpty())
                        <span class="text-xs text-rose-500">Belum ada level aktif</span>
                    @endif
                </div>
            </article>
        @empty
            @foreach(['Code Puzzle', 'Bug Hunter', 'Speed Typing', 'Quiz Code', 'Fill the Blank'] as $title)
                @php
                    $meta = $gameMeta[$title];
                @endphp
                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-950">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center justify-center w-14 h-14 rounded-3xl bg-indigo-50 text-3xl dark:bg-indigo-950">{{ $meta['emoji'] }}</div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $meta['difficulty'] }}</span>
                    </div>
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h2>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $meta['description'] }}</p>
                    </div>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-900">
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Best Score</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">0</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-900">
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Level tersedia</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">0</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button disabled class="inline-flex items-center justify-center rounded-2xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-500">
                            Main Sekarang
                        </button>
                    </div>
                </article>
            @endforeach
        @endforelse
    </div>
</div>

@endsection
