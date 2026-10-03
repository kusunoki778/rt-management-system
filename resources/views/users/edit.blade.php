@extends('layouts.app')
@section('title', 'Edit Pengguna · RT Management System')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Edit Profil Pengguna</h2>

        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="form-label">Nama Pengguna <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="form-input" required>
                        <option value="warga" {{ old('role', $user->role)=='warga'?'selected':'' }}>Warga</option>
                        <option value="bendahara" {{ old('role', $user->role)=='bendahara'?'selected':'' }}>Bendahara</option>
                        <option value="ketua_rt" {{ old('role', $user->role)=='ketua_rt'?'selected':'' }}>Ketua RT</option>
                        <option value="admin" {{ old('role', $user->role)=='admin'?'selected':'' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Tautkan ke Data Warga</label>
                    <select name="warga_id" class="form-input">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($wargas as $w)
                        <option value="{{ $w->id }}" {{ old('warga_id', $user->warga_id)==$w->id?'selected':'' }}>{{ $w->nama }} (No. {{ $w->nomor_rumah }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <!-- Reset Password Card -->
    <div class="card">
        <h3 class="text-base font-bold text-slate-800 mb-4">Reset Password User</h3>
        <form method="POST" action="{{ route('users.reset-password', $user) }}" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>

            <button type="submit" class="btn-secondary">Reset Password</button>
        </form>
    </div>
</div>
@endsection
