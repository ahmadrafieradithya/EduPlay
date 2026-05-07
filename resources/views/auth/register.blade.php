@extends('layouts.guest')

@section('content')
    <div class="space-y-8">
        <div class="rounded-[2rem] border border-white/10 bg-slate-950/95 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur-xl sm:p-10">
            <div class="space-y-3 text-center">
                <p class="text-sm uppercase tracking-[0.35em] text-sky-400">Create your account</p>
                <h1 class="text-3xl font-semibold text-white">Get started with EduPlay.</h1>
                <p class="mx-auto max-w-xl text-sm leading-6 text-slate-300">Join your classroom, track progress, and earn achievements in a gamified learning space.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-200">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="mt-2 w-full rounded-3xl border border-slate-700/90 bg-slate-950/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20" />
                        @error('name')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-200">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-slate-700/90 bg-slate-950/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20" />
                        @error('email')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-200">Password</label>
                        <input id="password" type="password" name="password" required class="mt-2 w-full rounded-3xl border border-slate-700/90 bg-slate-950/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20" />
                        @error('password')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-200">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-2 w-full rounded-3xl border border-slate-700/90 bg-slate-950/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20" />
                    </div>
                </div>

                <button type="submit" class="w-full rounded-3xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-400">Create account</button>
            </form>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-slate-950/95 p-6 text-center text-sm text-slate-300 shadow-2xl shadow-slate-950/20 backdrop-blur-xl">
            Already have an account? <a href="{{ route('login') }}" class="font-semibold text-sky-300 transition hover:text-white">Sign in</a>
        </div>
    </div>
@endsection
