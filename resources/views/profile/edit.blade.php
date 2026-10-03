@extends('layouts.app')
@section('title', 'Profil Saya · RT Management System')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Profil Info Card -->
    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Informasi Akun</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Peranan (Role)</label>
                <input type="text" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" class="form-input bg-slate-50 text-slate-500 cursor-not-allowed" disabled>
            </div>

            <button type="submit" class="btn-primary">Simpan Profil</button>
        </form>
    </div>

    <!-- Ubah Password Card -->
    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Ubah Password</h2>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-input" required>
                @error('current_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-input" required>
                @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn-primary">Ubah Password</button>
        </form>
    </div>
</div>
@endsection
