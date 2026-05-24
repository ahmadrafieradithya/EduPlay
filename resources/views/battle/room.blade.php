@extends('layouts.app')
@section('page-title', 'Battle Room')
@section('content')
<div class="mb-6">
    <a href="{{ route('battle.index') }}" class="text-sm text-slate-500 hover:underline">← Kembali ke Battle</a>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 text-center">
        <div class="text-sm text-slate-400">Bagikan kode ini ke lawanmu</div>
        <div class="mt-4 inline-flex items-center justify-center px-6 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-3xl font-black tracking-widest">
            {{ $battle->code }}
        </div>
        <div class="mt-3 text-xs text-slate-300">Kode berlaku sekali. Salin dan kirim ke temanmu.</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- Participants --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4">Peserta</h3>
            <div class="space-y-4">
                @php $participants = $battle->participants; @endphp
                @for($i=0;$i<2;$i++)
                    @if(isset($participants[$i]))
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-bold">{{ strtoupper(substr($participants[$i]->name,0,2)) }}</div>
                        <div class="flex-1">
                            <div class="font-semibold text-slate-800 dark:text-white">{{ $participants[$i]->name }}</div>
                            <div class="text-xs text-slate-500">{{ $participants[$i]->email }}</div>
                        </div>
                        @if($battle->winner_id === $participants[$i]->id)
                        <div class="text-green-600 font-bold">Pemenang</div>
                        @endif
                    </div>
                    @else
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-500">Menunggu lawan... <span class="text-xs text-slate-400">(Bagikan kode)</span></div>
                    @endif
                @endfor
            </div>

            @if($battle->status === 'waiting')
            <div class="mt-6 flex gap-3">
                <button type="button" class="flex-1 py-3 bg-indigo-600 text-white font-bold rounded-xl">Saya Siap!</button>
                <a href="{{ route('battle.index') }}" class="px-4 py-3 bg-slate-100 dark:bg-slate-800 rounded-xl">Kembali</a>
            </div>
            @else
            <div class="mt-6 text-center text-sm text-slate-500">Pertandingan sedang berlangsung atau selesai.</div>
            @endif
        </div>

        {{-- Info / Coming soon --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-3">Info Pertandingan</h3>
            <p class="text-sm text-slate-500 mb-4">Level: {{ $battle->level?->title ?? '—' }}</p>
            <div class="rounded-xl bg-amber-50 dark:bg-amber-900/20 p-4">
                <h4 class="font-bold">Coming Soon: Battle Engine</h4>
                <p class="text-sm text-slate-600 dark:text-slate-300 mt-2">Modul battle real-time akan hadir menggunakan Laravel Reverb (WebRTC/Realtime). Untuk saat ini, ruang berfungsi sebagai lobi dan tempat berbagi kode.</p>
            </div>
            <div class="mt-6 text-sm">
                <p class="text-slate-500">Kode room: <span class="font-mono font-bold">{{ $battle->code }}</span></p>
                <p class="text-slate-500">Host: {{ $battle->host?->name ?? '—' }}</p>
                <p class="text-slate-500">Status: {{ ucfirst($battle->status) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
