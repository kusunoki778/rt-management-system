@extends('layouts.app')
@section('title', 'Kelola Pelaporan · RT Management System')
@section('page-title', 'Kelola Pelaporan Warga')

@section('content')
<div class="space-y-5">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Pelaporan Warga</h2>
        <p class="text-sm text-slate-500">Tindak lanjuti laporan fasilitas, keamanan, dan kebersihan dari warga.</p>
    </div>

    <div class="card">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, deskripsi, atau nama warga..." class="form-input flex-1">
            <select name="status" class="form-input w-full sm:w-48">
                <option value="">Semua Status</option>
                @foreach(['menunggu','diproses','selesai','ditolak'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-left">
                    <th class="px-6 py-3 font-semibold text-slate-500">Warga</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Laporan</th>
                    <th class="px-4 py-3 font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-3 font-semibold text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($laporanList as $l)
                <tr>
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-slate-800">{{ $l->warga->nama }}</p>
                        <p class="text-xs text-slate-400">No. {{ $l->warga->nomor_rumah }}</p>
                    </td>
                    <td class="px-4 py-3.5">
                        <p class="font-medium text-slate-800">{{ $l->judul }}</p>
                        <p class="text-xs text-slate-400">{{ ucfirst($l->kategori) }} · {{ $l->created_at->translatedFormat('d M Y') }}</p>
                        @if($l->foto_path)
                        <a href="{{ asset('storage/' . $l->foto_path) }}" target="_blank" class="text-xs text-emerald-600 hover:underline">Lihat Foto</a>
                        @endif
                    </td>
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
                        <form method="POST" action="{{ route('pelaporan.status', $l) }}" class="space-y-2">
                            @csrf
                            <select name="status" class="form-input">
                                @foreach(['menunggu','diproses','selesai','ditolak'] as $s)
                                <option value="{{ $s }}" {{ $l->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                            <textarea name="tanggapan_rt" rows="2" class="form-input" placeholder="Tanggapan RT">{{ $l->tanggapan_rt }}</textarea>
                            <button type="submit" class="btn-primary !py-1.5 !text-xs w-full">Update</button>
                        </form>
                    </td>
                </tr>
                @if($l->tanggapan_rt)
                <tr>
                    <td colspan="4" class="px-6 pb-3">
                        <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl">Tanggapan RT: {{ $l->tanggapan_rt }}</div>
                    </td>
                </tr>
                @endif
                @empty
                <tr><td colspan="4" class="text-center py-10 text-slate-400">Belum ada laporan warga</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-center">{{ $laporanList->links() }}</div>
</div>
@endsection
