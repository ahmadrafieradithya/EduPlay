<div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-950 dark:to-slate-900">
    {{-- Header --}}
    <div class="sticky top-0 z-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                🎮 Game Arena
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Mainkan 5 game coding yang seru dan menantang</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(count($games) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($games as $game)
            @php
                $firstLevelId = !empty($game['levels']) ? $game['levels'][0]['id'] : 0;
            @endphp
            <a href="{{ $firstLevelId ? route('games.play', [$game['id'], $firstLevelId]) : '#' }}"
               class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1 border border-slate-200 dark:border-slate-700">
                
                {{-- Thumbnail --}}
                <div class="h-48 bg-gradient-to-br {{ match($game['difficulty']) {
                    'easy' => 'from-emerald-400 to-teal-500',
                    'medium' => 'from-yellow-400 to-orange-500',
                    'hard' => 'from-red-400 to-pink-500',
                    'expert' => 'from-purple-400 to-pink-500',
                    default => 'from-indigo-400 to-blue-500'
                } }} relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center text-5xl">
                        {{ match($game['type']) {
                            'typing_race' => '⌨️',
                            'bug_fix' => '🐛',
                            'code_puzzle' => '🧩',
                            'output_guessing' => '🎯',
                            'html_builder' => '🏗️',
                            default => '🎮'
                        } }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $game['difficulty_color'] }}">
                            {{ ucfirst($game['difficulty']) }}
                        </span>
                        <span class="text-sm font-bold text-yellow-600">{{ $game['user_best_score'] ?? 0 }} pts</span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                        {{ $game['title'] }}
                    </h3>

                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2">
                        {{ $game['description'] ?? 'Mainkan game ini untuk meningkatkan skill coding' }}
                    </p>

                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-600 dark:text-slate-400">
                            Dimainkan {{ $game['user_plays'] }} kali
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300">
                            {{ count($game['levels']) }} Level
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🎮</div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Game belum tersedia</h3>
            <p class="text-slate-600 dark:text-slate-400">Silakan cek kembali nanti</p>
        </div>
        @endif
    </div>
</div>
