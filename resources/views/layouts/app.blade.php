<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#f8fafc">
        <title>{{ $title ?? config('app.name', 'EduPlay') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */ @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="min-h-screen bg-slate-50">
            <header class="border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-5 sm:px-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-base font-semibold text-slate-900">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-500 text-white">E</span>
                        <span>{{ config('app.name', 'EduPlay') }}</span>
                    </a>

                    <div class="flex items-center gap-4 text-sm text-slate-600">
                        <span class="hidden sm:inline">Signed in as {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 transition hover:bg-slate-50">Log out</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-6 py-10 sm:px-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>
