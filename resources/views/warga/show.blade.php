@extends('layouts.app')
@section('title', 'Detail Warga · RT Management System')
@section('page-title', 'Detail Warga')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('warga.edit', $warga) }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Data
        </a>
        @endif
    </div>

    <!-- Profile Card -->
    <div class="card">
        <div class="flex items-center gap-5 mb-6">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $warga->jenis_kelamin == 'L' ? 'bg-blue-100' : 'bg-pink-100' }}">
                <span class="text-2xl font-bold {{ $warga->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">{{ strtoupper(substr($warga->nama, 0, 1)) }}</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $warga->nama }}</h2>
                <p class="text-sm text-slate-500">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} · {{ $warga->tanggal_lahir->age }} tahun</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="badge-blue">No. {{ $warga->nomor_rumah }}</span>
                    @if($warga->status == 'tetap') <span class="badge-green">Tetap</span>
                    @elseif($warga->status == 'kontrak') <span class="badge-yellow">Kontrak</span>
                    @else <span class="badge-gray">Pindah</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @php $fields = [
                ['label' => 'NIK', 'value' => $warga->nik, 'mono' => true],
                ['label' => 'Tempat, Tgl Lahir', 'value' => $warga->tempat_lahir . ', ' . $warga->tanggal_lahir->translatedFormat('d F Y')],
                ['label' => 'Nomor HP', 'value' => $warga->no_hp ?? '-'],
                ['label' => 'Alamat', 'value' => $warga->alamat],
            ]; @endphp

            @foreach($fields as $f)
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs font-medium text-slate-400 mb-1">{{ $f['label'] }}</p>
                <p class="text-sm font-semibold text-slate-800 {{ $f['mono'] ?? false ? 'font-mono' : '' }}">{{ $f['value'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="card">
        <h3 class="text-base font-semibold text-slate-800 mb-4">Riwayat Pembayaran Terakhir</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="text-left text-xs font-semibold text-slate-500 px-4 py-3 rounded-l-xl">Periode</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-4 py-3">Jenis</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-4 py-3">Nominal</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-4 py-3 rounded-r-xl">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($warga->pembayaranBulanan->take(12) as $pb)
                    <tr>
                        <td class="px-4 py-3 font-medium">
                            {{ \Carbon\Carbon::create($pb->tahun, $pb->bulan)->translatedFormat('F Y') }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ str_replace('_', ' ', ucfirst($pb->jenis_iuran)) }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($pb->nominal, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @if($pb->status == 'lunas') <span class="badge-green">Lunas</span>
                            @else <span class="badge-red">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-8 text-slate-400 text-sm">Belum ada riwayat pembayaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
