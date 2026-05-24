<div class="max-w-2xl mx-auto">

    {{-- START SCREEN --}}
    @if(!$isStarted && !$isFinished)
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center">
        <div class="text-5xl mb-4">❓</div>
        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-1">{{ $level->title }}</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Jawab semua pertanyaan dengan benar!</p>

        <div class="flex items-center justify-center gap-6 text-sm text-slate-400 mb-8">
            <span>📝 {{ count($questions) }} Soal</span>
            <span>⏱ {{ $level->time_limit }}s per soal</span>
            <span>⭐ +{{ $level->xp_reward }} XP</span>
        </div>

        <button wire:click="start"
                class="bg-gradient-to-r from-violet-500 to-purple-600 text-white font-bold px-10 py-3 rounded-xl hover:opacity-90 active:scale-95 transition-all shadow-lg">
            🚀 Mulai Quiz!
        </button>
    </div>

    {{-- QUESTION SCREEN --}}
    @elseif($isStarted && !$isFinished)
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">

        {{-- Progress & Timer --}}
        <div class="px-6 pt-5 pb-0">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Soal {{ $currentIndex + 1 }} dari {{ count($questions) }}
                </span>
                <span class="text-sm font-bold {{ $timeLeft <= 10 ? 'text-red-500 animate-pulse' : 'text-slate-700 dark:text-slate-300' }}">
                    ⏱ {{ $timeLeft }}s
                </span>
            </div>
            <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden mb-1">
                <div class="h-full bg-violet-500 rounded-full transition-all"
                     style="width: {{ (($currentIndex) / count($questions)) * 100 }}%"></div>
            </div>
            <div class="h-1 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden mb-5">
                <div class="h-full {{ $timeLeft <= 10 ? 'bg-red-500' : 'bg-indigo-400' }} rounded-full transition-all duration-1000"
                     style="width: {{ ($timeLeft / $level->time_limit) * 100 }}%"></div>
            </div>
        </div>

        <div class="px-6 pb-6">
            @php $q = $questions[$currentIndex] ?? null; @endphp
            @if($q)

            {{-- Kode jika ada --}}
            @if(isset($q['code']))
            <div class="bg-slate-900 rounded-xl p-4 font-mono text-sm text-green-400 mb-4 whitespace-pre overflow-x-auto">{{ $q['code'] }}</div>
            @endif

            {{-- Pertanyaan --}}
            <p class="text-base font-semibold text-slate-800 dark:text-slate-200 mb-5">
                {{ $q['question'] }}
            </p>

            {{-- Opsi jawaban --}}
            @if(!$showExplanation)
            <div class="space-y-3">
                @foreach($q['options'] as $idx => $opt)
                <button wire:click="selectAnswer({{ $idx }})"
                        class="w-full text-left px-4 py-3 rounded-xl border-2 text-sm font-medium transition-all
                               {{ $selectedAnswer === $idx
                                   ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300'
                                   : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-indigo-300 dark:hover:border-indigo-700 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/50' }}">
                    <span class="inline-block w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 text-center text-xs leading-6 mr-2 font-bold">
                        {{ chr(65 + $idx) }}
                    </span>
                    {{ $opt }}
                </button>
                @endforeach
            </div>

            <button wire:click="submitAnswer"
                    @if($selectedAnswer === null) disabled @endif
                    class="w-full mt-5 py-3 rounded-xl text-sm font-bold transition-all
                           {{ $selectedAnswer !== null
                               ? 'bg-gradient-to-r from-violet-500 to-purple-600 text-white hover:opacity-90 active:scale-95 shadow-md'
                               : 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed' }}">
                Konfirmasi Jawaban
            </button>

            {{-- Penjelasan setelah jawab --}}
            @else
            <div class="space-y-3 mb-5">
                @foreach($q['options'] as $idx => $opt)
                <div class="w-full text-left px-4 py-3 rounded-xl border-2 text-sm font-medium
                            {{ $idx === ($q['correct'] ?? -1)
                                ? 'border-green-500 bg-green-50 dark:bg-green-950 text-green-700 dark:text-green-300'
                                : ($selectedAnswer === $idx && $idx !== ($q['correct'] ?? -1)
                                    ? 'border-red-400 bg-red-50 dark:bg-red-950 text-red-600 dark:text-red-400'
                                    : 'border-slate-100 dark:border-slate-800 text-slate-400') }}">
                    <span class="inline-block w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 text-center text-xs leading-6 mr-2 font-bold">
                        {{ chr(65 + $idx) }}
                    </span>
                    {{ $opt }}
                    @if($idx === ($q['correct'] ?? -1)) <span class="ml-2">✅</span> @endif
                    @if($selectedAnswer === $idx && $idx !== ($q['correct'] ?? -1)) <span class="ml-2">❌</span> @endif
                </div>
                @endforeach
            </div>

            @if(isset($q['explanation']))
            <div class="bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 rounded-xl p-4 text-sm text-blue-700 dark:text-blue-300 mb-5">
                💡 <strong>Penjelasan:</strong> {{ $q['explanation'] }}
            </div>
            @endif

            <button wire:click="nextQuestion"
                    class="w-full py-3 bg-gradient-to-r from-violet-500 to-purple-600 text-white font-bold rounded-xl hover:opacity-90 active:scale-95 transition-all">
                {{ $currentIndex + 1 >= count($questions) ? '🏁 Lihat Hasil' : 'Soal Berikutnya →' }}
            </button>
            @endif
            @endif
        </div>
    </div>

    {{-- Polling timer --}}
    <div wire:poll.1000ms="tick" class="hidden"></div>

    {{-- RESULT SCREEN --}}
    @else
    @php
        $total     = count($questions);
        $passed    = $score >= $level->min_score_to_pass;
        $scorePct  = $total > 0 ? round(($score / $total) * 100) : 0;
    @endphp
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center">
        <div class="text-6xl mb-4">{{ $passed ? '🏆' : '😅' }}</div>
        <h2 class="text-2xl font-black {{ $passed ? 'text-green-600' : 'text-slate-700 dark:text-slate-300' }} mb-1">
            {{ $passed ? 'Quiz Selesai!' : 'Hampir!' }}
        </h2>
        <p class="text-sm {{ $passed ? 'text-green-500' : 'text-slate-400' }} mb-8">
            {{ $passed ? '+' . $level->xp_reward . ' XP ditambahkan!' : 'Perlu ' . $level->min_score_to_pass . '% untuk lulus. Coba lagi!' }}
        </p>

        <div class="grid grid-cols-2 gap-4 mb-8 max-w-xs mx-auto">
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <div class="text-2xl font-black text-violet-600">{{ $score }}/{{ $total }}</div>
                <div class="text-xs text-slate-400 mt-1">Jawaban Benar</div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <div class="text-2xl font-black {{ $passed ? 'text-green-600' : 'text-red-500' }}">{{ $scorePct }}%</div>
                <div class="text-xs text-slate-400 mt-1">Nilai</div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-3 flex-wrap">
            <button onclick="location.reload()"
                    class="bg-gradient-to-r from-violet-500 to-purple-600 text-white font-bold px-6 py-2.5 rounded-xl hover:opacity-90 active:scale-95 transition-all">
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