@extends('layouts.app')
@section('title', 'Tambah Warga · RT Management System')
@section('page-title', 'Tambah Warga')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data Warga
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Tambah Data Warga Baru</h2>

        <form method="POST" action="{{ route('warga.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- NIK -->
                <div>
                    <label class="form-label">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                        class="form-input @error('nik') border-red-300 focus:ring-red-500 @enderror"
                        placeholder="16 digit NIK">
                    @error('nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Nomor Rumah -->
                <div>
                    <label class="form-label">Nomor Rumah <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_rumah" value="{{ old('nomor_rumah') }}"
                        class="form-input @error('nomor_rumah') border-red-300 @enderror"
                        placeholder="Contoh: A-01">
                    @error('nomor_rumah')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Nama -->
            <div>
                <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="form-input @error('nama') border-red-300 @enderror"
                    placeholder="Nama lengkap sesuai KTP">
                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Jenis Kelamin -->
                <div>
                    <label class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="form-input @error('jenis_kelamin') border-red-300 @enderror">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="form-input @error('status') border-red-300 @enderror">
                        <option value="tetap" {{ old('status','tetap')=='tetap'?'selected':'' }}>Tetap</option>
                        <option value="kontrak" {{ old('status')=='kontrak'?'selected':'' }}>Kontrak</option>
                        <option value="pindah" {{ old('status')=='pindah'?'selected':'' }}>Pindah</option>
                    </select>
                    @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Tempat Lahir -->
                <div>
                    <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="form-input @error('tempat_lahir') border-red-300 @enderror"
                        placeholder="Kota kelahiran">
                    @error('tempat_lahir')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="form-input @error('tanggal_lahir') border-red-300 @enderror">
                    @error('tanggal_lahir')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- No HP -->
            <div>
                <label class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                    class="form-input" placeholder="08xx-xxxx-xxxx (opsional)">
            </div>

            <!-- Alamat -->
            <div>
                <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="3"
                    class="form-input @error('alamat') border-red-300 @enderror"
                    placeholder="Alamat lengkap termasuk RT/RW">{{ old('alamat') }}</textarea>
                @error('alamat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Data
                </button>
                <a href="{{ route('warga.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
