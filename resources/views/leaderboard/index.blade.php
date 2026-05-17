@extends('layouts.app')
@section('page-title', 'Materi Belajar')
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">📚 Jalur Belajar</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Pilih jalur, selesaikan materi, kumpulkan XP!</p>
</div>
@php
$configs = [
['gradient' => 'from-blue-500 to-cyan-500',    'icon' => '🌐'],
['gradient' => 'from-violet-500 to-purple-600', 'icon' => '🎨'],
['gradient' => 'from-orange-500 to-red-500',    'icon' => '🐘'],
['gradient' => 'from-green-500 to-teal-500',    'icon' => '⚡'],
];
$diffLabel = [
'beginner'     => ['label' => 'Pemula',   'class' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'],
'intermediate' => ['label' => 'Menengah', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300'],
'advanced'     => ['label' => 'Lanjutan', 'class' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'],
];
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($paths as $i => $path)
    @php
        $cfg   = $configs[$i % count($configs)];
        $diff  = $diffLabel[$path->difficulty] ?? $diffLabel['beginner'];
        $prog  = $path->user_progress ?? 0;
        $total = $path->total_lessons ?? 0;
    @endphp
<article class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
    <div class="relative bg-gradient-to-br {{ $cfg['gradient'] }} p-6 overflow-hidden">
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="relative flex items-start justify-between">
            <div class="text-4xl">{{ $cfg['icon'] }}</div>
            <span class="text-[10px] font-semibold {{ $diff['class'] }} px-2.5 py-1 rounded-full">{{ $diff['label'] }}</span>
        </div>
        <h2 class="relative text-lg font-bold text-white mt-3">{{ $path->title }}</h2>
        @if($prog > 0)
        <div class="relative mt-3 flex items-center gap-2">
            <div class="flex-1 h-1.5 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full" style="width:{{ $prog }}%"></div>
            </div>
            <span class="text-xs font-bold text-white">{{ $prog }}%</span>
        </div>
        @endif
    </div>

    <div class="p-5">
        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4">{{ $path->description }}</p>
        <div class="flex items-center gap-4 text-xs text-slate-400 mb-5">
            <span>📖 {{ $path->publishedTopics->count() }} Topik</span>
            <span>📄 {{ $total }} Materi</span>
            <span>⏱ {{ $path->estimated_hours }}j</span>
        </div>
        <a href="{{ route('learn.path', $path->slug) }}"
           class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r {{ $cfg['gradient'] }} hover:opacity-90 active:scale-95 transition-all">
            {{ $prog === 0 ? '▶ Mulai Belajar' : ($prog === 100 ? '✅ Ulangi' : '▶ Lanjutkan ('.$prog.'%)') }}
        </a>
    </div>
</article>
@empty
<div class="col-span-3 text-center py-20">
    <div class="text-5xl mb-4">📭</div>
    <p class="text-slate-500">Belum ada materi tersedia.</p>
    <p class="text-slate-400 text-sm mt-1">Jalankan <code>php artisan db:seed</code> untuk mengisi data.</p>
</div>
@endforelse
</div>
@endsection