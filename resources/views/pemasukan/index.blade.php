@extends('layouts.app')
@section('title', 'Pemasukan · RT Management System')
@section('page-title', 'Data Pemasukan')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Data Pemasukan</h2>
            <p class="text-sm text-slate-500 mt-0.5">Rekap seluruh pemasukan kas RT</p>
        </div>
        <a href="{{ route('pemasukan.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pemasukan
        </a>
    </div>

    <div class="card">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama warga..." class="form-input pl-10">
            </div>
            <select name="kategori" class="form-input w-44">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ request('kategori')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <select name="bulan" class="form-input w-36">
                <option value="">Semua Bulan</option>
                @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}" {{ request('bulan')==$i?'selected':'' }}>{{ \Carbon\Carbon::create(2026,$i,1)->translatedFormat('F') }}</option>
                @endfor
            </select>
            <select name="tahun" class="form-input w-28">
                @for($y=date('Y');$y>=date('Y')-3;$y--)
                <option value="{{ $y }}" {{ request('tahun')==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn-primary">Filter</button>
            @if(request()->hasAny(['search','kategori','bulan','tahun']))
            <a href="{{ route('pemasukan.index') }}" class="btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4">Tanggal</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">Warga</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">Kategori</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">Metode</th>
                        <th class="text-right text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">Nominal</th>
                        <th class="text-right text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pemasukan as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $p->tanggal->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ $p->warga->nama ?? 'Umum' }}</p>
                                @if($p->keterangan)<p class="text-xs text-slate-400 truncate max-w-48">{{ $p->keterangan }}</p>@endif
                            </div>
                        </td>
                        <td class="px-4 py-4"><span class="badge-blue">{{ $p->kategori->nama_kategori }}</span></td>
                        <td class="px-4 py-4">
                            @if($p->metode_pembayaran == 'cash') <span class="badge-green">Cash</span>
                            @else <span class="badge-yellow">Transfer</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="text-sm font-bold text-emerald-600">Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('pemasukan.edit', $p) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('pemasukan.destroy', $p) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-16 text-slate-400 text-sm">Tidak ada data pemasukan</td></tr>
                    @endforelse
                </tbody>
                @if($pemasukan->count() > 0)
                <tfoot>
                    <tr class="bg-emerald-50 border-t-2 border-emerald-200">
                        <td colspan="4" class="px-6 py-4 text-sm font-semibold text-emerald-700">Total Halaman Ini</td>
                        <td class="px-4 py-4 text-right text-base font-bold text-emerald-700">
                            Rp {{ number_format($pemasukan->sum('nominal'), 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        @if($pemasukan->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-500">Menampilkan {{ $pemasukan->firstItem() }}-{{ $pemasukan->lastItem() }} dari {{ $pemasukan->total() }} data</p>
            {{ $pemasukan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
