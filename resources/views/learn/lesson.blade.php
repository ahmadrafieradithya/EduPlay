@extends('layouts.app')

@section('page-title', $lesson->title)
@section('content')

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- Main Content (3/4) --}}
    <div class="lg:col-span-3 space-y-6">
        {{-- Breadcrumb --}}
        <div class="text-sm">
            <a href="{{ route('learn.index') }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Learning Paths</a>
            <span class="text-slate-400 mx-2">/</span>
            <a href="{{ route('learn.path', $path) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">{{ $path->title }}</a>
            <span class="text-slate-400 mx-2">/</span>
            <span class="text-slate-900 dark:text-slate-100">{{ $topic->title }}</span>
        </div>

        {{-- Lesson Title --}}
        <div>
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-slate-100">{{ $lesson->title }}</h1>
            @if($lesson->duration_minutes)
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Estimasi durasi: {{ $lesson->duration_minutes }} menit</p>
            @endif
        </div>

        {{-- Content Container --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950 p-6">
            {{-- Livewire Lesson Player Component --}}
            <livewire:lesson-player :lesson="$lesson" />
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex items-center justify-between gap-4">
            @if($prevLesson)
                <a href="{{ route('learn.lesson', $prevLesson) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Lesson Sebelumnya
                </a>
            @else
                <div></div>
            @endif

            @if($nextLesson)
                <a href="{{ route('learn.lesson', $nextLesson) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-900">
                    Lesson Selanjutnya
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <div></div>
            @endif
        </div>
    </div>

    {{-- Sidebar (1/4) --}}
    <aside class="lg:col-span-1 space-y-6">
        {{-- Progress Card --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Progress Topik</h3>
            <div class="mt-4 space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-600 dark:text-slate-400">{{ $topic->completed_count }}/{{ $topic->total_lessons }} Selesai</span>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $topic->progress_percent }}%</span>
                </div>
                <div class="h-2 bg-slate-200 rounded-full overflow-hidden dark:bg-slate-800">
                    <div class="h-full bg-indigo-500 transition-all duration-500" style="width: {{ $topic->progress_percent }}%"></div>
                </div>
            </div>
        </div>

        {{-- Lessons List --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-3">Semua Lesson</h3>
            <div class="space-y-2">
                @foreach($allLessons as $l)
                    @php
                        $lProgress = auth()->user()->progress()
                            ->where('lesson_id', $l->id)
                            ->first();
                        $lIsCompleted = $lProgress?->status === 'completed';
                        $isCurrent = $l->id === $lesson->id;
                    @endphp
                    <a href="{{ route('learn.lesson', $l) }}" class="block p-2.5 rounded-xl transition {{ $isCurrent ? 'bg-indigo-100 dark:bg-indigo-900/30' : 'hover:bg-slate-50 dark:hover:bg-slate-900' }}">
                        <div class="flex items-center gap-2">
                            @if($lIsCompleted)
                                <span class="text-green-600">✓</span>
                            @else
                                <span class="text-slate-300">•</span>
                            @endif
                            <span class="text-xs {{ $isCurrent ? 'font-semibold text-indigo-700 dark:text-indigo-300' : 'text-slate-600 dark:text-slate-400' }}">{{ $l->title }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>

@endsection
