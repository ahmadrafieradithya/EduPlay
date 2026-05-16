<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Learning Paths</h1>
            <p class="mt-2 text-slate-600">Explore structured learning journeys</p>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($learningPaths as $path)
        <div class="rounded-[2rem] border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/5">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-slate-900">{{ $path->title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $path->description }}</p>
                    <div class="mt-4 flex items-center gap-4 text-sm text-slate-500">
                        <span>Difficulty: {{ ucfirst($path->difficulty) }}</span>
                        <span>{{ $path->topics->count() }} topics</span>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                        <div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-950 dark:to-slate-900">
                            <div class="sticky top-0 z-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                                    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                                        📚 Materi Belajar
                                    </h1>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Pilih learning path untuk mulai belajar coding</p>
                                </div>
                            </div>
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($paths as $path)
                                    <a href="{{ route('learn.path', $path['slug']) }}"
                                       class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1">
                                        <div class="h-40 bg-gradient-to-br from-indigo-400 to-blue-500 relative">
                                            <div class="absolute inset-0 flex items-center justify-center text-5xl">🌐</div>
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $path['title'] }}</h3>
                                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2">{{ $path['description'] }}</p>
                                            <div class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-4">
                                                <div class="h-full bg-gradient-to-r from-indigo-500 to-blue-500" style="width: {{ $path['user_progress_percent'] }}%"></div>
                                            </div>
                                            <div class="flex justify-between text-xs">
                                                <span>{{ $path['user_progress_count'] }}/{{ $path['total_lessons'] }}</span>
                                                <span class="font-bold">+{{ $path['total_xp'] ?? 0 }} XP</span>
                                            </div>
                                        </div>
                                     </a>
                                     @endforeach
                                </div>
                            </div>
                        </div>