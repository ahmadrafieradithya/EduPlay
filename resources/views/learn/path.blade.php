@extends('layouts.app')

@section('page-title', $path->title)
@section('content')

<div class="space-y-6">
    {{-- Breadcrumb & Header --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
        <a href="{{ route('learn.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Path
        </a>
        <h1 class="mt-3 text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $path->title }}</h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $path->description }}</p>
    </div>

    {{-- Topics Grid --}}
    <div class="space-y-4">
        @forelse($topics as $topic)
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950 overflow-hidden">
                {{-- Topic Header --}}
                <button onclick="toggleTopic({{ $topic->id }})" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-900 transition">
                    <div class="flex-1 text-left">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $topic->title }}</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $topic->description }}</p>
                        <div class="mt-3 flex items-center gap-4 text-xs">
                            <span class="text-slate-500">{{ $topic->total_lessons }} Lesson</span>
                            @if($topic->estimated_minutes)
                                <span class="text-slate-500">{{ $topic->estimated_minutes }} menit</span>
                            @endif
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $topic->progress_percent }}%</span>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-transform" id="toggle-{{ $topic->id }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </button>

                {{-- Topic Progress Bar --}}
                <div class="px-6 py-2 bg-slate-50 dark:bg-slate-900/50">
                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden dark:bg-slate-800">
                        <div class="h-full bg-indigo-500 transition-all duration-500" style="width: {{ $topic->progress_percent }}%"></div>
                    </div>
                </div>

                {{-- Lessons List (Collapsible) --}}
                <div id="lessons-{{ $topic->id }}" class="hidden border-t border-slate-200 dark:border-slate-800 divide-y dark:divide-slate-800">
                    @foreach($topic->lessons as $lesson)
                        @php
                            $progress = auth()->user()->progress()
                                ->where('lesson_id', $lesson->id)
                                ->first();
                            $status = $progress?->status ?? 'not_started';
                            $isCompleted = $status === 'completed';
                            $isInProgress = $status === 'in_progress';
                        @endphp
                        <a href="{{ route('learn.lesson', $lesson) }}" class="px-6 py-4 flex items-center gap-4 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition">
                            {{-- Lesson Icon --}}
                            <div class="flex-shrink-0">
                                @if($isCompleted)
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center dark:bg-green-900">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @elseif($isInProgress)
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center dark:bg-blue-900">
                                        <span class="text-lg">⭐</span>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center dark:bg-slate-800">
                                        @if($lesson->type === 'video')
                                            <span class="text-lg">🎬</span>
                                        @elseif($lesson->type === 'article')
                                            <span class="text-lg">📖</span>
                                        @else
                                            <span class="text-lg">💻</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Lesson Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $lesson->title }}</p>
                                @if($lesson->duration_minutes)
                                    <p class="mt-1 text-xs text-slate-500">{{ $lesson->duration_minutes }} menit</p>
                                @endif
                            </div>

                            {{-- Action Icon --}}
                            <svg class="w-5 h-5 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center dark:border-slate-700 dark:bg-slate-900">
                <p class="text-slate-600 dark:text-slate-400">Belum ada topik dalam path ini.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
function toggleTopic(topicId) {
    const lessonList = document.getElementById(`lessons-${topicId}`);
    const toggle = document.getElementById(`toggle-${topicId}`);
    
    lessonList.classList.toggle('hidden');
    toggle.style.transform = lessonList.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
}
</script>

@endsection
