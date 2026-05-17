@extends('layouts.app')
@section('page-title', $path->title)
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('learn.index') }}" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-800 dark:text-white">{{ $path->title }}</h1>
            <p class="text-sm text-slate-500">{{ $path->description }}</p>
        </div>
    </div>
@php
    $allLessons   = $path->publishedTopics->flatMap->publishedLessons;
    $totalCount   = $allLessons->count();
    $doneCount    = $completedIds->count();
    $overallPct   = $totalCount > 0 ? round(($doneCount / $totalCount) * 100) : 0;
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-6 flex items-center gap-4">
    <div class="flex-1">
        <div class="flex justify-between text-sm mb-2">
            <span class="font-medium text-slate-700 dark:text-slate-300">Progress Keseluruhan</span>
            <span class="font-bold text-indigo-600">{{ $doneCount }}/{{ $totalCount }} selesai</span>
        </div>
        <div class="h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full transition-all"
                 style="width:{{ $overallPct }}%"></div>
        </div>
    </div>
    <div class="text-2xl font-bold text-indigo-600 min-w-[56px] text-center">{{ $overallPct }}%</div>
</div>

<div class="space-y-3">
    @foreach($path->publishedTopics as $topicIdx => $topic)
    @php
        $topicLessons = $topic->publishedLessons;
        $topicDone    = $topicLessons->filter(fn($l) => $completedIds->contains($l->id))->count();
        $topicPct     = $topicLessons->count() > 0 ? round(($topicDone / $topicLessons->count()) * 100) : 0;
        $allDone      = $topicPct === 100;
        $typeIcons    = ['video' => '🎬', 'article' => '📖', 'code_example' => '💻', 'interactive' => '🧩'];
    @endphp

    <div class="bg-white dark:bg-slate-900 rounded-2xl border {{ $allDone ? 'border-green-200 dark:border-green-800' : 'border-slate-200 dark:border-slate-800' }} overflow-hidden"
         x-data="{ open: {{ $topicIdx === 0 ? 'true' : 'false' }} }">

        <button @click="open = !open"
                class="w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <div class="w-10 h-10 rounded-xl {{ $allDone ? 'bg-green-100 dark:bg-green-900' : 'bg-indigo-100 dark:bg-indigo-900' }} flex items-center justify-center font-bold text-sm {{ $allDone ? 'text-green-700 dark:text-green-300' : 'text-indigo-700 dark:text-indigo-300' }} flex-shrink-0">
                @if($allDone) ✅ @else {{ $topicIdx + 1 }} @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $topic->title }}</h3>
                    <span class="text-xs text-slate-400 ml-2 flex-shrink-0">{{ $topicDone }}/{{ $topicLessons->count() }}</span>
                </div>
                <div class="h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden max-w-48">
                    <div class="h-full {{ $allDone ? 'bg-green-500' : 'bg-indigo-500' }} rounded-full" style="width:{{ $topicPct }}%"></div>
                </div>
            </div>
            <svg class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200" :class="{'rotate-180': open}"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open" x-transition class="border-t border-slate-100 dark:border-slate-800">
            @foreach($topicLessons as $lessonIdx => $lesson)
            @php
                $isDone    = $completedIds->contains($lesson->id);
                $isInProg  = isset($progressMap[$lesson->id]) && !$isDone;
                $isLocked  = !$lesson->is_free && $lessonIdx > 0
                             && !$completedIds->contains($topicLessons[$lessonIdx-1]->id ?? 0);
            @endphp

            @if($isLocked)
            <div class="flex items-center gap-4 px-5 py-3.5 opacity-50 cursor-not-allowed border-b border-slate-50 dark:border-slate-800/50 last:border-0">
                <div class="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <span class="text-base">{{ $typeIcons[$lesson->type] ?? '📄' }}</span>
                <div class="flex-1">
                    <p class="text-sm text-slate-500">{{ $lesson->title }}</p>
                    <p class="text-xs text-slate-400">Selesaikan materi sebelumnya terlebih dahulu</p>
                </div>
                <span class="text-xs bg-slate-100 dark:bg-slate-800 text-slate-400 px-2 py-0.5 rounded-full">Terkunci 🔒</span>
            </div>
            @else
            <a href="{{ route('learn.lesson', $lesson->id) }}"
               class="flex items-center gap-4 px-5 py-3.5 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/30 transition-colors border-b border-slate-50 dark:border-slate-800/50 last:border-0 group">
                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $isDone ? 'bg-green-100 dark:bg-green-900' : ($isInProg ? 'bg-blue-100 dark:bg-blue-900' : 'bg-slate-100 dark:bg-slate-800') }}">
                    @if($isDone)
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @elseif($isInProg)
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    @else
                        <span class="text-[10px] text-slate-400 font-medium">{{ $lessonIdx + 1 }}</span>
                    @endif
                </div>
                <span class="text-lg">{{ $typeIcons[$lesson->type] ?? '📄' }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 truncate transition-colors">
                        {{ $lesson->title }}
                        @if($lesson->is_free)
                        <span class="ml-1.5 text-[9px] bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded-full font-semibold">GRATIS</span>
                        @endif
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">+{{ $lesson->xp_reward }} XP</p>
                </div>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>
</div>
@endsection