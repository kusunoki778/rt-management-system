@extends('layouts.app')
@section('title', 'Pelaporan Warga · RT Management System')
@section('page-title', 'Pelaporan Warga')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Lapor Masalah Fasilitas / Keamanan</h2>
        <p class="text-sm text-slate-500">Sampaikan laporan ke RT beserta foto bukti jika ada.</p>
    </div>

    <div class="card">
        <h3 class="text-base font-bold text-slate-800 mb-4">Form Laporan Baru</h3>
        <form method="POST" action="{{ route('pelaporan.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-slate-500">Kategori</label>
                    <select name="kategori" class="form-input mt-1" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="fasilitas">Fasilitas</option>
                        <option value="keamanan">Keamanan</option>
                        <option value="kebersihan">Kebersihan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Judul Laporan</label>
                    <input type="text" name="judul" class="form-input mt-1" placeholder="Contoh: Lampu jalan mati" required>
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="form-input mt-1" placeholder="Jelaskan detail masalahnya..." required></textarea>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Foto Bukti (opsional)</label>
                <input type="file" name="foto" accept="image/*" class="form-input mt-1">
            </div>
            <button type="submit" class="btn-primary">Kirim Laporan</button>
        </form>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Riwayat Laporan Saya</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Judul</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Kategori</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Foto</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($laporanList as $l)
                <tr>
                    <td class="px-6 py-3.5 text-slate-600">{{ $l->created_at->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $l->judul }}</td>
                    <td class="px-4 py-3.5"><span class="badge-blue">{{ ucfirst($l->kategori) }}</span></td>
                    <td class="px-4 py-3.5">
                        @if($l->status == 'menunggu')
                        <span class="badge-yellow">Menunggu</span>
                        @elseif($l->status == 'diproses')
                        <span class="badge-blue">Diproses</span>
                        @elseif($l->status == 'selesai')
                        <span class="badge-green">Selesai</span>
                        @else
                        <span class="badge-red">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-right">
                        @if($l->foto_path)
                        <a href="{{ asset('storage/' . $l->foto_path) }}" target="_blank" class="text-xs text-emerald-600 hover:underline">Lihat Foto</a>
                        @else
                        <span class="text-xs text-slate-400">-</span>
                        @endif
                    </td>
                </tr>
                @if($l->tanggapan_rt)
                <tr>
                    <td colspan="5" class="px-6 pb-3">
                        <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl">Tanggapan RT: {{ $l->tanggapan_rt }}</div>
                    </td>
                </tr>
                @endif
                @empty
                <tr><td colspan="5" class="text-center py-8 text-slate-400">Belum ada laporan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
