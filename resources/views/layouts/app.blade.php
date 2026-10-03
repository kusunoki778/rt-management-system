<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RT Management System')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-900 antialiased" x-data="{ sidebarOpen: false }">

<!-- Mobile Sidebar Backdrop -->
<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

<!-- Sidebar Navigation -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transform transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- Brand Header -->
    <div class="flex items-center gap-3.5 px-6 py-5 border-b border-slate-800">
        <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-600/30">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V12a1 1 0 011-1h2a1 1 0 011 1v9"/>
            </svg>
        </div>
        <div>
            <div class="text-sm font-bold text-white tracking-tight leading-tight">RT Management</div>
            <div class="text-[11px] font-medium text-emerald-400">Sistem Administrasi RT</div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3.5 py-4 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Dashboard</span>
        </a>

        @if(auth()->user()->isWarga())
        <a href="{{ route('transparansi') }}" class="sidebar-item {{ request()->routeIs('transparansi') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0V5a2 2 0 012-2h2a2 2 0 012 2v14"/></svg>
            <span>Transparansi Kas</span>
        </a>
        <a href="{{ route('surat-pengantar.index') }}" class="sidebar-item {{ request()->routeIs('surat-pengantar.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            <span>Surat Pengantar</span>
        </a>
        <a href="{{ route('pelaporan.warga') }}" class="sidebar-item {{ request()->routeIs('pelaporan.warga') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Pelaporan Warga</span>
        </a>
        @endif

        @if(!auth()->user()->isWarga())
        <div class="pt-4 pb-1.5 px-3.5">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kependudukan</p>
        </div>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
        <a href="{{ route('warga.index') }}" class="sidebar-item {{ request()->routeIs('warga.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>Data Warga</span>
        </a>
        @endif

        @if(!auth()->user()->isWarga() && !auth()->user()->isKetuaRt())
        <div class="pt-4 pb-1.5 px-3.5">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Keuangan RT</p>
        </div>
        <a href="{{ route('pemasukan.index') }}" class="sidebar-item {{ request()->routeIs('pemasukan.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Pemasukan</span>
        </a>
        <a href="{{ route('pengeluaran.index') }}" class="sidebar-item {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>Pengeluaran</span>
        </a>
        <a href="{{ route('pembayaran.verifikasi') }}" class="sidebar-item {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <span>Verifikasi Pembayaran</span>
        </a>
        @endif

        <div class="pt-4 pb-1.5 px-3.5">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Informasi</p>
        </div>
        <a href="{{ route('pengumuman.index') }}" class="sidebar-item {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            <span>Pengumuman</span>
        </a>

        @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
        <a href="{{ route('surat-pengantar.approval') }}" class="sidebar-item {{ request()->routeIs('surat-pengantar.approval') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Persetujuan Surat</span>
        </a>
        <a href="{{ route('pelaporan.kelola') }}" class="sidebar-item {{ request()->routeIs('pelaporan.kelola') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Kelola Pelaporan</span>
        </a>
        @endif

        @if(!auth()->user()->isWarga())
        <div class="pt-4 pb-1.5 px-3.5">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Laporan</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="sidebar-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Laporan</span>
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <div class="pt-4 pb-1.5 px-3.5">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pengaturan</p>
        </div>
        <a href="{{ route('users.index') }}" class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Manajemen Pengguna</span>
        </a>
        @endif
    </nav>

    <!-- User Profile Footer -->
    <div class="p-4 border-t border-slate-800 bg-slate-900/50">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-800 rounded-xl flex items-center justify-center border border-slate-700 text-emerald-400 font-bold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-slate-400 capitalize truncate">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main Container -->
<div class="lg:pl-64 flex flex-col min-h-screen">

    <!-- Top Navbar -->
    <header class="sticky top-0 z-30 bg-white border-b border-slate-200/80 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Mobile Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <!-- Page Title -->
            <div class="hidden lg:block">
                <h1 class="text-base font-bold text-slate-800 tracking-tight">@yield('page-title', 'Dashboard')</h1>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-4 ml-auto">
                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500 bg-slate-100/80 px-3 py-1.5 rounded-lg border border-slate-200/60">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ now()->translatedFormat('d F Y') }}</span>
                </div>

                <!-- User Dropdown Menu -->
                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-slate-100 transition-colors border border-transparent hover:border-slate-200">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-700 font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-slate-700 hidden sm:inline-block">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="userOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" @click.outside="userOpen = false" x-cloak
                        class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-lg border border-slate-200/80 py-2 z-50">
                        <div class="px-4 py-2.5 border-b border-slate-100">
                            <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Pengaturan Profil
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Toast Notifications -->
    @if(session('success'))
    <div x-data="{ showToast: true }" x-show="showToast" x-transition x-init="setTimeout(() => showToast = false, 4000)" x-cloak
        class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl border border-slate-800 max-w-sm">
        <div class="w-6 h-6 bg-emerald-500/20 text-emerald-400 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span class="text-xs font-medium text-slate-200 leading-snug">{{ session('success') }}</span>
        <button @click="showToast = false" class="ml-auto text-slate-400 hover:text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ showErr: true }" x-show="showErr" x-transition x-init="setTimeout(() => showErr = false, 5000)" x-cloak
        class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-rose-950 text-white px-4 py-3 rounded-2xl shadow-xl border border-rose-900 max-w-sm">
        <div class="w-6 h-6 bg-rose-500/20 text-rose-400 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <span class="text-xs font-medium text-rose-200 leading-snug">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="px-8 py-4 border-t border-slate-200/60 bg-white">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-400">
            <p>© {{ date('Y') }} RT Management System · Rukun Tetangga 05 / RW 02</p>
            <p>Versi 1.0 Enterprise</p>
        </div>
    </footer>
</div>

@stack('scripts')
</body>
</html>
