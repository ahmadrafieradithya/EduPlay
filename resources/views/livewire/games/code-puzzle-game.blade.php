@php
    $data = json_decode($level->content, true);
    $hints = $data['hints'] ?? [];
@endphp

<div class="w-full max-w-4xl mx-auto">
    <!-- Timer and Header -->
    <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-950">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                    {{ $data['description'] ?? 'Code Puzzle' }}
                </h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Bahasa: <span class="font-mono text-indigo-600 dark:text-indigo-400">{{ strtoupper($data['language'] ?? 'unknown') }}</span>
                </p>
            </div>
            <div class="text-right">
                <div class="text-5xl font-bold {{ $timeRemaining <= 10 ? 'text-red-600 dark:text-red-400' : 'text-indigo-600 dark:text-indigo-400' }}">
                    {{ str_pad($timeRemaining, 2, '0', STR_PAD_LEFT) }}s
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Sisa Waktu</p>
            </div>
        </div>

        @if(!$isSubmitted)
            <div class="h-1 bg-slate-200 rounded-full overflow-hidden dark:bg-slate-800">
                <div class="h-full {{ $timeRemaining <= 10 ? 'bg-red-500' : 'bg-indigo-500' }} transition-all duration-1000"
                     style="width: {{ ($timeRemaining / $totalTime) * 100 }}%"></div>
            </div>
        @endif
    </div>

    @if(!$isSubmitted)
        <!-- Game Content -->
        <div class="rounded-3xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-950 mb-6">
            <!-- Instructions -->
            <div class="mb-6 p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                <p class="text-sm text-blue-900 dark:text-blue-100">
                    📋 <strong>Instruksi:</strong> Drag & drop potongan kode di bawah untuk menyusun urutan yang benar.
                </p>
            </div>

            <!-- Code Pieces Container -->
            <div x-data="codeDropzone()" class="space-y-4">
                <!-- Target Area (where user orders pieces) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                        ✍️ Susun Kode (Drag kesini):
                    </label>
                    <div x-ref="sortable"
                         @sort="$wire.dispatch('updateOrder', { order: $event.detail.order })"
                         class="min-h-48 rounded-2xl border-2 border-dashed border-indigo-300 bg-indigo-50/50 p-4 dark:border-indigo-700 dark:bg-indigo-900/10 space-y-3">
                        @forelse($userOrder as $piece)
                            <div draggable="true" 
                                 data-id="{{ $piece['id'] }}"
                                 class="flex items-center gap-2 rounded-xl bg-white p-3 shadow-sm cursor-move dark:bg-slate-900 border-l-4 border-indigo-500 hover:shadow-md transition">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 2a1 1 0 11-2 0 1 1 0 012 0zM7 6a1 1 0 11-2 0 1 1 0 012 0zM7 10a1 1 0 11-2 0 1 1 0 012 0zM13 2a1 1 0 11-2 0 1 1 0 012 0zM13 6a1 1 0 11-2 0 1 1 0 012 0zM13 10a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                                <code class="flex-1 font-mono text-sm text-slate-700 dark:text-slate-300">
                                    {{ $piece['content'] }}
                                </code>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-slate-500 dark:text-slate-400">Drag potongan kode kesini...</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Available Pieces (drag from here) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                        📦 Potongan Kode:
                    </label>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($pieces as $piece)
                            @if(!in_array($piece, $userOrder))
                                <div draggable="true"
                                     data-id="{{ $piece['id'] }}"
                                     class="rounded-xl bg-slate-100 p-3 cursor-grab hover:bg-slate-200 active:cursor-grabbing dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 transition">
                                    <code class="font-mono text-sm text-slate-700 dark:text-slate-300">
                                        {{ $piece['content'] }}
                                    </code>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Hints Section -->
            @if(!empty($hints))
                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                    <button wire:click="showNextHint"
                            class="inline-flex items-center gap-2 rounded-xl bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-900 hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-100 dark:hover:bg-amber-900/50">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1h2v2H7V4zm2 4H7v2h2V8zm2-4h2v2h-2V4zm2 4h-2v2h2V8z" clip-rule="evenodd"></path>
                        </svg>
                        💡 Hint ({{ $hintsUsed }}/{{ count($hints) }})
                    </button>

                    @if($showHint && $hintsUsed <= count($hints))
                        <div class="mt-3 rounded-xl bg-amber-50 p-3 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                            <p class="text-sm text-amber-900 dark:text-amber-100">
                                {{ $hints[$hintsUsed - 1] ?? 'Tidak ada hint lagi' }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4">
            <button wire:click="submitAnswer"
                    class="flex-1 rounded-2xl bg-indigo-600 px-6 py-3 text-center font-semibold text-white hover:bg-indigo-700 transition disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>✓ Submit Jawaban</span>
                <span wire:loading>Memproses...</span>
            </button>
        </div>

        <!-- Polling for timer -->
        <div wire:poll-5000ms="tick" class="hidden"></div>
    @else
        <!-- Results Screen -->
        <div class="rounded-3xl border border-slate-200 bg-white p-8 dark:border-slate-800 dark:bg-slate-950 text-center mb-6">
            @if($resultData['passed'])
                <div class="mb-6">
                    <div class="text-6xl mb-4">🎉</div>
                    <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">Sempurna!</h3>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">Anda menjawab dengan benar!</p>
                </div>
            @else
                <div class="mb-6">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Hasil Anda</h3>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">Tingkat akurasi: {{ $resultData['accuracy'] }}%</p>
                </div>
            @endif

            <!-- Score Breakdown -->
            <div class="grid grid-cols-3 gap-4 my-8">
                <div class="rounded-2xl bg-indigo-50 p-4 dark:bg-indigo-900/20">
                    <p class="text-xs text-slate-600 dark:text-slate-400">Akurasi</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $resultData['accuracy'] }}%</p>
                </div>
                <div class="rounded-2xl bg-amber-50 p-4 dark:bg-amber-900/20">
                    <p class="text-xs text-slate-600 dark:text-slate-400">Bonus Waktu</p>
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $resultData['timeBonus'] }}%</p>
                </div>
                <div class="rounded-2xl bg-purple-50 p-4 dark:bg-purple-900/20">
                    <p class="text-xs text-slate-600 dark:text-slate-400">Multiplier</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($resultData['multiplier'], 1) }}x</p>
                </div>
            </div>

            <!-- Final Score -->
            <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 p-6 text-white mb-8">
                <p class="text-sm mb-2">Skor Akhir</p>
                <p class="text-5xl font-bold">{{ $score }}</p>
            </div>

            <!-- XP Reward -->
            <div class="rounded-2xl bg-gradient-to-r from-amber-400 to-orange-500 p-6 text-white mb-8">
                <p class="text-sm mb-2">XP Diperoleh</p>
                <p class="text-4xl font-bold">+{{ $xpEarned }} XP</p>
            </div>

            <!-- Score Calculation Formula -->
            <div class="rounded-2xl bg-slate-100 p-4 dark:bg-slate-900 text-left mb-8 text-sm text-slate-700 dark:text-slate-300">
                <p class="font-mono">
                    <span class="text-indigo-600 dark:text-indigo-400">Score</span> = ({{ $resultData['accuracy'] }}% + {{ $resultData['timeBonus'] }}) / 2 × {{ number_format($resultData['multiplier'], 1) }}
                </p>
                <p class="font-mono text-slate-600 dark:text-slate-400 mt-2">
                    = {{ number_format($resultData['baseScore'], 1) }} × {{ number_format($resultData['multiplier'], 1) }} = <strong>{{ $score }}</strong>
                </p>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4">
            @if($resultData['passed'])
                <a href="{{ $getNextLevel() }}"
                   class="flex-1 rounded-2xl bg-green-600 px-6 py-3 text-center font-semibold text-white hover:bg-green-700 transition inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Level Berikutnya
                </a>
            @else
                <button wire:navigate href="{{ $tryAgain() }}"
                        class="flex-1 rounded-2xl bg-indigo-600 px-6 py-3 text-center font-semibold text-white hover:bg-indigo-700 transition inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Coba Lagi
                </button>
            @endif

            <a href="{{ route('games.index') }}"
               class="flex-1 rounded-2xl border border-slate-200 px-6 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50 transition dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-900">
                Kembali ke Game
            </a>
        </div>
    @endif
</div>

<script>
function codeDropzone() {
    return {
        init() {
            this.setupSortable();
        },
        setupSortable() {
            const sortable = this.$refs.sortable;
            if (!sortable) return;

            new Sortable(sortable, {
                animation: 150,
                ghostClass: 'opacity-50',
                dragClass: 'shadow-lg',
                onEnd: () => this.updateOrderInLivewire(),
            });
        },
        updateOrderInLivewire() {
            const sortable = this.$refs.sortable;
            const items = Array.from(sortable.children);
            const order = items.map(item => {
                const id = item.dataset.id;
                return {
                    id: parseInt(id),
                    content: item.querySelector('code').textContent,
                    originalIndex: parseInt(id),
                };
            });

            @this.dispatch('updateOrder', { order });
        },
    };
}

// Load Sortable.js from CDN if not already loaded
if (typeof Sortable === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js';
    document.head.appendChild(script);
}
</script>
