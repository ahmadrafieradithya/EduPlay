<!DOCTYPE html>
<html lang="id" x-data="{ 
    sidebarOpen: true, 
    darkMode: Alpine.$persist(false).as('eduplay_dark'),
    showAchievement: false,
    achievementData: {}
}" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — EduPlay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 dark:bg-slate-950 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        {{-- ===== SIDEBAR ===== --}}
        <aside class="flex flex-col w-56 bg-indigo-950 flex-shrink-0 transition-all duration-300"
               :class="{ '-translate-x-full absolute z-50 h-full': !sidebarOpen }">
            
            {{-- Logo + Nama Sekolah --}}
            <div class="px-4 py-4 border-b border-indigo-900">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white leading-none">EduPlay</div>
                        <div class="text-[10px] text-indigo-400 mt-0.5 truncate max-w-[110px]">
                            {{ auth()->user()->school->name ?? 'Platform Edukasi' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- XP Bar --}}
            @auth
            <div class="px-4 py-3 border-b border-indigo-900">
                @php
                    $userXp = auth()->user()->xp ?? null;
                    $totalXp = $userXp?->total_xp ?? 0;
                    $level = $userXp?->level ?? null;
                    $levelNum = $level?->level_number ?? 1;
                    $levelTitle = $level?->title ?? 'Murid Baru';
                    $minXp = $level?->min_xp ?? 0;
                    $maxXp = $level?->max_xp ?? 100;
                    $progress = $maxXp > $minXp ? min(100, (($totalXp - $minXp) / ($maxXp - $minXp)) * 100) : 0;
                @endphp
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-[10px] font-medium text-indigo-300">⭐ Lv.{{ $levelNum }} {{ $levelTitle }}</span>
                    <span class="text-[10px] text-indigo-500">{{ number_format($totalXp) }} XP</span>
                </div>
                <div class="h-1.5 bg-indigo-900 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 rounded-full transition-all duration-700"
                         style="width: {{ $progress }}%"></div>
                </div>
            </div>

            {{-- Streak --}}
            @php
                $streak = auth()->user()->streak;
                $currentStreak = $streak?->current_streak ?? 0;
            @endphp
            <div class="px-4 py-2.5 border-b border-indigo-900 flex items-center">
                <span class="text-sm mr-1.5">🔥</span>
                <span class="text-[11px] text-indigo-400">Streak harian</span>
                <span class="ml-auto text-[13px] font-semibold text-orange-400">{{ $currentStreak }} hari</span>
            </div>
            @endauth

            {{-- Navigation --}}
            <nav class="flex-1 px-2.5 py-3 space-y-0.5 overflow-y-auto">
                @php
                    $navItems = [
                        ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Beranda'],
                        ['route' => 'learn.index', 'icon' => 'book-open', 'label' => 'Materi Belajar'],
                        ['route' => 'games.index', 'icon' => 'puzzle-piece', 'label' => 'Game Arena', 'badge' => '5'],
                        ['route' => 'battle.index', 'icon' => 'bolt', 'label' => 'Battle Mode'],
                        ['route' => 'editor.index', 'icon' => 'code-bracket', 'label' => 'Code Editor'],
                        ['route' => 'leaderboard.index', 'icon' => 'trophy', 'label' => 'Leaderboard'],
                        ['route' => 'badges.index', 'icon' => 'star', 'label' => 'Badge Saya'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @if(Route::has($item['route']))
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12px] transition-colors group
                              {{ request()->routeIs($item['route']) 
                                 ? 'bg-indigo-800/60 text-indigo-200 font-medium' 
                                 : 'text-indigo-400 hover:bg-indigo-900/50 hover:text-indigo-300' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            @if($item['icon'] === 'home')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            @elseif($item['icon'] === 'book-open')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            @elseif($item['icon'] === 'puzzle-piece')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                            @elseif($item['icon'] === 'bolt')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            @elseif($item['icon'] === 'code-bracket')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
                            @elseif($item['icon'] === 'trophy')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            @endif
                        </svg>
                        <span class="flex-1">{{ $item['label'] }}</span>
                        @if(isset($item['badge']))
                            <span class="text-[9px] bg-indigo-700 text-indigo-200 rounded-full px-1.5 py-0.5">{{ $item['badge'] }}</span>
                        @endif
                    </a>
                    @endif
                @endforeach
            </nav>

            {{-- User Info --}}
            @auth
            <div class="px-3 py-3 border-t border-indigo-900 flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center text-[10px] font-semibold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-[11px] font-medium text-indigo-200 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[9px] text-indigo-500">Siswa</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:text-indigo-400 transition-colors" title="Keluar">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
            @endauth

        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            
            {{-- Top Header --}}
            <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 h-12 flex items-center px-5 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 mr-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-sm font-semibold text-slate-800 dark:text-slate-200 flex-1">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center gap-2">
                    {{-- Notifikasi --}}
                    <button class="relative p-1.5 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    {{-- Dark Mode --}}
                    <button @click="darkMode = !darkMode" class="p-1.5 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                        </svg>
                    </button>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-5">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Achievement Toast --}}
    <div x-show="showAchievement" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 bg-white dark:bg-slate-800 border border-indigo-200 dark:border-indigo-800 
                rounded-xl shadow-lg p-4 flex items-center gap-3 z-50 max-w-xs">
        <div class="text-3xl" x-text="achievementData.icon ?? '🏆'"></div>
        <div>
            <div class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">Badge Baru!</div>
            <div class="text-sm font-semibold text-slate-800 dark:text-slate-200" x-text="achievementData.name ?? ''"></div>
            <div class="text-xs text-slate-500" x-text="achievementData.description ?? ''"></div>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
