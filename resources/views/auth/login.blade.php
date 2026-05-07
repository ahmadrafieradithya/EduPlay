@extends('layouts.guest')

@section('content')
    <div class="space-y-8">
        <div class="rounded-[2rem] border border-white/10 bg-slate-950/95 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur-xl sm:p-10">
            <div class="space-y-3 text-center">
                <p class="text-sm uppercase tracking-[0.35em] text-sky-400">EduPlay sign in</p>
                <h1 class="text-3xl font-semibold text-white">Welcome back.</h1>
                <p class="mx-auto max-w-xl text-sm leading-6 text-slate-300">Sign in to access your dashboard, progress tracking, and gamified learning experience.</p>
            </div>

            @if (session('status'))
                <div class="mt-6 rounded-3xl border border-sky-500/30 bg-sky-500/10 p-4 text-sm text-sky-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-200">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-3xl border border-slate-700/90 bg-slate-950/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20" />
                        @error('email')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-200">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-2 w-full rounded-3xl border border-slate-700/90 bg-slate-950/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20" />
                        @error('password')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-slate-300 transition hover:text-white">Forgot password?</a>
                    <button type="submit" class="rounded-3xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-400">Sign in</button>
                </div>
            </form>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-slate-950/95 p-6 text-center text-sm text-slate-300 shadow-2xl shadow-slate-950/20 backdrop-blur-xl">
            New to EduPlay? <a href="{{ route('register') }}" class="font-semibold text-sky-300 transition hover:text-white">Create your account</a>
        </div>
    </div>
@endsection
