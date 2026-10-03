@extends('layouts.app')
@section('title', 'Data Warga · RT Management System')
@section('page-title', 'Data Warga')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Data Warga</h2>
            <p class="text-sm text-slate-500 mt-0.5">Kelola data kependudukan warga RT 05</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('warga.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Warga
        </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="card">
        <form method="GET" action="{{ route('warga.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, nomor rumah..."
                    class="form-input pl-10">
            </div>
            <select name="status" class="form-input sm:w-40">
                <option value="">Semua Status</option>
                <option value="tetap" {{ request('status')=='tetap'?'selected':'' }}>Tetap</option>
                <option value="kontrak" {{ request('status')=='kontrak'?'selected':'' }}>Kontrak</option>
                <option value="pindah" {{ request('status')=='pindah'?'selected':'' }}>Pindah</option>
            </select>
            <select name="jenis_kelamin" class="form-input sm:w-36">
                <option value="">Semua JK</option>
                <option value="L" {{ request('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
            </select>
            <button type="submit" class="btn-primary">Filter</button>
            @if(request()->hasAny(['search','status','jenis_kelamin']))
            <a href="{{ route('warga.index') }}" class="btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4">Warga</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">NIK</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">No. Rumah</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">No. HP</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-4">Status</th>
                        <th class="text-right text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($warga as $w)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ $w->jenis_kelamin == 'L' ? 'bg-blue-50' : 'bg-pink-50' }}">
                                    <span class="text-sm font-bold {{ $w->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">{{ strtoupper(substr($w->nama, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $w->nama }}</p>
                                    <p class="text-xs text-slate-400">{{ $w->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} · {{ $w->tanggal_lahir->age }} tahun</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4"><span class="text-sm font-mono text-slate-600">{{ $w->nik }}</span></td>
                        <td class="px-4 py-4"><span class="badge-blue">{{ $w->nomor_rumah }}</span></td>
                        <td class="px-4 py-4"><span class="text-sm text-slate-600">{{ $w->no_hp ?? '-' }}</span></td>
                        <td class="px-4 py-4">
                            @if($w->status == 'tetap') <span class="badge-green">Tetap</span>
                            @elseif($w->status == 'kontrak') <span class="badge-yellow">Kontrak</span>
                            @else <span class="badge-gray">Pindah</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('warga.show', $w) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('warga.edit', $w) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button onclick="confirmDelete('{{ route('warga.destroy', $w) }}', '{{ $w->nama }}')" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Tidak ada data warga</p>
                                <p class="text-xs text-slate-400 mt-1">Coba ubah filter atau tambah data baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($warga->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-500">Menampilkan {{ $warga->firstItem() }}-{{ $warga->lastItem() }} dari {{ $warga->total() }} data</p>
            {{ $warga->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" x-data="{ show: false, url: '', name: '' }" x-show="show" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl" @click.stop>
        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <h3 class="text-lg font-bold text-center text-slate-800 mb-2">Hapus Data Warga?</h3>
        <p class="text-sm text-slate-500 text-center mb-6">Data <strong x-text="name"></strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button @click="show = false" class="flex-1 btn-secondary justify-center">Batal</button>
            <form :action="url" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger w-full justify-center">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(url, name) {
    const modal = document.getElementById('deleteModal');
    const alpine = Alpine.$data(modal);
    alpine.url = url;
    alpine.name = name;
    alpine.show = true;
}
</script>
@endpush
