@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('content')

@php
    $user = auth()->user();
    $totalXp = $user->xp?->total_xp ?? 0;
    $level = $user->xp?->level;
    $levelNum = $level?->level_number ?? 1;
    $currentStreak = $user->streak?->current_streak ?? 0;
    $lessonsCompleted = $user->progress()->where('status', 'completed')->count();
    $badgesCount = $user->badges()->count();
    $rankInClass = 0; // akan diisi dari leaderboard
@endphp

{{-- Hero Section --}}
<div class="relative bg-gradient-to-r from-indigo-600 to-violet-700 rounded-2xl p-6 mb-5 overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/3 translate-x-1/4"></div>
    <div class="absolute bottom-0 left-1/3 w-32 h-32 bg-white/5 rounded-full translate-y-1/2"></div>
    
    <div class="relative flex items-center justify-between">
        <div>
            <p class="text-indigo-200 text-sm mb-1">Selamat datang kembali 👋</p>
            <h2 class="text-2xl font-bold text-white mb-2">Halo, {{ $user->name }}!</h2>
            <p class="text-indigo-300 text-sm">
                @if($lessonsCompleted > 0)
                    Kamu sudah menyelesaikan {{ $lessonsCompleted }} materi. Terus semangat!
                @else
                    Mulai perjalanan belajarmu sekarang!
                @endif
            </p>
            <a href="{{ route('learn.index') }}" 
               class="inline-flex items-center gap-2 mt-4 bg-white text-indigo-700 text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-indigo-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                </svg>
                Lanjutkan Belajar
            </a>
        </div>
        <div class="hidden md:flex items-center gap-3">
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center min-w-[80px]">
                <div class="text-2xl font-bold text-orange-400">
                    @if($currentStreak > 0) 🔥 @endif{{ $currentStreak }}
                </div>
                <div class="text-[10px] text-indigo-300 mt-1">Hari Streak</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center min-w-[80px]">
                <div class="text-2xl font-bold text-indigo-200">Lv.{{ $levelNum }}</div>
                <div class="text-[10px] text-indigo-300 mt-1">{{ $level?->title ?? 'Murid Baru' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
    @php
        $stats = [
            ['label' => 'Materi Selesai', 'value' => $lessonsCompleted, 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'blue', 'bg' => 'bg-blue-50 dark:bg-blue-950', 'text' => 'text-blue-600 dark:text-blue-400'],
            ['label' => 'Total XP', 'value' => number_format($totalXp), 'icon' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z', 'color' => 'violet', 'bg' => 'bg-violet-50 dark:bg-violet-950', 'text' => 'text-violet-600 dark:text-violet-400'],
            ['label' => 'Badge Diraih', 'value' => $badgesCount, 'icon' => 'M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0', 'color' => 'amber', 'bg' => 'bg-amber-50 dark:bg-amber-950', 'text' => 'text-amber-600 dark:text-amber-400'],
            ['label' => 'Streak Hari Ini', 'value' => $currentStreak . ' 🔥', 'icon' => 'M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z', 'color' => 'orange', 'bg' => 'bg-orange-50 dark:bg-orange-950', 'text' => 'text-orange-600 dark:text-orange-400'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-4">
        <div class="w-9 h-9 {{ $stat['bg'] }} rounded-lg flex items-center justify-center mb-3">
            <svg class="w-5 h-5 {{ $stat['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
            </svg>
        </div>
        <div class="text-xl font-bold text-slate-800 dark:text-slate-200">{{ $stat['value'] }}</div>
        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- Bottom Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    {{-- Learning Progress (2/3) --}}
    <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Materi Sedang Dipelajari</h3>
            <a href="{{ route('learn.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Lihat semua →</a>
        </div>
        
        @php
            $inProgressLessons = $user->progress()
                ->where('status', 'in_progress')
                ->with('lesson.topic.learningPath')
                ->latest()
                ->take(3)
                ->get();
        @endphp

        @if($inProgressLessons->isEmpty())
            <div class="text-center py-8">
                <div class="text-4xl mb-3">📚</div>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada materi yang sedang dipelajari.</p>
                <a href="{{ route('learn.index') }}" class="inline-block mt-3 text-indigo-600 text-sm font-medium hover:underline">Mulai belajar sekarang →</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($inProgressLessons as $progress)
                <a href="{{ route('learn.lesson', $progress->lesson) }}" class="flex items-center gap-4 p-3 rounded-xl border border-slate-100 dark:border-slate-800 hover:border-indigo-200 dark:hover:border-indigo-800 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/30 transition-all group">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3l14 9-14 9V3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ $progress->lesson->title }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $progress->lesson->topic?->learningPath?->title }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Leaderboard Kelas (1/3) --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Top Kelas</h3>
            <a href="{{ route('leaderboard.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Semua →</a>
        </div>
        
        @php
            $topStudents = \App\Models\UserXp::with('user')
                ->whereHas('user', fn($q) => $q->where('school_id', auth()->user()->school_id))
                ->orderBy('total_xp', 'desc')
                ->take(5)
                ->get();
        @endphp

        <div class="space-y-2">
            @foreach($topStudents as $i => $entry)
            @php $isMe = $entry->user_id === auth()->id(); @endphp
            <div class="flex items-center gap-2.5 p-2 rounded-lg {{ $isMe ? 'bg-indigo-50 dark:bg-indigo-950 border border-indigo-200 dark:border-indigo-800' : '' }}">
                <span class="text-xs font-semibold w-4 text-center {{ match($i) { 0 => 'text-amber-500', 1 => 'text-slate-400', 2 => 'text-orange-700', default => 'text-slate-400' } }}">
                    {{ match($i) { 0 => '🥇', 1 => '🥈', 2 => '🥉', default => $i + 1 } }}
                </span>
                <div class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-[9px] font-semibold text-white flex-shrink-0">
                    {{ strtoupper(substr($entry->user->name ?? 'U', 0, 2)) }}
                </div>
                <span class="text-xs flex-1 truncate {{ $isMe ? 'font-semibold text-indigo-700 dark:text-indigo-300' : 'text-slate-700 dark:text-slate-300' }}">
                    {{ $entry->user->name ?? 'Unknown' }}{{ $isMe ? ' (Kamu)' : '' }}
                </span>
                <span class="text-[10px] font-semibold text-indigo-600 dark:text-indigo-400">{{ number_format($entry->total_xp) }} XP</span>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
