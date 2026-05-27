<div class="min-h-screen bg-gray-950 text-white p-4"
     x-data="{ selected: null }">

    {{-- ===================== START SCREEN ===================== --}}
    @if (!$isStarted)
        <div class="max-w-2xl mx-auto mt-16 text-center">
            <div class="bg-gray-900 rounded-2xl p-8 border border-gray-800 shadow-xl">
                <div class="text-5xl mb-4">🧩</div>
                <h1 class="text-3xl font-bold text-white mb-2">{{ $level->title }}</h1>
                <p class="text-gray-400 mb-6">{{ $level->description }}</p>

                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-2xl font-bold text-indigo-400">{{ count($correctOrder) }}</div>
                        <div class="text-sm text-gray-400">Potongan Kode</div>
                    </div>
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-2xl font-bold text-yellow-400">{{ $level->time_limit }}s</div>
                        <div class="text-sm text-gray-400">Batas Waktu</div>
                    </div>
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-2xl font-bold text-green-400">+{{ $level->xp_reward }}</div>
                        <div class="text-sm text-gray-400">XP Reward</div>
                    </div>
                </div>

                @php
                    $content = is_array($level->content) ? $level->content : json_decode($level->content, true);
                @endphp

                @if (!empty($content['description']))
                    <div class="bg-gray-800 rounded-xl p-4 mb-6 text-left">
                        <p class="text-sm text-gray-300 font-semibold mb-2">📋 Deskripsi Puzzle:</p>
                        <p class="text-gray-400 text-sm">{{ $content['description'] }}</p>
                    </div>
                @endif

                <button wire:click="start"
                    class="w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition-all transform hover:scale-105">
                    🚀 Mulai Puzzle!
                </button>

                <a href="{{ route('games.arena') }}"
                    class="block mt-4 text-gray-500 hover:text-gray-300 text-sm transition-colors">
                    ← Kembali ke Game Arena
                </a>
            </div>
        </div>
    @endif

    {{-- ===================== GAME SCREEN ===================== --}}
    @if ($isStarted && !$isFinished)
        <div class="max-w-4xl mx-auto" wire:poll.1000ms="tick">

            {{-- Header Info --}}
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">🧩 {{ $level->title }}</h2>
                <div class="flex items-center gap-4">
                    @if ($showHint)
                        <span class="text-xs bg-yellow-900 text-yellow-300 px-3 py-1 rounded-full">
                            💡 {{ $hint }}
                        </span>
                    @endif
                    <span class="text-sm {{ $timeLeft <= 10 ? 'text-red-400' : 'text-green-400' }} font-mono font-bold">
                        ⏱ {{ $timeLeft }}s
                    </span>
                </div>
            </div>

            {{-- Timer Bar --}}
            @php $pct = $level->time_limit > 0 ? ($timeLeft / $level->time_limit) * 100 : 0; @endphp
            <div class="w-full bg-gray-800 rounded-full h-2 mb-6">
                <div class="h-2 rounded-full transition-all duration-1000 {{ $timeLeft <= 10 ? 'bg-red-500' : 'bg-green-500' }}"
                     style="width: {{ $pct }}%"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- POOL AREA --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 mb-3 uppercase tracking-wider">
                        🃏 Kode Tersedia (klik untuk pilih)
                    </h3>
                    <div class="space-y-2 min-h-[200px]">
                        @forelse ($pieces as $idx => $piece)
                            <button
                                x-on:click="selected = {{ $idx }}"
                                :class="selected === {{ $idx }}
                                    ? 'ring-2 ring-indigo-400 bg-indigo-900/40'
                                    : 'bg-gray-800 hover:bg-gray-700'"
                                class="w-full text-left px-4 py-2 rounded-lg font-mono text-sm text-green-300 transition-all border border-gray-700 cursor-pointer">
                                {{ $piece['text'] }}
                            </button>
                        @empty
                            <div class="text-center text-gray-600 py-8 border-2 border-dashed border-gray-800 rounded-xl">
                                Semua piece sudah ditempatkan!
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- SLOTS AREA --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 mb-3 uppercase tracking-wider">
                        📋 Susun di Sini (klik slot untuk menempatkan)
                    </h3>
                    <div class="space-y-2">
                        @foreach ($placedPieces as $slotIdx => $placed)
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-600 w-5 text-right flex-shrink-0">{{ $slotIdx + 1 }}</span>

                                @if ($placed !== null)
                                    {{-- Slot terisi --}}
                                    <div class="flex-1 flex items-center justify-between bg-indigo-900/30 border border-indigo-700 rounded-lg px-4 py-2">
                                        <span class="font-mono text-sm text-indigo-300">{{ $placed['text'] }}</span>
                                        <button wire:click="removePiece({{ $slotIdx }})"
                                            class="text-red-400 hover:text-red-300 ml-2 text-xs flex-shrink-0 transition-colors"
                                            title="Hapus">
                                            ✕
                                        </button>
                                    </div>
                                @else
                                    {{-- Slot kosong --}}
                                    <button
                                        x-on:click="if (selected !== null) { $wire.placePiece(selected, {{ $slotIdx }}); selected = null; }"
                                        :class="selected !== null ? 'border-indigo-500 hover:bg-indigo-900/20 cursor-pointer' : 'border-gray-700 cursor-default'"
                                        class="flex-1 border-2 border-dashed rounded-lg px-4 py-2 text-left transition-all">
                                        <span class="text-xs text-gray-600"
                                              :class="selected !== null ? 'text-indigo-400' : 'text-gray-600'">
                                            <span x-show="selected !== null">← Klik untuk tempatkan di sini</span>
                                            <span x-show="selected === null">Kosong</span>
                                        </span>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 mt-6">
                <button wire:click="showNextHint"
                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-500 text-white rounded-lg text-sm font-medium transition-colors">
                    💡 Ambil Hint
                </button>
                <button wire:click="checkAnswer"
                    class="flex-1 py-2 bg-green-600 hover:bg-green-500 text-white rounded-lg font-bold transition-colors">
                    ✅ Cek Jawaban
                </button>
            </div>
        </div>
    @endif

    {{-- ===================== RESULT SCREEN ===================== --}}
    @if ($isFinished)
        @php
            $isPassed = $score >= $level->min_score_to_pass;
            $total = count($correctOrder);
        @endphp
        <div class="max-w-lg mx-auto mt-16 text-center">
            <div class="bg-gray-900 rounded-2xl p-8 border {{ $isPassed ? 'border-green-700' : 'border-red-800' }} shadow-xl">
                <div class="text-6xl mb-4">{{ $isPassed ? '🎉' : '😢' }}</div>
                <h2 class="text-2xl font-bold mb-1">{{ $isPassed ? 'Puzzle Selesai!' : 'Belum Berhasil' }}</h2>
                <p class="text-gray-400 text-sm mb-6">
                    {{ $isPassed ? 'Kamu berhasil menyusun kode dengan benar!' : 'Jangan menyerah, coba lagi!' }}
                </p>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-3xl font-bold {{ $isPassed ? 'text-green-400' : 'text-red-400' }}">
                            {{ $score }}
                        </div>
                        <div class="text-xs text-gray-400">Skor</div>
                    </div>
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-3xl font-bold text-indigo-400">
                            {{ $correctCount }}/{{ $total }}
                        </div>
                        <div class="text-xs text-gray-400">Benar</div>
                    </div>
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-3xl font-bold text-yellow-400">
                            @if ($isPassed) +{{ $level->xp_reward }} @else 0 @endif
                        </div>
                        <div class="text-xs text-gray-400">XP</div>
                    </div>
                </div>

                @if ($isPassed)
                    <div class="bg-green-900/30 border border-green-700 rounded-xl p-3 mb-6">
                        <p class="text-green-300 text-sm">
                            🌟 Selamat! Kamu mendapat <strong>{{ $level->xp_reward }} XP</strong>!
                        </p>
                    </div>
                @endif

                <div class="flex gap-3">
                    <button onclick="location.reload()"
                        class="flex-1 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
                        🔄 Main Lagi
                    </button>
                    <a href="{{ route('games.arena') }}"
                        class="flex-1 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-medium transition-colors text-center">
                        ← Game Arena
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>