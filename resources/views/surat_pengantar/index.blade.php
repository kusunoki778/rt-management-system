@extends('layouts.app')
@section('title', 'Surat Pengantar · RT Management System')
@section('page-title', 'Surat Pengantar Digital')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Pengajuan Surat Pengantar</h2>
        <p class="text-sm text-slate-500">Ajukan surat pengantar digital dan cetak langsung setelah disetujui Ketua RT.</p>
    </div>

    <div class="card">
        <h3 class="text-base font-bold text-slate-800 mb-4">Form Pengajuan</h3>
        <form method="POST" action="{{ route('surat-pengantar.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-medium text-slate-500">Jenis Surat</label>
                <select name="jenis_surat" class="form-input mt-1" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                    <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                    <option value="Surat Pengantar KTP">Surat Pengantar KTP</option>
                    <option value="Surat Pengantar KK">Surat Pengantar KK</option>
                    <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Keterangan / Keperluan</label>
                <textarea name="keterangan" rows="3" class="form-input mt-1" placeholder="Contoh: untuk pengurusan administrasi di kantor kelurahan"></textarea>
            </div>
            <button type="submit" class="btn-primary">Ajukan Surat</button>
        </form>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Riwayat Pengajuan Saya</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Jenis Surat</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($suratList as $s)
                <tr>
                    <td class="px-6 py-3.5 text-slate-600">{{ $s->created_at->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $s->jenis_surat }}</td>
                    <td class="px-4 py-3.5">
                        @if($s->status == 'menunggu')
                        <span class="badge-yellow">Menunggu</span>
                        @elseif($s->status == 'disetujui')
                        <span class="badge-green">Disetujui</span>
                        @else
                        <span class="badge-red">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-right">
                        @if($s->status == 'disetujui')
                        <a href="{{ route('surat-pengantar.cetak', $s) }}" target="_blank" class="btn-secondary !py-1.5 !px-3 !text-xs">Cetak</a>
                        @else
                        <span class="text-xs text-slate-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-8 text-slate-400">Belum ada pengajuan surat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
