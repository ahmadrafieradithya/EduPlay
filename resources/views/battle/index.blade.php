@extends('layouts.app')
@section('page-title', 'Battle Mode')
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">⚔️ Battle Mode</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Tantang temanmu dalam coding battle real-time!</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
    {{-- Rating Card --}}
    @php $myRating = auth()->user()->playerRating ?? null; @endphp
    <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-indigo-200 text-sm mb-1">Rating Battle Kamu</p>
                <div class="text-4xl font-black">{{ $myRating->elo_rating ?? 1000 }}</div>
                <div class="text-lg font-semibold text-amber-300 mt-1">{{ $myRating->rank_title ?? 'Pemula' }}</div>
            </div>
            <div class="grid grid-cols-3 gap-3 text-center">
                <div><div class="text-xl font-bold text-green-300">{{ $myRating->wins ?? 0 }}</div><div class="text-xs text-indigo-300">Menang</div></div>
                <div><div class="text-xl font-bold text-red-300">{{ $myRating->losses ?? 0 }}</div><div class="text-xs text-indigo-300">Kalah</div></div>
                <div><div class="text-xl font-bold text-white">{{ ($myRating->wins ?? 0) + ($myRating->losses ?? 0) }}</div><div class="text-xs text-indigo-300">Total</div></div>
            </div>
        </div>
    </div>

    {{-- Create Battle --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
        <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4">🆕 Buat Battle Baru</h3>
        @if(isset($gameLevels) && $gameLevels->count() > 0)
        <form action="{{ route('battle.create') }}" method="POST" class="space-y-4">
            @csrf
            <select name="game_level_id" required
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 focus:outline-none focus:border-indigo-500">
                @foreach($gameLevels as $level)
                <option value="{{ $level->id }}">{{ $level->game->title ?? 'Game' }} — {{ $level->title }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold rounded-xl hover:opacity-90 active:scale-95 transition-all shadow-md">
                ⚔️ Buat Battle Room
            </button>
        </form>
        @else
        <p class="text-slate-400 text-sm">Belum ada game level. Jalankan seeder terlebih dahulu.</p>
        @endif
    </div>

    {{-- Join Battle --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
        <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4">🔗 Gabung Battle</h3>
        <form action="{{ route('battle.join') }}" method="POST" class="flex gap-3">
            @csrf
            @error('code') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror
            <input type="text" name="code" placeholder="Kode 6 digit..." required maxlength="6"
                   class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-mono uppercase tracking-widest focus:outline-none focus:border-indigo-500">
            <button type="submit" class="px-6 py-2.5 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 active:scale-95 transition-all">
                Join
            </button>
        </form>
    </div>
</div>

{{-- Top Players --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 h-fit sticky top-20">
    <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-4">🏆 Top Battle Players</h3>
    @if(isset($topPlayers) && $topPlayers->count() > 0)
    <div class="space-y-2">
        @foreach($topPlayers as $i => $player)
        @php $isMe = $player->user_id === auth()->id(); @endphp
        <div class="flex items-center gap-2.5 p-2 rounded-xl {{ $isMe ? 'bg-indigo-50 dark:bg-indigo-950 border border-indigo-200 dark:border-indigo-800' : '' }} transition-colors">
            <span class="text-sm font-bold w-5 text-center {{ match($i) { 0=>'text-amber-500', 1=>'text-slate-400', 2=>'text-orange-600', default=>'text-slate-400' } }}">
                {{ match($i) { 0=>'🥇', 1=>'🥈', 2=>'🥉', default=>$i+1 } }}
            </span>
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0">
                {{ strtoupper(substr($player->user->name ?? 'U', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium truncate {{ $isMe ? 'text-indigo-700 dark:text-indigo-300' : 'text-slate-700 dark:text-slate-300' }}">
                    {{ $player->user->name ?? '-' }}{{ $isMe ? ' (Kamu)' : '' }}
                </p>
                <p class="text-[10px] text-amber-500">{{ $player->rank_title }}</p>
            </div>
            <span class="text-xs font-bold text-indigo-600">{{ $player->elo_rating }}</span>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-slate-400 text-sm text-center py-4">Belum ada data ranking</p>
    @endif
</div>
</div>
@endsection