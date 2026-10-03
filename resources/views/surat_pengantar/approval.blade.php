@extends('layouts.app')
@section('title', 'Persetujuan Surat Pengantar · RT Management System')
@section('page-title', 'Persetujuan Surat Pengantar')

@section('content')
<div class="space-y-5">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Persetujuan Surat Pengantar</h2>
        <p class="text-sm text-slate-500">Setujui atau tolak pengajuan surat pengantar dari warga.</p>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Warga</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Jenis Surat</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Keterangan</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($suratList as $s)
                <tr>
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-slate-800">{{ $s->warga->nama }}</p>
                        <p class="text-xs text-slate-400">No. {{ $s->warga->nomor_rumah }}</p>
                    </td>
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $s->jenis_surat }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $s->keterangan ?? '-' }}</td>
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
                        @if($s->status == 'menunggu')
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('surat-pengantar.approve', $s) }}">
                                @csrf
                                <button type="submit" class="btn-primary !py-1.5 !px-3 !text-xs" onclick="return confirm('Setujui surat pengantar ini?')">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('surat-pengantar.reject', $s) }}">
                                @csrf
                                <button type="submit" class="btn-danger !py-1.5 !px-3 !text-xs" onclick="return confirm('Tolak surat pengantar ini?')">Tolak</button>
                            </form>
                        </div>
                        @else
                        <span class="text-xs text-slate-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-10 text-slate-400">Belum ada pengajuan surat pengantar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
