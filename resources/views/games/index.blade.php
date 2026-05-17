@extends('layouts.app')
@section('page-title', 'Game Arena')
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">🎮 Game Arena</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">5 jenis game coding seru! Kumpulkan XP dan buktikan kemampuanmu.</p>
</div>
@php
$gameConfig = [
'typing_race'     => ['icon' => '⌨️',  'gradient' => 'from-green-500 to-teal-500',    'desc' => 'Ketik kode secepat & seakurat mungkin'],
'bug_fix'         => ['icon' => '🐛',  'gradient' => 'from-red-500 to-orange-500',    'desc' => 'Temukan dan perbaiki bug dalam kode'],
'code_puzzle'     => ['icon' => '🧩',  'gradient' => 'from-blue-500 to-indigo-500',   'desc' => 'Susun potongan kode menjadi program benar'],
'output_guessing' => ['icon' => '🔮',  'gradient' => 'from-violet-500 to-purple-500', 'desc' => 'Tebak output dari kode yang diberikan'],
'html_builder'    => ['icon' => '🏗️', 'gradient' => 'from-amber-500 to-orange-500',  'desc' => 'Buat HTML sesuai tampilan yang diminta'],
// fallback untuk tipe lain
'puzzle'          => ['icon' => '🧩',  'gradient' => 'from-blue-500 to-indigo-500',   'desc' => 'Susun potongan kode menjadi program benar'],
'bug_hunter'      => ['icon' => '🐛',  'gradient' => 'from-red-500 to-orange-500',    'desc' => 'Temukan dan perbaiki bug dalam kode'],
'speed_typing'    => ['icon' => '⌨️',  'gradient' => 'from-green-500 to-teal-500',    'desc' => 'Ketik kode secepat & seakurat mungkin'],
'mcq'             => ['icon' => '❓',  'gradient' => 'from-violet-500 to-purple-500', 'desc' => 'Jawab pertanyaan web programming'],
'fill_blank'      => ['icon' => '✏️', 'gradient' => 'from-amber-500 to-orange-500',  'desc' => 'Isi bagian kode yang kosong'],
];
$diffLabel = [
'easy'   => ['t' => 'Mudah',  'c' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'],
'medium' => ['t' => 'Sedang', 'c' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300'],
'hard'   => ['t' => 'Sulit',  'c' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'],
'expert' => ['t' => 'Ahli',   'c' => 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'],
];
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($games as $game)
    @php
        $cfg       = $gameConfig[$game->type] ?? ['icon' => '🎮', 'gradient' => 'from-slate-500 to-slate-600', 'desc' => ''];
        $diff      = $diffLabel[$game->difficulty] ?? $diffLabel['easy'];
        $firstLvl  = $game->levels->sortBy('level_number')->first();
        $totalXp   = $game->levels->sum('xp_reward');
    @endphp
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
    <div class="relative bg-gradient-to-br {{ $cfg['gradient'] }} p-6 overflow-hidden">
        <div class="absolute -right-6 -top-6 text-8xl opacity-15">{{ $cfg['icon'] }}</div>
        <div class="relative flex items-start justify-between mb-3">
            <div class="text-3xl filter drop-shadow">{{ $cfg['icon'] }}</div>
            <span class="text-xs font-semibold {{ $diff['c'] }} px-2.5 py-1 rounded-full">{{ $diff['t'] }}</span>
        </div>
        <h3 class="relative text-lg font-bold text-white">{{ $game->title }}</h3>
        <p class="relative text-sm text-white/70 mt-1">{{ $cfg['desc'] }}</p>
    </div>

    <div class="p-5">
        <div class="flex items-center justify-between text-xs text-slate-400 mb-4">
            <span>📊 {{ $game->levels->count() }} Level</span>
            <span>⭐ Max {{ $totalXp }} XP</span>
            <span>🏆 Best: <strong class="text-indigo-600 dark:text-indigo-400">{{ $game->user_best_score ?: '-' }}</strong></span>
        </div>

        <div class="flex gap-2 mb-5">
            @foreach($game->levels->sortBy('level_number') as $level)
            <div class="flex-1 text-center py-1.5 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-500">
                Lv.{{ $level->level_number }}<div class="text-[10px] font-normal">+{{ $level->xp_reward }}XP</div>
            </div>
            @endforeach
        </div>

        @if($firstLvl)
        <a href="{{ route('games.play', [$game->id, $firstLvl->id]) }}"
           class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r {{ $cfg['gradient'] }} hover:opacity-90 active:scale-95 transition-all shadow-md">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            {{ $game->user_plays > 0 ? 'Main Lagi' : 'Main Sekarang' }}
        </a>
        @endif
    </div>
</div>
@empty
<div class="col-span-3 text-center py-20">
    <div class="text-5xl mb-4">🎮</div>
    <p class="text-slate-500">Belum ada game tersedia.</p>
    <p class="text-slate-400 text-sm mt-1">Jalankan <code>php artisan db:seed</code></p>
</div>
@endforelse
</div>
@endsection