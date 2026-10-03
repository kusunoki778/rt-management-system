@extends('layouts.app')
@section('title', 'Tambah Pengguna · RT Management System')
@section('page-title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Tambah Pengguna Sistem</h2>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">Nama Pengguna <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Role / Hak Akses <span class="text-red-500">*</span></label>
                    <select name="role" class="form-input" required>
                        <option value="warga" {{ old('role')=='warga'?'selected':'' }}>Warga</option>
                        <option value="bendahara" {{ old('role')=='bendahara'?'selected':'' }}>Bendahara</option>
                        <option value="ketua_rt" {{ old('role')=='ketua_rt'?'selected':'' }}>Ketua RT</option>
                        <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Tautkan ke Data Warga</label>
                    <select name="warga_id" class="form-input">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($wargas as $w)
                        <option value="{{ $w->id }}" {{ old('warga_id')==$w->id?'selected':'' }}>{{ $w->nama }} (No. {{ $w->nomor_rumah }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Buat Akun</button>
                <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
