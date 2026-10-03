@extends('layouts.app')
@section('title', $pengumuman->judul . ' · RT Management System')
@section('page-title', 'Detail Pengumuman')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Pengumuman
        </a>
        @if(auth()->user()->isAdmin())
        <div class="flex items-center gap-2">
            <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="btn-secondary">Edit</a>
            <form method="POST" action="{{ route('pengumuman.destroy', $pengumuman) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">Hapus</button>
            </form>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="flex items-center gap-2 mb-4">
            @if($pengumuman->is_pinned)
            <span class="badge-green">📌 Pinned</span>
            @endif
            <span class="text-xs text-slate-400">
                Dipublikasikan: {{ $pengumuman->tanggal_publish ? $pengumuman->tanggal_publish->translatedFormat('l, d F Y - H:i') : 'Draft' }}
            </span>
        </div>

        <h1 class="text-2xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">{{ $pengumuman->judul }}</h1>

        <div class="prose max-w-none text-slate-700 leading-relaxed whitespace-pre-line text-base">
            {{ $pengumuman->isi }}
        </div>

        <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
            <span>Penulis: {{ $pengumuman->creator->name ?? 'Pengurus RT' }}</span>
            <span>RT 05 / RW 02</span>
        </div>
    </div>
</div>
@endsection
