<div class="max-w-3xl mx-auto" x-data="{
    started: @entangle('isStarted'),
    finished: @entangle('isFinished'),
    init() {
        this.$watch('started', val => {
            if (val) this.$nextTick(() => this.$refs.inputArea?.focus());
        });
    }
}">

    {{-- START SCREEN --}}
    @if(!$isStarted && !$isFinished)
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center">
        <div class="text-5xl mb-4">⌨️</div>
        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-1">{{ $level->title }}</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Ketik kode secepat dan seakurat mungkin!</p>

        <div class="flex items-center justify-center gap-6 text-sm text-slate-400 mb-6">
            <span>⏱ {{ $level->time_limit }} detik</span>
            <span>⭐ +{{ $level->xp_reward }} XP</span>
            <span>🎯 Min {{ $level->min_score_to_pass }}% untuk lulus</span>
        </div>

        <div class="bg-slate-900 rounded-xl p-5 font-mono text-sm text-green-400 mb-8 text-left whitespace-pre-wrap">{{ $targetText }}</div>

        <button wire:click="start"
                class="bg-gradient-to-r from-green-500 to-teal-500 text-white font-bold px-10 py-3 rounded-xl hover:opacity-90 active:scale-95 transition-all shadow-lg">
            🚀 Mulai Sekarang!
        </button>
    </div>

    {{-- GAME SCREEN --}}
    @elseif($isStarted && !$isFinished)
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">

        {{-- Timer --}}
        <div class="px-6 pt-5 pb-0">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">⏱ Waktu Tersisa</span>
                <span class="text-2xl font-black {{ $timeLeft <= 10 ? 'text-red-500 animate-pulse' : 'text-slate-800 dark:text-white' }}">
                    {{ $timeLeft }}s
                </span>
            </div>
            <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden mb-5">
                <div class="h-full {{ $timeLeft <= 10 ? 'bg-red-500' : 'bg-green-500' }} rounded-full transition-all duration-1000"
                     style="width: {{ ($timeLeft / $level->time_limit) * 100 }}%"></div>
            </div>
        </div>

        <div class="px-6 pb-6">
            {{-- Target text dengan highlight --}}
            <div class="bg-slate-900 rounded-xl p-5 font-mono text-sm leading-relaxed mb-4 select-none">
                @php
                    $target = $targetText;
                    $input  = $userInput;
                @endphp
                @for($i = 0; $i < strlen($target); $i++)
                    @php
                        $char = $target[$i];
                        if ($i < strlen($input)) {
                            $class = $input[$i] === $char ? 'text-green-400' : 'text-red-400 bg-red-900/40';
                        } elseif ($i === strlen($input)) {
                            $class = 'bg-white/20 text-white';
                        } else {
                            $class = 'text-slate-500';
                        }
                    @endphp
                    <span class="{{ $class }}">{{ $char === ' ' ? ' ' : $char }}</span>
                @endfor
            </div>

            {{-- Input --}}
            <textarea
                x-ref="inputArea"
                wire:model.live="userInput"
                class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 focus:border-indigo-500 rounded-xl p-4 font-mono text-sm text-slate-800 dark:text-slate-200 resize-none outline-none transition-colors"
                rows="4"
                placeholder="Ketik kode di sini..."
                @keydown.tab.prevent></textarea>

            <div class="flex justify-between items-center mt-3">
                <div class="text-xs text-slate-400">
                    {{ strlen($userInput) }}/{{ strlen($targetText) }} karakter
                </div>
                <button wire:click="finish" class="text-xs text-slate-400 hover:text-red-500 transition-colors">
                    Berhenti
                </button>
            </div>
        </div>
    </div>

    {{-- Polling timer --}}
    <div wire:poll.1000ms="tick" class="hidden"></div>

    {{-- RESULT SCREEN --}}
    @else
    @php $passed = $score >= $level->min_score_to_pass; @endphp
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center">
        <div class="text-6xl mb-4">{{ $passed ? '🎉' : '😅' }}</div>
        <h2 class="text-2xl font-black {{ $passed ? 'text-green-600' : 'text-slate-700 dark:text-slate-300' }} mb-1">
            {{ $passed ? 'Level Selesai!' : 'Coba Lagi!' }}
        </h2>
        <p class="text-sm {{ $passed ? 'text-green-500' : 'text-slate-400' }} mb-8">
            {{ $passed ? '+' . $level->xp_reward . ' XP ditambahkan ke akunmu!' : 'Skor minimal ' . $level->min_score_to_pass . '% untuk lulus.' }}
        </p>

        <div class="grid grid-cols-3 gap-4 mb-8 max-w-sm mx-auto">
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <div class="text-2xl font-black text-indigo-600">{{ $score }}</div>
                <div class="text-xs text-slate-400 mt-1">Skor</div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <div class="text-2xl font-black text-green-600">{{ $wpm }}</div>
                <div class="text-xs text-slate-400 mt-1">WPM</div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <div class="text-2xl font-black text-violet-600">{{ $accuracy }}%</div>
                <div class="text-xs text-slate-400 mt-1">Akurasi</div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-3 flex-wrap">
            <button onclick="location.reload()"
                    class="bg-gradient-to-r from-green-500 to-teal-500 text-white font-bold px-6 py-2.5 rounded-xl hover:opacity-90 active:scale-95 transition-all">
                🔄 Main Lagi
            </button>
            <a href="{{ route('games.index') }}"
               class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold px-6 py-2.5 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                ← Game Arena
            </a>
        </div>
    </div>
    @endif
</div>