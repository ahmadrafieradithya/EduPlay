@extends('layouts.app')
@section('page-title', '🏆 Papan Peringkat')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">🏆 Papan Peringkat</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Lihat siapa yang paling aktif belajar!</p>
</div>

{{-- Filter Tabs --}}
<div class="flex gap-2 mb-8 border-b border-slate-200 dark:border-slate-700 pb-4">
    @foreach(['school' => '🏫 Sekolah', 'global' => '🌍 Global'] as $key => $label)
    <a href="{{ route('leaderboard.index', ['filter' => $key]) }}"
       class="px-4 py-2 rounded-t-lg font-semibold transition-all text-sm
              {{ $filter === $key 
                  ? 'bg-indigo-600 text-white border-b-2 border-indigo-600' 
                  : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Podium (Top 3) --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
    @php
        $medalEmojis = ['🥇', '🥈', '🥉'];
        $podiumColors = [
            'from-yellow-400 to-amber-500',
            'from-slate-300 to-slate-400',
            'from-orange-400 to-orange-600',
        ];
    @endphp
    @forelse($podium as $i => $entry)
    <div class="relative group">
        <div class="bg-gradient-to-br {{ $podiumColors[$i] }} rounded-2xl p-6 text-white text-center shadow-lg hover:shadow-xl transition-all">
            <div class="text-5xl mb-2">{{ $medalEmojis[$i] }}</div>
            
            {{-- Avatar --}}
            @if($entry->user->avatar)
            <img src="{{ $entry->user->avatar }}" alt="{{ $entry->user->name }}" 
                 class="w-20 h-20 rounded-full mx-auto mb-3 border-4 border-white">
            @else
            <div class="w-20 h-20 rounded-full mx-auto mb-3 border-4 border-white bg-white/20 flex items-center justify-center text-3xl">
                👤
            </div>
            @endif
            
            <h3 class="text-lg font-bold">{{ $entry->user->name }}</h3>
            <p class="text-sm opacity-90">{{ $entry->level?->title ?? 'Level 0' }} {{ $entry->level?->badge_icon ?? '' }}</p>
            <div class="mt-3 text-2xl font-black">{{ number_format($entry->total_xp) }} XP</div>
        </div>
    </div>
    @empty
    <div class="text-center text-slate-500 col-span-3 py-10">
        Belum ada data untuk podium
    </div>
    @endforelse
</div>

{{-- Main Leaderboard --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-lg">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-slate-800 dark:to-slate-800 border-b border-slate-200 dark:border-slate-700">
                <tr class="text-left">
                    <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Peringkat</th>
                    <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Pengguna</th>
                    <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Level</th>
                    <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">XP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaderboard as $entry)
                <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-indigo-50 dark:hover:bg-slate-800/50 transition-colors
                          {{ auth()->check() && $entry->user_id === auth()->id() ? 'bg-indigo-100 dark:bg-indigo-900/30 font-semibold' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($entry->rank <= 3)
                                <span class="text-2xl">{{ ['🥇', '🥈', '🥉'][$entry->rank - 1] }}</span>
                            @else
                                <span class="text-lg font-bold text-slate-400 dark:text-slate-500">#{{ $entry->rank }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($entry->user->avatar)
                            <img src="{{ $entry->user->avatar }}" alt="{{ $entry->user->name }}" 
                                 class="w-10 h-10 rounded-full object-cover">
                            @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold">
                                {{ substr($entry->user->name, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-800 dark:text-white">{{ $entry->user->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $entry->user->school?->name ?? 'Belum ada sekolah' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <span class="text-lg">{{ $entry->level?->badge_icon ?? '🔓' }}</span>
                            <span class="text-slate-600 dark:text-slate-400">{{ $entry->level?->title ?? 'Level 0' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-amber-600 dark:text-amber-400">{{ number_format($entry->total_xp) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                        Belum ada data papan peringkat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- User's Position Info (if ranked below 20) --}}
@if(auth()->check() && $myRank && $myRank > 20)
<div class="mt-8 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-slate-800 dark:to-slate-800 rounded-2xl border border-indigo-200 dark:border-slate-700 p-6">
    <div class="flex items-center gap-4">
        <div class="text-4xl">📍</div>
        <div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Posisi Anda</p>
            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">#{{ $myRank }} - {{ number_format($myXP->total_xp ?? 0) }} XP</p>
        </div>
    </div>
</div>
@endif
@endsection