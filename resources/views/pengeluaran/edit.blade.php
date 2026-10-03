@extends('layouts.app')
@section('title', 'Edit Pengeluaran · RT Management System')
@section('page-title', 'Edit Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('pengeluaran.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Edit Pengeluaran Kas RT</h2>

        <form method="POST" action="{{ route('pengeluaran.update', $pengeluaran) }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_pengeluaran_id" class="form-input" required>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_pengeluaran_id', $pengeluaran->kategori_pengeluaran_id)==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Nominal (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="nominal" value="{{ old('nominal', $pengeluaran->nominal) }}" step="1000" min="1000" class="form-input" required>
                </div>
            </div>

            <div>
                <label class="form-label">Tanggal Transaksi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $pengeluaran->tanggal->format('Y-m-d')) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Keterangan / Keperluan <span class="text-red-500">*</span></label>
                <textarea name="keterangan" rows="3" class="form-input" required>{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('pengeluaran.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
