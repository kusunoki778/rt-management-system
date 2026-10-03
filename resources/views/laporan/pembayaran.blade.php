@extends('layouts.app')
@section('title', 'Laporan Pembayaran Warga · RT Management System')
@section('page-title', 'Laporan Pembayaran Warga')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('laporan.index') }}" class="text-xs text-slate-400 hover:text-slate-600 mb-1 inline-block">← Laporan</a>
            <h2 class="text-xl font-bold text-slate-800">Laporan Status Iuran Warga</h2>
            <p class="text-sm text-slate-500">Periode {{ \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</p>
        </div>

        <div class="flex items-center gap-2">
            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
            <form method="POST" action="{{ route('laporan.generate-tagihan') }}" onsubmit="return confirm('Generate tagihan iuran untuk seluruh warga aktif pada periode ini?')">
                @csrf
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Generate Tagihan Periode Ini
                </button>
            </form>
            @endif

            <button onclick="window.print()" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Rekap
            </button>
        </div>
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

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="card bg-emerald-50 border-emerald-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700 font-bold text-lg">✓</div>
            <div>
                <p class="text-xs text-emerald-600 font-medium">Sudah Lunas Kas</p>
                <p class="text-2xl font-bold text-emerald-800">{{ $totalLunas }} Warga</p>
            </div>
        </div>
        <div class="card bg-red-50 border-red-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-700 font-bold text-lg">!</div>
            <div>
                <p class="text-xs text-red-600 font-medium">Belum Bayar Kas</p>
                <p class="text-2xl font-bold text-red-800">{{ $totalBelumBayar }} Warga</p>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Nama Warga</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">No. Rumah</th>
                    <th class="px-4 py-3 font-semibold text-slate-500 text-center">Kas Bulanan (50K)</th>
                    <th class="px-4 py-3 font-semibold text-slate-500 text-center">Iuran Sampah (30K)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pembayaranData as $item)
                <tr>
                    <td class="px-6 py-3.5 font-medium text-slate-800">{{ $item['warga']->nama }}</td>
                    <td class="px-4 py-3.5"><span class="badge-blue">No. {{ $item['warga']->nomor_rumah }}</span></td>
                    <td class="px-4 py-3.5 text-center">
                        @if($item['kas_bulanan'] && $item['kas_bulanan']->status == 'lunas')
                        <span class="badge-green">✓ Lunas</span>
                        @elseif($item['kas_bulanan'] && $item['kas_bulanan']->status == 'menunggu_verifikasi')
                        <span class="badge-yellow">Menunggu</span>
                        @else
                        <span class="badge-red">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-center">
                        @if($item['iuran_sampah'] && $item['iuran_sampah']->status == 'lunas')
                        <span class="badge-green">✓ Lunas</span>
                        @elseif($item['iuran_sampah'] && $item['iuran_sampah']->status == 'menunggu_verifikasi')
                        <span class="badge-yellow">Menunggu</span>
                        @else
                        <span class="badge-red">Belum Bayar</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
