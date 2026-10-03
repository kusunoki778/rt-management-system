@extends('layouts.app')
@section('title', 'Laporan Pengeluaran · RT Management System')
@section('page-title', 'Laporan Pengeluaran')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('laporan.index') }}" class="text-xs text-slate-400 hover:text-slate-600 mb-1 inline-block">← Laporan</a>
            <h2 class="text-xl font-bold text-slate-800">Laporan Pengeluaran Kas</h2>
            <p class="text-sm text-slate-500">Periode {{ \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</p>
        </div>

        <button onclick="window.print()" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Export PDF
        </button>
    </div>

    <div class="card">
        <form method="GET" class="flex gap-3">
            <select name="bulan" class="form-input w-40">
                @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>{{ \Carbon\Carbon::create(2026,$i,1)->translatedFormat('F') }}</option>
                @endfor
            </select>
            <select name="tahun" class="form-input w-32">
                @for($y=date('Y');$y>=date('Y')-3;$y--)
                <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn-primary">Tampilkan</button>
        </form>
    </div>

    <!-- Summary Box -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card bg-red-50 border-red-100">
            <p class="text-xs text-red-600 font-medium">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-800">Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
        @foreach($perKategori as $katName => $katTotal)
        <div class="card">
            <p class="text-xs text-slate-400">{{ $katName }}</p>
            <p class="text-lg font-bold text-slate-800">Rp {{ number_format($katTotal, 0, ',', '.') }}</p>
        </div>
        @endforeach
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Keterangan</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Kategori</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($data as $d)
                <tr>
                    <td class="px-6 py-3.5 text-slate-600">{{ $d->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $d->keterangan }}</td>
                    <td class="px-4 py-3.5"><span class="badge-red">{{ $d->kategori->nama_kategori }}</span></td>
                    <td class="px-6 py-3.5 text-right font-bold text-red-600">-Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-12 text-slate-400">Tidak ada pengeluaran pada periode ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
