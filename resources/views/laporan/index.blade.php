@extends('layouts.app')
@section('title', 'Laporan Keuangan · RT Management System')
@section('page-title', 'Laporan Administrasi & Keuangan')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Laporan Administrasi RT</h2>
        <p class="text-sm text-slate-500 mt-0.5">Pilih jenis laporan yang ingin Anda lihat atau ekspor</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Laporan Pemasukan -->
        <a href="{{ route('laporan.pemasukan') }}" class="card hover:shadow-md hover:border-emerald-200 transition-all group">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Laporan Pemasukan</h3>
            <p class="text-xs text-slate-500 mb-4">Rekapitulasi seluruh dana masuk per bulan atau tahun per kategori.</p>
            <span class="text-xs font-semibold text-emerald-600 group-hover:translate-x-1 inline-block transition-transform">Buka Laporan →</span>
        </a>

        <!-- Laporan Pengeluaran -->
        <a href="{{ route('laporan.pengeluaran') }}" class="card hover:shadow-md hover:border-red-200 transition-all group">
            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Laporan Pengeluaran</h3>
            <p class="text-xs text-slate-500 mb-4">Rekapitulasi alokasi pengeluaran kas RT secara berkala.</p>
            <span class="text-xs font-semibold text-red-500 group-hover:translate-x-1 inline-block transition-transform">Buka Laporan →</span>
        </a>

        <!-- Laporan Pembayaran Warga -->
        <a href="{{ route('laporan.pembayaran') }}" class="card hover:shadow-md hover:border-blue-200 transition-all group">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Laporan Pembayaran Warga</h3>
            <p class="text-xs text-slate-500 mb-4">Matriks status kelunasan iuran kas & sampah seluruh warga.</p>
            <span class="text-xs font-semibold text-blue-600 group-hover:translate-x-1 inline-block transition-transform">Buka Laporan →</span>
        </a>
    </div>
</div>
@endsection
