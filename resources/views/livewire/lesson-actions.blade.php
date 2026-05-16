<div class="space-y-3">
    <div class="flex items-center gap-3">
        <button
            x-data
            x-on:click.prevent="$wire.markComplete()"
            :disabled="{{ $completed ? 'true' : 'false' }}"
            class="px-4 py-2 rounded-2xl bg-gradient-to-r from-purple-600 to-blue-500 text-white hover:opacity-90 transition disabled:opacity-50"
        >
            @if($completed)
                Selesai ✓
            @else
                Tandai Selesai
            @endif
        </button>

        <div class="text-sm text-gray-500 dark:text-gray-400">XP: <strong>{{ $lesson->xp_reward ?? 10 }}</strong></div>
    </div>

    <template x-if="false"></template>
</div>
