<div class="space-y-6" wire:key="lesson-player-{{ $lesson->id }}">
    {{-- XP Animation Toast --}}
    @if($showXpAnimation)
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-4"
             @load="setTimeout(() => show = false, 3000)"
             class="fixed bottom-6 right-6 bg-gradient-to-r from-amber-400 to-orange-500 text-white rounded-2xl shadow-lg p-4 z-50 max-w-xs">
            <div class="flex items-center gap-3">
                <div class="text-3xl animate-bounce">⭐</div>
                <div>
                    <div class="font-semibold">+{{ $xpEarned }} XP!</div>
                    <div class="text-sm opacity-90">Lesson selesai! Terus semangat 🔥</div>
                </div>
            </div>
        </div>
    @endif

        <div class="min-h-screen bg-slate-100 dark:bg-slate-950">
            <div class="bg-black">
                <div class="max-w-6xl mx-auto">
                    @if($lesson->video_url)
                    <div class="aspect-video">
                        <iframe class="w-full h-full"
                                src="https://www.youtube.com/embed/{{ \Str::afterLast($lesson->video_url, '/') }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    @endif
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-3 gap-8">
                    <div class="col-span-2">
                        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">{{ $lesson->title }}</h1>
                        <div class="flex gap-4 text-sm text-slate-600 dark:text-slate-400 mb-8">
                            <span>⏱️ {{ $lesson->duration_minutes ?? 15 }} menit</span>
                            <span>⭐ {{ $lesson->xp_reward ?? 50 }} XP</span>
                            <span>{{ $isCompleted ? '✅ Sudah Selesai' : '⏳ Belum Selesai' }}</span>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            {!! $lesson->content !!}
                        </div>

                        <div class="flex justify-between gap-4 mt-12">
                            @if($previousLesson)
                            <a href="{{ route('learn.lesson', $previousLesson) }}" class="flex-1 px-6 py-3 bg-slate-200 rounded-lg text-center font-semibold hover:bg-slate-300 transition">
                                ← Pelajaran Sebelumnya
                            </a>
                            @else
                            <div class="flex-1"></div>
                            @endif

                            @if(!$isCompleted)
                            <button wire:click="completeLesson" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                                ✅ Tandai Selesai
                            </button>
                            @elseif($nextLesson)
                            <button wire:click="goToNextLesson" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                                Lanjut →
                            </button>
                            @endif
                        </div>
                    </div>

                    <div>
                        @if($showCompletionModal)
                        <div class="bg-white dark:bg-slate-800 rounded-lg p-6 sticky top-4">
                            <div class="text-center">
                                <div class="text-6xl animate-bounce mb-4">🎉</div>
                                <h3 class="text-xl font-bold mb-2">Selesai!</h3>
                                <div class="bg-yellow-100 rounded-lg p-4">
                                    <div class="text-3xl font-bold text-yellow-600">+{{ $xpGained }} XP</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    {{-- Article Content --}}
    @if($lesson->type === 'article' && $lesson->content)
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-950">
            <div class="prose dark:prose-invert max-w-none">
                {!! $lesson->content !!}
            </div>
        </div>
    @endif

    {{-- Code Content --}}
    @if($lesson->type === 'code' && $lesson->content)
        <div class="rounded-3xl border border-slate-200 bg-slate-950 p-6 shadow-sm overflow-x-auto dark:border-slate-800">
            <pre><code class="text-slate-100 text-sm font-mono">{!! htmlspecialchars($lesson->content) !!}</code></pre>
        </div>
    @endif

    {{-- Mark Complete Button --}}
    <div class="flex items-center justify-center py-4">
        @if(!$isCompleted)
            <button wire:click="markComplete" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-8 py-4 text-base font-semibold text-white transition hover:bg-indigo-700 disabled:opacity-50">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                          clip-rule="evenodd" />
                </svg>
                <span wire:loading.remove>Tandai Selesai</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        @else
            <div class="inline-flex items-center gap-2 rounded-2xl bg-green-100 px-8 py-4 text-base font-semibold text-green-700 dark:bg-green-900 dark:text-green-100">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                          clip-rule="evenodd" />
                </svg>
                Sudah Selesai ✓
            </div>
        @endif
    </div>
</div>
