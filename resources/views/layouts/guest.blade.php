<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0f172a">
        <title>{{ $title ?? config('app.name', 'EduPlay') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */ @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.18),transparent_35%),radial-gradient(circle_at_20%_30%,rgba(168,85,247,0.18),transparent_24%),linear-gradient(180deg,#020617_0%,#07172b_100%)]">
            <header class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-6 sm:px-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-sky-200 shadow-xl shadow-slate-950/20 transition hover:border-white/20 hover:bg-white/10">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-400/15 text-sky-200">E</span>
                    {{ config('app.name', 'EduPlay') }}
                </a>

                <nav class="flex items-center gap-3 text-sm">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-2xl border border-slate-700/80 bg-white/5 px-4 py-3 text-slate-100 transition hover:border-slate-500/80 hover:bg-white/10">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-2xl border border-slate-700/80 bg-white/5 px-4 py-3 text-slate-100 transition hover:border-slate-500/80 hover:bg-white/10">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-2xl border border-sky-500/30 bg-sky-500/10 px-4 py-3 text-sky-100 transition hover:border-sky-400/60 hover:bg-sky-500/20">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </header>

            <main class="mx-auto max-w-3xl px-6 pb-12 sm:px-8">
                <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950/90 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur-xl sm:p-12">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
