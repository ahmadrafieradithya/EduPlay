<div class="relative">
    @if($showXpAnimation)
    <div class="absolute -top-12 left-1/2 -translate-x-1/2 z-50">
        <div class="bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg animate-bounce whitespace-nowrap">
            🎉 +{{ $xpEarned }} XP Diperoleh!
        </div>
    </div>
    @endif

    @if($isCompleted)
    <div class="flex items-center gap-2 text-green-600 dark:text-green-400 font-semibold text-sm py-2.5 px-4 bg-green-50 dark:bg-green-950 rounded-xl border border-green-200 dark:border-green-800">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Materi Selesai!
    </div>
    @else
    <button wire:click="markComplete" wire:loading.attr="disabled"
            class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all active:scale-95 disabled:opacity-60 shadow-md hover:shadow-lg">
        <span wire:loading.remove wire:target="markComplete">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </span>
        <span wire:loading wire:target="markComplete">
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </span>
        <span wire:loading.remove wire:target="markComplete">Tandai Selesai (+{{ $lesson->xp_reward }} XP)</span>
        <span wire:loading wire:target="markComplete">Menyimpan...</span>
    </button>
    @endif
</div>
