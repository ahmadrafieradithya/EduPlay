@extends('layouts.app')
@section('page-title', 'Materi Belajar')
@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Jalur Belajar Coding 🚀</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Pilih jalur, selesaikan materi, dan kumpulkan XP. Belajar coding seperti bermain game!</p>
</div>

@php
    $pathConfig = [
        0 => ['gradient' => 'from-blue-500 to-cyan-500',   'icon' => '🌐', 'ring' => 'ring-blue-200 dark:ring-blue-800'],
        1 => ['gradient' => 'from-violet-500 to-purple-600','icon' => '🎨', 'ring' => 'ring-violet-200 dark:ring-violet-800'],
        2 => ['gradient' => 'from-orange-500 to-red-500',   'icon' => '🐘', 'ring' => 'ring-orange-200 dark:ring-orange-800'],
        3 => ['gradient' => 'from-green-500 to-teal-500',   'icon' => '⚡', 'ring' => 'ring-green-200 dark:ring-green-800'],
        4 => ['gradient' => 'from-pink-500 to-rose-500',    'icon' => '💎', 'ring' => 'ring-pink-200 dark:ring-pink-800'],
    ];
    $diffLabel = [
        'beginner' => ['label' => 'Pemula', 'class' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'],
        'intermediate' => ['label' => 'Menengah', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300'],
        'advanced' => ['label' => 'Lanjutan', 'class' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'],
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($paths as $i => $path)
    @php
        $cfg = $pathConfig[$i % 5];
        $diff = $diffLabel[$path->difficulty] ?? $diffLabel['beginner'];
        $progress = $path->user_progress ?? 0;
        $topicCount = $path->publishedTopics->count();
        $lessonCount = $path->total_lessons;
    @endphp

    <article class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">

        {{-- Card Header --}}
        <div class="relative bg-gradient-to-br {{ $cfg['gradient'] }} p-6 overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-0 left-1/3 w-12 h-12 bg-white/10 rounded-full translate-y-1/2"></div>

            <div class="relative flex items-start justify-between">
                <div class="text-4xl filter drop-shadow-md">{{ $cfg['icon'] }}</div>
                <span class="text-[10px] font-semibold {{ $diff['class'] }} px-2.5 py-1 rounded-full">
                    {{ $diff['label'] }}
                </span>
            </div>
            <h2 class="relative text-lg font-bold text-white mt-3">{{ $path->title }}</h2>

            {{-- Progress ring --}}
            @if($progress > 0)
            <div class="relative mt-3 flex items-center gap-2">
                <div class="flex-1 h-1.5 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full transition-all duration-700" style="width:{{ $progress }}%"></div>
                </div>
                <span class="text-xs font-semibold text-white">{{ $progress }}%</span>
            </div>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4">{{ $path->description }}</p>

            <div class="flex items-center gap-4 text-xs text-slate-400 dark:text-slate-500 mb-5">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    {{ $topicCount }} Topik
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    {{ $lessonCount }} Materi
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $path->estimated_hours }}j
                </span>
            </div>

            <a href="{{ route('learn.path', $path->slug) }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold transition-all
                      bg-gradient-to-r {{ $cfg['gradient'] }} text-white hover:opacity-90 hover:shadow-md active:scale-95">
                @if($progress === 0)
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Mulai Belajar
                @elseif($progress === 100)
                    ✅ Selesai — Ulangi
                @else
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    Lanjutkan ({{ $progress }}%)
                @endif
            </a>
        </div>
    </article>
    @endforeach
</div>

@endsection
