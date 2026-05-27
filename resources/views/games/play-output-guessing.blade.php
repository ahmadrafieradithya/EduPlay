@extends('layouts.app')
@section('page-title', $game->title . ' — ' . $level->title)
@section('content')

<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('games.index') }}" class="flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Game Arena
    </a>
    <div class="flex gap-2">
        @foreach($allLevels as $l)
        <a href="{{ route('games.play', [$game->id, $l->id]) }}"
           class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold transition-all
                  {{ $l->id === $level->id ? 'bg-violet-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-violet-100' }}">
            {{ $l->level_number }}
        </a>
        @endforeach
    </div>
</div>

@livewire('games.quiz', ['level' => $level])

@endsection