@extends('layouts.app')
@section('page-title', 'Bookmark Saya')
@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('learn.index') }}" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 mb-4">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Materi
        </a>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Bookmark Saya 📌</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Materi yang telah Anda tandai untuk dibaca nanti</p>
    </div>

    @if($bookmarks->isNotEmpty())
    <div class="space-y-4">
        @foreach($bookmarks as $bookmark)
        @php
            $lesson = $bookmark->lesson;
            $topic = $lesson->topic;
            $path = $topic->learningPath;
            $typeIcons = ['video' => '🎬', 'article' => '📖', 'code_example' => '💻', 'interactive' => '🧩'];
        @endphp
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-lg transition-all duration-300">
            <a href="{{ route('learn.lesson', $lesson->id) }}" class="flex items-center gap-4 p-5 group">
                {{-- Icon & Badge --}}
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    {{ $typeIcons[$lesson->type] ?? '📄' }}
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors truncate">
                            {{ $lesson->title }}
                        </h3>
                        <span class="text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300 px-2 py-0.5 rounded-full">+{{ $lesson->xp_reward }} XP</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $path->title }} / {{ $topic->title }}
                    </p>
                </div>

                {{-- Arrow --}}
                <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-12 text-center">
        <div class="text-4xl mb-3">📌</div>
        <h3 class="text-slate-800 dark:text-slate-100 font-semibold mb-1">Belum ada bookmark</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-5">Tandai materi favorit Anda untuk membacanya nanti</p>
        <a href="{{ route('learn.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Jelajahi Materi
        </a>
    </div>
    @endif
</div>

@endsection
