@extends('layouts.app')
@section('title', 'Buat Pengumuman · RT Management System')
@section('page-title', 'Buat Pengumuman')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Buat Pengumuman Baru</h2>

        <form method="POST" action="{{ route('pengumuman.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-input" placeholder="Contoh: Kerja Bakti Bersih Lingkungan RT 05" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Status Publikasi <span class="text-red-500">*</span></label>
                    <select name="status" class="form-input" required>
                        <option value="published" {{ old('status')=='published'?'selected':'' }}>Published (Langsung Tampil)</option>
                        <option value="draft" {{ old('status')=='draft'?'selected':'' }}>Draft (Simpan Sementara)</option>
                    </select>
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned')?'checked':'' }} class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm font-medium text-slate-700">Sematkan di Atas (Pinned)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="form-label">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="isi" rows="8" class="form-input" placeholder="Tuliskan detail pengumuman..." required>{{ old('isi') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Publikasikan Pengumuman</button>
                <a href="{{ route('pengumuman.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
