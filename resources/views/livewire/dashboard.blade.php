<div class="space-y-8">
    <section class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-sky-600 via-sky-700 to-indigo-600 p-8 text-white shadow-2xl shadow-slate-900/20 sm:p-10">
        <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr] lg:items-center">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-sky-200/90">Dashboard</p>
                <h1 class="mt-4 text-4xl font-semibold tracking-tight sm:text-5xl">Halo, {{ auth()->user()->name }}.</h1>
                <p class="mt-4 max-w-2xl text-base leading-7 text-sky-100/90">Selamat datang di pusat pembelajaranmu. Lihat ringkasan kemajuan, pencapaian, dan kelas aktif yang siap membantu kamu berkembang setiap hari.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <article class="rounded-[1.75rem] bg-white/10 p-5 backdrop-blur-xl ring-1 ring-white/10">
                    <p class="text-sm uppercase tracking-[0.32em] text-sky-200">Total progress</p>
                    <p class="mt-5 text-3xl font-semibold">{{ $progressCount }}</p>
                    <p class="mt-2 text-sm text-sky-100/80">Modul dalam antrean belajarmu.</p>
                </article>
                <article class="rounded-[1.75rem] bg-white/10 p-5 backdrop-blur-xl ring-1 ring-white/10">
                    <p class="text-sm uppercase tracking-[0.32em] text-sky-200">Achievement</p>
                    <p class="mt-5 text-3xl font-semibold">{{ $achievementCount }}</p>
                    <p class="mt-2 text-sm text-sky-100/80">Lencana yang sudah kamu raih.</p>
                </article>
                <article class="rounded-[1.75rem] bg-white/10 p-5 backdrop-blur-xl ring-1 ring-white/10">
                    <p class="text-sm uppercase tracking-[0.32em] text-sky-200">XP earned</p>
                    <p class="mt-5 text-3xl font-semibold">{{ number_format($xpEarned) }}</p>
                    <p class="mt-2 text-sm text-sky-100/80">Poin yang kamu kumpulkan.</p>
                </article>
                <article class="rounded-[1.75rem] bg-white/10 p-5 backdrop-blur-xl ring-1 ring-white/10">
                    <p class="text-sm uppercase tracking-[0.32em] text-sky-200">Classrooms</p>
                    <p class="mt-5 text-3xl font-semibold">{{ $classroomCount }}</p>
                    <p class="mt-2 text-sm text-sky-100/80">Kelas yang tersedia untuk kamu ikuti.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="rounded-[2rem] border border-slate-200/70 bg-white p-8 shadow-xl shadow-slate-900/5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.32em] text-slate-500">Learning snapshot</p>
                    <h2 class="mt-3 text-2xl font-semibold text-slate-900">Lihat ringkasan kemajuanmu hari ini</h2>
                </div>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-sky-600">Aktif</span>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.75rem] border border-slate-200/80 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">Modul selesai</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $progressCount }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200/80 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">XP hari ini</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($xpEarned) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200/70 bg-white p-8 shadow-xl shadow-slate-900/5">
            <p class="text-sm uppercase tracking-[0.32em] text-slate-500">Quick actions</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-900">Aksi cepat</h2>

            <div class="mt-8 space-y-4">
                <a href="#" class="flex items-center gap-4 rounded-[1.75rem] border border-slate-200/80 bg-slate-50 p-6 transition hover:bg-slate-100">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Lanjutkan Belajar</p>
                        <p class="text-sm text-slate-500">Kembali ke modul terakhir</p>
                    </div>
                </a>

                <a href="#" class="flex items-center gap-4 rounded-[1.75rem] border border-slate-200/80 bg-slate-50 p-6 transition hover:bg-slate-100">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Lihat Pencapaian</p>
                        <p class="text-sm text-slate-500">Periksa lencana dan reward</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>