@extends('layouts.app')
@section('title', 'Verifikasi Pembayaran · RT Management System')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')
<div class="space-y-5">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Verifikasi Bukti Pembayaran</h2>
        <p class="text-sm text-slate-500">Daftar bukti pembayaran warga yang menunggu verifikasi bendahara.</p>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Warga</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Periode</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Jenis Iuran</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Nominal</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Bukti</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($buktiPembayaran as $p)
                <tr>
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-slate-800">{{ $p->warga->nama }}</p>
                        <p class="text-xs text-slate-400">No. {{ $p->warga->nomor_rumah }}</p>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ \Carbon\Carbon::create($p->tahun, $p->bulan, 1)->translatedFormat('F Y') }}</td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ str_replace('_', ' ', ucfirst($p->jenis_iuran)) }}</td>
                    <td class="px-4 py-3.5 font-semibold text-slate-800">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                    <td class="px-4 py-3.5">
                        @if($p->bukti_bayar_path)
                        <a href="{{ asset('storage/' . $p->bukti_bayar_path) }}" target="_blank" class="text-emerald-600 hover:underline text-xs font-medium">Lihat Bukti</a>
                        @else
                        <span class="text-slate-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('pembayaran.lunas', $p) }}">
                                @csrf
                                <button type="submit" class="btn-primary !py-1.5 !px-3 !text-xs" onclick="return confirm('Tandai pembayaran ini sebagai lunas?')">Lunas</button>
                            </form>
                            <form method="POST" action="{{ route('pembayaran.tolak', $p) }}">
                                @csrf
                                <button type="submit" class="btn-danger !py-1.5 !px-3 !text-xs" onclick="return confirm('Tolak bukti pembayaran ini?')">Tolak</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-10 text-slate-400">Belum ada bukti pembayaran yang menunggu verifikasi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
