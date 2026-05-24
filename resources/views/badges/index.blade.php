@extends('layouts.app')
@section('page-title', '🏅 Badge Saya')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">🏅 Koleksi Badge</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Raih badge dengan menyelesaikan tantangan dan target belajar!</p>
</div>

@php
$rarityConfig = [
    'common'    => ['label' => 'Common',    'bg' => 'bg-slate-50 dark:bg-slate-800',   'border' => 'border-slate-200 dark:border-slate-700', 'badge' => 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300', 'glow' => ''],
    'rare'      => ['label' => 'Rare',      'bg' => 'bg-blue-50 dark:bg-blue-950',     'border' => 'border-blue-200 dark:border-blue-800',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300', 'glow' => 'group-hover:shadow-blue-500/30'],
    'epic'      => ['label' => 'Epic',      'bg' => 'bg-violet-50 dark:bg-violet-950', 'border' => 'border-violet-200 dark:border-violet-800','badge' => 'bg-violet-100 text-violet-700 dark:bg-violet-900 dark:text-violet-300', 'glow' => 'group-hover:shadow-violet-500/30'],
    'legendary' => ['label' => 'Legendary', 'bg' => 'bg-amber-50 dark:bg-amber-950',   'border' => 'border-amber-300 dark:border-amber-700',  'badge' => 'bg-gradient-to-r from-amber-400 to-orange-400 text-white', 'glow' => 'group-hover:shadow-amber-500/50'],
];
@endphp

{{-- Stats Row --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    @php 
        $percentage = ($stats['total_badges'] ?? 0) > 0 ? round(($stats['total_earned'] / $stats['total_badges']) * 100) : 0;
    @endphp
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center hover:shadow-lg transition-all">
        <div class="text-2xl font-black text-slate-800 dark:text-white">
            {{ $stats['total_earned'] ?? 0 }}<span class="text-base font-normal text-slate-400">/{{ $stats['total_badges'] ?? 0 }}</span>
        </div>
        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">Badge Diraih</div>
    </div>
    
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center hover:shadow-lg transition-all">
        <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['xp_from_badges'] ?? 0) }}</div>
        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">XP dari Badge</div>
    </div>
    
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center hover:shadow-lg transition-all">
        <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $percentage }}%</div>
        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kelengkapan</div>
    </div>
    
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 text-center hover:shadow-lg transition-all">
        <div class="text-3xl">{{ $stats['latest_badge']?->icon ?? '🔒' }}</div>
        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 truncate">{{ $stats['latest_badge']?->name ?? 'Belum Ada' }}</div>
    </div>
</div>

{{-- Rarity Filter --}}
<div class="flex gap-2 mb-8 flex-wrap">
    @foreach(['all' => '✨ Semua', 'common' => '⚪ Common', 'rare' => '🔵 Rare', 'epic' => '🟣 Epic', 'legendary' => '🟡 Legendary'] as $key => $label)
    <a href="{{ route('badges.index', ['rarity' => $key]) }}"
       class="px-4 py-2 rounded-full text-xs font-semibold transition-all
              {{ $filter === $key 
                  ? 'bg-indigo-600 text-white shadow-md' 
                  : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-indigo-300 dark:hover:border-indigo-500' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Badge Grid --}}
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
    @forelse($allBadges as $badge)
    @php
        $isEarned = $earnedIds->contains($badge->id);
        $config = $rarityConfig[$badge->rarity] ?? $rarityConfig['common'];
    @endphp
    <div class="group relative">
        {{-- Badge Card --}}
        <div class="relative {{ $config['bg'] }} rounded-2xl border-2 {{ $isEarned ? $config['border'] : 'border-dashed border-slate-200 dark:border-slate-700' }} p-5 text-center transition-all duration-300
                    {{ $isEarned ? 'hover:shadow-lg hover:-translate-y-1 hover:shadow-slate-400/20 ' . $config['glow'] : 'opacity-40 hover:opacity-60' }}">
            
            {{-- Lock Icon (if not earned) --}}
            @if(!$isEarned)
            <div class="absolute top-2 right-2">
                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-300 dark:bg-slate-700">
                    <svg class="w-3.5 h-3.5 text-slate-600 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            @endif
            
            {{-- Badge Icon --}}
            <div class="text-5xl mb-3">{{ $badge->icon }}</div>
            
            {{-- Name --}}
            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 line-clamp-2 h-8 leading-4">
                {{ $badge->name }}
            </h3>
            
            {{-- Rarity Label --}}
            <span class="inline-block text-[9px] font-black {{ $config['badge'] }} px-2 py-1 rounded-full uppercase tracking-wider mb-2">
                {{ $config['label'] }}
            </span>
            
            {{-- XP Reward --}}
            @if($badge->xp_reward > 0)
            <div class="text-[10px] font-bold text-amber-600 dark:text-amber-400 mb-1">
                +{{ number_format($badge->xp_reward) }} XP
            </div>
            @endif
            
            {{-- Status --}}
            @if($isEarned)
            <div class="mt-2 text-[11px] font-bold text-green-600 dark:text-green-400 flex items-center justify-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Diraih!
            </div>
            @else
            <div class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 leading-tight line-clamp-2">
                {{ $badge->description }}
            </div>
            @endif
        </div>
        
        {{-- Tooltip --}}
        <div class="hidden group-hover:block absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-52 bg-slate-900 dark:bg-slate-800 text-white text-xs rounded-xl p-4 z-50 shadow-2xl pointer-events-none before:content-[''] before:absolute before:bottom-0 before:left-1/2 before:-translate-x-1/2 before:translate-y-full before:border-4 before:border-transparent before:border-t-slate-900 dark:before:border-t-slate-800">
            <p class="font-bold mb-1.5">{{ $badge->name }}</p>
            <p class="text-slate-300 leading-relaxed mb-2">{{ $badge->description }}</p>
            @if($badge->xp_reward > 0)
            <p class="text-amber-400 text-[9px] font-bold">💰 Hadiah: +{{ number_format($badge->xp_reward) }} XP</p>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-5 text-center py-20">
        <div class="text-6xl mb-4">🏅</div>
        <p class="text-slate-500 dark:text-slate-400 font-semibold">Belum ada badge tersedia</p>
        <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Jalankan <code class="text-xs bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">php artisan db:seed</code> untuk memuat data</p>
    </div>
    @endforelse
</div>
@endsection