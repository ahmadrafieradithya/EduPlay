@extends('layouts.app')

@section('page-title', 'Learning Paths')
@section('content')

<div class="space-y-6">
    {{-- Header --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-950">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Pilih Path Belajarmu</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Mulai dari yang dasar hingga mahir dengan learning paths yang terstruktur.</p>
    </div>

    {{-- Learning Paths Grid --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($paths as $path)
            <a href="{{ route('learn.path', $path) }}" class="group rounded-3xl border border-slate-200 bg-white overflow-hidden shadow-sm transition hover:shadow-lg hover:-translate-y-1 dark:border-slate-800 dark:bg-slate-950">
                {{-- Thumbnail --}}
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-indigo-500 to-violet-600">
                    @if($path->thumbnail)
                        <img src="{{ asset('storage/' . $path->thumbnail) }}" alt="{{ $path->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl opacity-20">📚</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
                    <div class="absolute top-4 right-4">
                        <span class="rounded-full bg-white/20 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-white">
                            {{ $path->difficulty ?? 'Pemula' }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 line-clamp-2">{{ $path->title }}</h2>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ $path->description }}</p>

                    {{-- Progress Bar --}}
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-medium text-slate-500 dark:text-slate-400">Progress</span>
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $path->user_progress_percent }}%</span>
                        </div>
                        <div class="h-2 bg-slate-200 rounded-full overflow-hidden dark:bg-slate-800">
                            <div class="h-full bg-indigo-500 transition-all duration-500" style="width: {{ $path->user_progress_percent }}%"></div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400">
                            <span class="font-semibold text-slate-700 dark:text-slate-300">{{ count($path->topics) }}</span> Topik
                        </span>
                        <span class="text-slate-500 dark:text-slate-400">
                            <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $path->total_lessons }}</span> Lesson
                        </span>
                        @if($path->estimated_hours)
                            <span class="text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $path->estimated_hours }}</span> jam
                            </span>
                        @endif
                    </div>
                </div>

                {{-- CTA --}}
                <div class="border-t border-slate-200 bg-slate-50 px-5 py-3 dark:border-slate-800 dark:bg-slate-900">
                    <span class="inline-flex items-center text-sm font-semibold text-indigo-600 group-hover:text-indigo-700 dark:text-indigo-400">
                        {{ $path->user_progress_percent > 0 ? 'Lanjutkan' : 'Mulai' }} Belajar
                        <svg class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center dark:border-slate-700 dark:bg-slate-900">
                <div class="text-5xl mb-4">📚</div>
                <p class="text-slate-600 dark:text-slate-400">Belum ada learning path yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
