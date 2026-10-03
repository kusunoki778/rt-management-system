@extends('layouts.app')
@section('title', 'Dashboard Warga · RT Management System')
@section('page-title', 'Portal Warga')

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="relative">
            <p class="text-emerald-100 text-sm mb-1">Halo, Selamat Datang</p>
            <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
            <p class="text-emerald-100 mt-1 text-sm">Warga RT 05 / RW 02 · Rumah No. {{ $warga->nomor_rumah ?? '-' }}</p>
        </div>
    </div>

    <!-- Informasi Pembayaran -->
    <div class="card bg-slate-50 border-slate-100">
        <h3 class="text-base font-bold text-slate-800 mb-3">Informasi Pembayaran</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase">Transfer Bank</p>
                <p class="font-bold text-slate-800 mt-1">BCA 1234567890</p>
                <p class="text-slate-600">a.n. RT 05 / RW 02</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase">QRIS Statis</p>
                <div class="mt-1 w-24 h-24 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-[10px] text-slate-400 font-semibold text-center p-2">
                    QRIS<br>DUMMY
                </div>
            </div>
        </div>
    </div>

    <!-- Status Iuran Bulan Ini -->
    <div class="card">
        <h3 class="text-base font-bold text-slate-800 mb-4">Status Iuran Bulan Ini ({{ now()->translatedFormat('F Y') }})</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($statusBulanIni as $st)
            <div class="p-4 rounded-xl border {{ $st->status == 'lunas' ? 'bg-emerald-50 border-emerald-100' : ($st->status == 'menunggu_verifikasi' ? 'bg-amber-50 border-amber-100' : 'bg-red-50 border-red-100') }} flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase">{{ str_replace('_', ' ', $st->jenis_iuran) }}</p>
                    <p class="text-lg font-bold text-slate-800">Rp {{ number_format($st->nominal, 0, ',', '.') }}</p>
                </div>
                @if($st->status == 'lunas')
                <span class="badge-green">✓ Lunas</span>
                @elseif($st->status == 'menunggu_verifikasi')
                <span class="badge-yellow">Menunggu Verifikasi</span>
                @else
                <span class="badge-red">Belum Lunas</span>
                @endif
            </div>

            <div class="col-span-2 sm:col-span-2">
                @if($st->status == 'belum_bayar')
                <form method="POST" action="{{ route('pembayaran.upload-bukti', $st) }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 p-4 bg-white rounded-xl border border-slate-100">
                    @csrf
                    <div class="flex-1">
                        <label class="text-xs font-medium text-slate-500">Upload Bukti Transfer ({{ str_replace('_', ' ', $st->jenis_iuran) }})</label>
                        <input type="file" name="bukti_bayar" accept="image/*" required class="form-input mt-1">
                    </div>
                    <button type="submit" class="btn-primary self-end sm:self-center">Upload Bukti</button>
                </form>
                @elseif($st->status == 'menunggu_verifikasi')
                <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl flex items-center justify-between">
                    <p class="text-xs text-amber-700">Bukti pembayaran untuk {{ str_replace('_', ' ', $st->jenis_iuran) }} sudah diupload. Menunggu verifikasi bendahara.</p>
                    @if($st->bukti_bayar_path)
                    <a href="{{ asset('storage/' . $st->bukti_bayar_path) }}" target="_blank" class="text-xs font-semibold text-amber-700 hover:underline">Lihat Bukti</a>
                    @endif
                </div>
                @endif
            </div>
            @empty
            <p class="text-sm text-slate-400 col-span-2">Belum ada tagihan iuran bulan ini</p>
            @endforelse
        </div>
    </div>

    <!-- Pengumuman Terbaru -->
    <div class="card">
        <h3 class="text-base font-bold text-slate-800 mb-3">Pengumuman Terbaru</h3>
        <div class="space-y-3">
            @forelse($latestPengumuman as $p)
            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50">
                <p class="text-xs text-slate-400 mb-1">{{ $p->created_at->translatedFormat('d M Y') }}</p>
                <p class="font-semibold text-slate-800">{{ $p->judul }}</p>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($p->isi, 100) }}</p>
            </div>
            @empty
            <p class="text-sm text-slate-400">Belum ada pengumuman terbaru</p>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Pembayaran Pribadi -->
    <div class="card p-0 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Riwayat Pembayaran Iuran Saya</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Tanggal Bayar</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Jenis Iuran</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Nominal</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($riwayatPembayaran as $r)
                <tr>
                    <td class="px-6 py-3.5 text-slate-600">
                        {{ $r->tanggal_bayar ? $r->tanggal_bayar->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">
                        {{ str_replace('_', ' ', ucfirst($r->jenis_iuran)) }} ({{ \Carbon\Carbon::create($r->tahun, $r->bulan, 1)->translatedFormat('M Y') }})
                    </td>
                    <td class="px-4 py-3.5 font-semibold text-slate-800">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                    <td class="px-6 py-3.5 text-right">
                        @if($r->status == 'lunas') <span class="badge-green">Lunas</span>
                        @elseif($r->status == 'menunggu_verifikasi') <span class="badge-yellow">Menunggu Verifikasi</span>
                        @else <span class="badge-red">Belum Bayar</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-8 text-slate-400">Belum ada riwayat pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
