@extends('layouts.app')
@section('title', 'Tambah Pemasukan · RT Management System')
@section('page-title', 'Tambah Pemasukan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('pemasukan.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Tambah Pemasukan Kas RT</h2>

        <form method="POST" action="{{ route('pemasukan.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_pemasukan_id" class="form-input @error('kategori_pemasukan_id') border-red-300 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_pemasukan_id')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_pemasukan_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label">Nominal (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="nominal" value="{{ old('nominal') }}" step="1000" min="1000"
                        class="form-input @error('nominal') border-red-300 @enderror" placeholder="50000" required>
                    @error('nominal')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Warga Pembayar</label>
                    <select name="warga_id" class="form-input">
                        <option value="">-- Bukan dari Warga Spesifik --</option>
                        @foreach($wargas as $w)
                        <option value="{{ $w->id }}" {{ old('warga_id')==$w->id?'selected':'' }}>{{ $w->nama }} (No. {{ $w->nomor_rumah }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Metode Pembayaran <span class="text-red-500">*</span></label>
                    <select name="metode_pembayaran" class="form-input" required>
                        <option value="cash" {{ old('metode_pembayaran')=='cash'?'selected':'' }}>Cash / Tunai</option>
                        <option value="transfer" {{ old('metode_pembayaran')=='transfer'?'selected':'' }}>Transfer Bank</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Tanggal Transaksi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Keterangan / Catatan</label>
                <textarea name="keterangan" rows="3" class="form-input" placeholder="Catatan tambahan transaksi">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan Transaksi</button>
                <a href="{{ route('pemasukan.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
