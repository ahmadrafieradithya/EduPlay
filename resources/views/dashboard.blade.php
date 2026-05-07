@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <section class="rounded-[2rem] border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-900/5 sm:p-10">
            <div class="sm:flex sm:items-start sm:justify-between sm:gap-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-sky-500">Dashboard</p>
                    <h1 class="mt-4 text-3xl font-semibold text-slate-900">Welcome back, {{ auth()->user()->name }}.</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">Your classroom, game progress, achievement streaks, and personalized analytics all live here.</p>
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-[1.75rem] border border-slate-200/70 bg-slate-950/95 p-6 text-white shadow-xl shadow-slate-950/10">
                <p class="text-sm uppercase tracking-[0.32em] text-sky-300">In Progress</p>
                <p class="mt-6 text-4xl font-semibold">{{ $progressCount }}</p>
                <p class="mt-2 text-sm text-slate-400">Modules currently in your learning queue.</p>
            </article>

            <article class="rounded-[1.75rem] border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/5">
                <p class="text-sm uppercase tracking-[0.32em] text-slate-500">XP earned</p>
                <p class="mt-6 text-4xl font-semibold text-slate-900">{{ number_format($xpEarned) }}</p>
                <p class="mt-2 text-sm text-slate-500">Points collected from completed modules.</p>
            </article>

            <article class="rounded-[1.75rem] border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/5">
                <p class="text-sm uppercase tracking-[0.32em] text-slate-500">Achievements</p>
                <p class="mt-6 text-4xl font-semibold text-slate-900">{{ $achievementCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Badges unlocked so far.</p>
            </article>

            <article class="rounded-[1.75rem] border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/5">
                <p class="text-sm uppercase tracking-[0.32em] text-slate-500">Classrooms</p>
                <p class="mt-6 text-4xl font-semibold text-slate-900">{{ $classroomCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Active classes available to join.</p>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-[1.75rem] border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/5">
                <h2 class="text-lg font-semibold text-slate-900">Next steps</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Visit your classrooms, continue learning modules, or discover new game sessions and community events.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#" class="rounded-full bg-sky-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-600">View classes</a>
                    <a href="#" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">See achievements</a>
                </div>
            </div>

            <div class="lg:col-span-2 rounded-[1.75rem] border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Recent activity</h2>
                        <p class="mt-2 text-sm text-slate-600">Your latest progress and streaks are displayed here.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-slate-600">Live</span>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Completed modules</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $progressCount }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Current streak</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $xpEarned > 0 ? intval($xpEarned / 100) : 0 }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
