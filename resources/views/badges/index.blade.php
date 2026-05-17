@extends('layouts.app')
@section('page-title', 'Badge Saya')
@section('content')
@php
$rarityConfig = [
'common'    => ['label' => 'Common',    'bg' => 'bg-slate-50 dark:bg-slate-800',   'border' => 'border-slate-200 dark:border-slate-700', 'badge' => 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300'],
'rare'      => ['label' => 'Rare',      'bg' => 'bg-blue-50 dark:bg-blue-950',     'border' => 'border-blue-200 dark:border-blue-800',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300'],
'epic'      => ['label' => 'Epic',      'bg' => 'bg-violet-50 dark:bg-violet-950', 'border' => 'border-violet-200 dark:border-violet-800','badge' => 'bg-violet-100 text-violet-700 dark:bg-violet-900 dark:text-violet-300'],
'legendary' => ['label' => 'Legendary', 'bg' => 'bg-amber-50 dark:bg-amber-950',   'border' => 'border-amber-300 dark:border-amber-700',  'badge' => 'bg-gradient-to-r from-amber-400 to-orange-400 text-white'],
];
@endphp
{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-7">
    @php $pct = ($stats['total_badges'] ?? 0) > 0 ? round(($stats['total_earned'] / $stats['total_badges']) * 100) : 0; @endphp
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center">
        <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $stats['total_earned'] ?? 0 }}<span class="text-base font-normal text-slate-400">/{{ $stats['total_badges'] ?? 0 }}</span></div>
        <div class="text-xs text-slate-500 mt-1">Badge Diraih</div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center">
        <div class="text-2xl font-black text-amber-600">{{ number_format($stats['xp_from_badges'] ?? 0) }}</div>
        <div class="text-xs text-slate-500 mt-1">XP dari Badge</div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center">
        <div class="text-2xl font-black text-indigo-600">{{ $pct }}%</div>
        <div class="text-xs text-slate-500 mt-1">Kelengkapan</div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center">
        <div class="text-2xl">{{ $stats['latest_badge']?->icon ?? '🔒' }}</div>
        <div class="text-xs text-slate-500 mt-1">{{ $stats['latest_badge']?->name ?? 'Belum Ada' }}</div>
    </div>
</div>
{{-- Filter --}}
<div class="flex gap-2 mb-6 flex-wrap">
    @foreach(['all' => '✨ Semua', 'common' => '⚪ Common', 'rare' => '🔵 Rare', 'epic' => '🟣 Epic', 'legendary' => '🟡 Legendary'] as $key => $label)
    <a href="{{ route('badges.index', ['rarity' => $key]) }}"
       class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all
              {{ $filter === $key ? 'bg-indigo-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-indigo-300' }}">
        {{ $label }}
    </a>
    @endforeach
</div>
{{-- Badge Grid --}}
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
    @forelse($allBadges as $badge)
    @php
        $isEarned = $earnedIds->contains($badge->id);
        $c = $rarityConfig[$badge->rarity] ?? $rarityConfig['common'];
    @endphp
    <div class="relative group {{ $c['bg'] }} rounded-2xl border {{ $isEarned ? $c['border'] : 'border-slate-100 dark:border-slate-800' }} p-5 text-center transition-all duration-300 {{ $isEarned ? 'hover:shadow-lg hover:-translate-y-0.5' : 'opacity-50' }}">
        @if(!$isEarned)
        <div class="absolute inset-0 rounded-2xl flex items-center justify-center bg-white/60 dark:bg-slate-900/60 backdrop-blur-[1px]">
            <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        @endif
        <div class="text-4xl mb-3">{{ $badge->icon }}</div>
        <div class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 line-clamp-2">{{ $badge->name }}</div>
        <span class="inline-block text-[9px] font-black {{ $c['badge'] }} px-2 py-0.5 rounded-full uppercase tracking-wider mb-2">{{ $c['label'] }}</span>
        @if($badge->xp_reward > 0)
        <div class="text-[10px] text-amber-600 font-bold">+{{ $badge->xp_reward }} XP</div>
        @endif
        @if($isEarned)
        <div class="text-[10px] text-green-600 mt-1">✅ Diraih!</div>
        @else
        <div class="text-[10px] text-slate-400 mt-1 line-clamp-2">{{ $badge->description }}</div>
        @endif
    {{-- Tooltip --}}
    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-44 bg-slate-900 text-white text-xs rounded-xl p-3 hidden group-hover:block z-20 shadow-xl text-left pointer-events-none">
        <p class="font-bold mb-1">{{ $badge->name }}</p>
        <p class="text-slate-300 text-[10px] leading-relaxed">{{ $badge->description }}</p>
    </div>
</div>
@empty
<div class="col-span-5 text-center py-20">
    <div class="text-5xl mb-4">🏅</div>
    <p class="text-slate-500">Belum ada badge. Jalankan seeder!</p>
</div>
@endforelse
</div>
@endsection