@extends('layouts.app')
@section('page-title', $lesson->title)
@section('content')
<div class="max-w-4xl mx-auto">
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-5 flex-wrap">
        <a href="{{ route('learn.index') }}" class="hover:text-indigo-500 transition-colors">Materi</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('learn.path', $lesson->topic->learningPath->slug) }}" class="hover:text-indigo-500 transition-colors">{{ $lesson->topic->learningPath->title }}</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600 dark:text-slate-300">{{ $lesson->title }}</span>
    </nav>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2 mb-3">
                    @php
                        $tc = ['video'=>['label'=>'Video','class'=>'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'],
                               'article'=>['label'=>'Artikel','class'=>'bg-blue-100 text-blue-700'],
                               'code_example'=>['label'=>'Kode','class'=>'bg-green-100 text-green-700'],
                               'interactive'=>['label'=>'Interaktif','class'=>'bg-violet-100 text-violet-700']];
                        $t = $tc[$lesson->type] ?? $tc['article'];
                    @endphp
                    <span class="text-xs font-semibold {{ $t['class'] }} px-2.5 py-1 rounded-full">{{ $t['label'] }}</span>
                    <span class="text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300 px-2.5 py-1 rounded-full">+{{ $lesson->xp_reward }} XP</span>
                </div>
                <h1 class="text-xl font-bold text-slate-800 dark:text-white">{{ $lesson->title }}</h1>
            </div>

            @if($lesson->type === 'video' && $lesson->video_url)
            <div class="aspect-video bg-slate-900">
                <iframe src="{{ $lesson->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
            </div>
            @endif

            @if($lesson->content)
            <div class="p-6 prose prose-slate dark:prose-invert max-w-none text-sm leading-relaxed
                        prose-code:bg-slate-100 prose-code:dark:bg-slate-800 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-indigo-700 prose-code:dark:text-indigo-300
                        prose-pre:bg-slate-900 prose-pre:text-slate-100 prose-pre:rounded-xl">
                {!! $lesson->content !!}
            </div>
            @endif

            <div class="p-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                @if($prevLesson)
                <a href="{{ route('learn.lesson', $prevLesson->id) }}" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Sebelumnya
                </a>
                @else <div></div> @endif

                @if(class_exists('\App\Livewire\Learn\LessonPlayer'))
                    @livewire('learn.lesson-player', ['lesson' => $lesson])
                @else
                    <span class="text-xs text-slate-400">Livewire LessonPlayer belum ada</span>
                @endif

                @if($nextLesson)
                <a href="{{ route('learn.lesson', $nextLesson->id) }}" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                    Berikutnya
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @else <div></div> @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 sticky top-20">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200 mb-3">{{ $lesson->topic->title }}</h3>
            <div class="space-y-1 max-h-80 overflow-y-auto">
                @foreach($lesson->topic->publishedLessons as $sL)
                @php $done = $completedIds->contains($sL->id); $active = $sL->id === $lesson->id; @endphp
                <a href="{{ route('learn.lesson', $sL->id) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm transition-all
                          {{ $active ? 'bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-semibold' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <div class="w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center
                                {{ $done ? 'bg-green-100 dark:bg-green-900' : ($active ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-slate-100 dark:bg-slate-800') }}">
                        @if($done) <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @elseif($active) <div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div>
                        @else <div class="w-1.5 h-1.5 bg-slate-300 dark:bg-slate-600 rounded-full"></div>
                        @endif
                    </div>
                    <span class="truncate text-xs">{{ $sL->title }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
@endsection