<div class="min-h-screen bg-slate-100 dark:bg-slate-950">
    {{-- Breadcrumb --}}
    <div class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('learn.index') }}" class="text-indigo-600 hover:text-indigo-700">📚 Materi</a>
                <span class="text-slate-400">/</span>
                <a href="{{ route('learn.path', $topic->learningPath->slug) }}" class="text-indigo-600 hover:text-indigo-700">{{ $topic->learningPath->title }}</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 dark:text-slate-400">{{ $topic->title }}</span>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">{{ $topic->title }}</h1>
            <p class="text-slate-600 dark:text-slate-400">{{ $topic->description }}</p>
        </div>

        {{-- Progress Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                <div class="text-2xl font-bold text-indigo-600">{{ count($lessons) }}</div>
                <div class="text-sm text-slate-600 dark:text-slate-400">Total Pelajaran</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                <div class="text-2xl font-bold text-emerald-600">{{ collect($lessons)->where('completed', true)->count() }}</div>
                <div class="text-sm text-slate-600 dark:text-slate-400">Terselesaikan</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                <div class="text-2xl font-bold text-yellow-600">{{ $topic->lessons->sum('xp_reward') ?? 0 }}</div>
                <div class="text-sm text-slate-600 dark:text-slate-400">Total XP</div>
            </div>
        </div>
    </div>

    {{-- Lessons List --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Daftar Pelajaran</h2>
        
        <div class="space-y-4">
            @foreach($lessons as $item)
            @php $lesson = $item['lesson']; @endphp
            <div class="group {{ $item['completed'] ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800' : 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700' }} rounded-lg p-6 hover:shadow-lg transition">
                <div class="flex items-start gap-4">
                    {{-- Icon --}}
                    <div class="text-4xl">
                        @if($item['completed'])
                            ✅
                        @elseif($item['is_locked'])
                            🔒
                        @else
                            📄
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $lesson->title }}</h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $lesson->description ?? 'Pelajaran penting untuk dikuasai' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                           {{ $lesson->type === 'video' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                    {{ $lesson->type }}
                                </span>
                            </div>
                        </div>

                        {{-- Metadata --}}
                        <div class="flex gap-6 mt-4 text-sm text-slate-600 dark:text-slate-400">
                            <span>⏱️ {{ $lesson->duration_minutes ?? 15 }} menit</span>
                            <span>⭐ {{ $lesson->xp_reward ?? 50 }} XP</span>
                            @if($lesson->is_free)
                                <span class="text-emerald-600 dark:text-emerald-400">🎉 Gratis</span>
                            @endif
                        </div>

                        {{-- Action --}}
                        <div class="mt-4">
                            @if($item['is_locked'])
                                <button disabled class="px-4 py-2 rounded-lg bg-gray-300 text-gray-600 cursor-not-allowed">
                                    🔒 Terkunci
                                </button>
                            @elseif($item['completed'])
                                <a href="{{ route('learn.lesson', $lesson->id) }}" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition inline-block">
                                    ✅ Ulang Pelajaran
                                </a>
                            @else
                                <a href="{{ route('learn.lesson', $lesson->id) }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition inline-block">
                                    Mulai Pelajaran →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
