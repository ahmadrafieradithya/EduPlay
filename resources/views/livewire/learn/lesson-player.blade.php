<div class="relative">
    {{-- XP Animation --}}
    @if($showXpAnimation)
    <div class="absolute -top-12 left-1/2 -translate-x-1/2 z-50">
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-600 text-white text-sm font-bold px-5 py-3 rounded-full shadow-xl animate-bounce whitespace-nowrap flex items-center gap-2">
            <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            +{{ $xpEarned }} XP
        </div>
    </div>
    @endif

    {{-- Completed State --}}
    @if($isCompleted)
    <div class="flex items-center gap-2 text-green-600 dark:text-green-400 font-semibold text-sm py-2.5 px-4 bg-green-50 dark:bg-green-950/40 rounded-xl border border-green-200 dark:border-green-800 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Selesai!</span>
    </div>

    {{-- Not Completed State --}}
    @else
    <button wire:click="markComplete" wire:loading.attr="disabled" type="button"
            class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 dark:from-indigo-500 dark:to-violet-500 dark:hover:from-indigo-600 dark:hover:to-violet-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all active:scale-95 disabled:opacity-60 disabled:cursor-not-allowed shadow-md hover:shadow-lg dark:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
        <span wire:loading.remove wire:target="markComplete" class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Tandai Selesai (+{{ $lesson->xp_reward }} XP)
        </span>
        <span wire:loading wire:target="markComplete" class="flex items-center gap-2">
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        </span>
    </button>
    @endif
</div>
