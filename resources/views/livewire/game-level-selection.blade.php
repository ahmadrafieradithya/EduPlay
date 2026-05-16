<div class="min-h-screen bg-slate-100 dark:bg-slate-950">
    {{-- Header --}}
    <div class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ $game->title }}</h1>
            <p class="text-slate-600 dark:text-slate-400">Pilih level untuk mulai bermain</p>
        </div>
    </div>

    {{-- Level Grid --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($levels as $level)
            <button wire:click="selectLevel({{ $level['id'] }})"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl p-8 border-2 border-slate-200 dark:border-slate-700 hover:border-indigo-500 transition-all hover:shadow-xl overflow-hidden"
                    @if(!$level['is_unlocked']) disabled @endif>
                
                {{-- Locked Overlay --}}
                @if(!$level['is_unlocked'])
                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-5xl mb-2">🔒</div>
                        <p class="text-sm font-semibold text-white">Terkunci</p>
                    </div>
                </div>
                @endif

                {{-- Content --}}
                <div class="relative z-10 text-center">
                    <div class="text-5xl mb-4">
                        @switch($level['level_number'])
                            @case(1) 🟢 @break
                            @case(2) 🟡 @break
                            @case(3) 🔴 @break
                            @default ⭐
                        @endswitch
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                        Level {{ $level['level_number'] }}
                    </h3>

                    <p class="text-slate-600 dark:text-slate-400 mb-4">
                        {{ $level['name'] }}
                    </p>

                    <div class="flex items-center justify-center gap-2 mb-6">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $level['difficulty_color'] }}">
                            {{ ucfirst($level['difficulty']) }}
                        </span>
                    </div>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3">
                        <div class="text-sm text-yellow-600 dark:text-yellow-300">XP Reward</div>
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">+{{ $level['xp_reward'] }}</div>
                    </div>
                </div>

                {{-- Hover Effect --}}
                @if($level['is_unlocked'])
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/0 to-blue-500/0 group-hover:from-indigo-500/20 group-hover:to-blue-500/20 transition"></div>
                @endif
            </button>
            @endforeach
        </div>
    </div>

    {{-- Modal untuk Game Start --}}
    @if($showGameModal && $selectedLevel)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-8 max-w-md">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Mulai Level?</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-6">
                Siap memainkan {{ $game->title }} di Level {{ $selectedLevel['level_number'] }}?
            </p>
            <div class="flex gap-4">
                <button wire:click="$set('showGameModal', false)" class="flex-1 px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white rounded-lg hover:bg-slate-300 transition">
                    Batal
                </button>
                <button wire:click="playGame" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Mulai →
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
