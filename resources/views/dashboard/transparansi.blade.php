@extends('layouts.app')
@section('title', 'Transparansi Kas · RT Management System')
@section('page-title', 'Transparansi Kas')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Transparansi Keuangan RT</h2>
        <p class="text-sm text-slate-500">Ringkasan kas dan riwayat pengeluaran RT yang terbuka untuk seluruh warga.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <p class="text-xs font-medium text-slate-500 uppercase">Total Kas RT</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($totalKas, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <p class="text-xs font-medium text-slate-500 uppercase">Pemasukan Bulan Ini</p>
            <p class="text-2xl font-bold text-emerald-700 mt-1">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <p class="text-xs font-medium text-slate-500 uppercase">Pengeluaran Bulan Ini</p>
            <p class="text-2xl font-bold text-rose-700 mt-1">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <p class="text-xs font-medium text-slate-500 uppercase">Total Iuran Lunas</p>
            <p class="text-2xl font-bold text-emerald-700 mt-1">Rp {{ number_format($totalIuranLunas, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Riwayat Pengeluaran RT</h3>
            <p class="text-xs text-slate-400 mt-1">50 pengeluaran terbaru ( tanpa data pribadi warga lain ).</p>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Kategori</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Keterangan</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($riwayatPengeluaran as $p)
                <tr>
                    <td class="px-6 py-3.5 text-slate-600">{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $p->keterangan ?? '-' }}</td>
                    <td class="px-6 py-3.5 text-right font-semibold text-rose-700">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-10 text-slate-400">Belum ada riwayat pengeluaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
