@extends('layouts.app')
@section('title', 'Edit Warga · RT Management System')
@section('page-title', 'Edit Warga')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Edit Data Warga</h2>

        <form method="POST" action="{{ route('warga.update', $warga) }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $warga->nik) }}" maxlength="16"
                        class="form-input @error('nik') border-red-300 @enderror">
                    @error('nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Nomor Rumah <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_rumah" value="{{ old('nomor_rumah', $warga->nomor_rumah) }}"
                        class="form-input @error('nomor_rumah') border-red-300 @enderror">
                    @error('nomor_rumah')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $warga->nama) }}"
                    class="form-input @error('nama') border-red-300 @enderror">
                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="form-input">
                        <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin)=='L'?'selected':'' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin)=='P'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="form-input">
                        <option value="tetap" {{ old('status', $warga->status)=='tetap'?'selected':'' }}>Tetap</option>
                        <option value="kontrak" {{ old('status', $warga->status)=='kontrak'?'selected':'' }}>Kontrak</option>
                        <option value="pindah" {{ old('status', $warga->status)=='pindah'?'selected':'' }}>Pindah</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir->format('Y-m-d')) }}" class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $warga->no_hp) }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="3" class="form-input">{{ old('alamat', $warga->alamat) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('warga.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
