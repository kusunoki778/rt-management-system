@extends('layouts.app')
@section('title', 'Pengumuman · RT Management System')
@section('page-title', 'Pengumuman RT')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pengumuman RT</h2>
            <p class="text-sm text-slate-500 mt-0.5">Informasi dan pengumuman untuk seluruh warga</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('pengumuman.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman
        </a>
        @endif
    </div>

    <!-- Announcement Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($pengumuman as $p)
        <div class="card flex flex-col justify-between relative group hover:border-emerald-200 transition-all">
            @if($p->is_pinned)
            <div class="absolute top-4 right-4 flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                Disematkan
            </div>
            @endif

            <div>
                <div class="flex items-center gap-2 mb-3">
                    @if($p->status == 'published') <span class="badge-green">Published</span>
                    @else <span class="badge-yellow">Draft</span>
                    @endif
                    <span class="text-xs text-slate-400">
                        {{ $p->tanggal_publish ? $p->tanggal_publish->translatedFormat('d M Y, H:i') : 'Draft' }}
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-1">
                    <a href="{{ route('pengumuman.show', $p) }}" class="hover:text-emerald-600 transition-colors">{{ $p->judul }}</a>
                </h3>

                <p class="text-sm text-slate-600 line-clamp-3 mb-4 leading-relaxed">{{ $p->isi }}</p>
            </div>

            <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                <span class="text-xs text-slate-400">Oleh: {{ $p->creator->name ?? 'Admin RT' }}</span>

                <div class="flex items-center gap-2">
                    <a href="{{ route('pengumuman.show', $p) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Baca Selengkapnya →</a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('pengumuman.edit', $p) }}" class="p-1 rounded text-slate-400 hover:text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 card text-center py-16">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            <p class="text-sm text-slate-500 font-medium">Belum ada pengumuman</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
