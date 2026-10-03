<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk · RT Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="h-full antialiased flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-md">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-emerald-600/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V12a1 1 0 011-1h2a1 1 0 011 1v9"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white tracking-tight">RT Management System</h1>
            <p class="text-xs text-slate-400 mt-1">Sistem Informasi & Administrasi RT Digital</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl p-8 shadow-2xl shadow-slate-950/50 border border-slate-200/80">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
                <p class="text-xs text-slate-500 mt-1">Masukkan kredensial akun Anda untuk masuk ke sistem</p>
            </div>

            <!-- Demo Accounts Box -->
            <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                    <span class="text-xs font-bold text-slate-700">Akun Pengujian Demo</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600">
                    <div class="bg-white p-2 rounded-xl border border-slate-200/60">
                        <span class="font-bold text-slate-900 block">Admin</span>
                        <span class="text-slate-500">admin@rt05.id</span>
                    </div>
                    <div class="bg-white p-2 rounded-xl border border-slate-200/60">
                        <span class="font-bold text-slate-900 block">Bendahara</span>
                        <span class="text-slate-500">bendahara@rt05.id</span>
                    </div>
                    <div class="bg-white p-2 rounded-xl border border-slate-200/60">
                        <span class="font-bold text-slate-900 block">Ketua RT</span>
                        <span class="text-slate-500">ketuart@rt05.id</span>
                    </div>
                    <div class="bg-white p-2 rounded-xl border border-slate-200/60">
                        <span class="font-bold text-slate-900 block">Warga</span>
                        <span class="text-slate-500">warga@rt05.id</span>
                    </div>
                </div>
                <p class="text-[11px] text-slate-500 mt-2.5 pt-2 border-t border-slate-200/50 flex items-center justify-between">
                    <span>Password semua akun:</span>
                    <code class="bg-slate-200/60 text-slate-800 font-mono px-1.5 py-0.5 rounded font-semibold">password</code>
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all @error('email') border-rose-300 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="contoh: admin@rt05.id">
                    @error('email')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative" x-data="{ showPass: false }">
                        <input id="password" :type="showPass ? 'text' : 'password'" name="password" required
                            class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 pr-10 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                            placeholder="••••••••">
                        <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs text-slate-600 font-medium">Ingat Sesi Saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 text-white font-semibold py-2.5 rounded-xl hover:bg-emerald-700 active:bg-emerald-800 transition-all duration-150 text-sm shadow-sm shadow-emerald-600/30 mt-2">
                    Masuk ke Sistem
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            © {{ date('Y') }} RT Management System · Seluruh Hak Cipta Dilindungi
        </p>
    </div>

</body>
</html>
