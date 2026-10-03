<?php

namespace App\Http\Controllers;

use App\Models\SuratPengantar;
use Illuminate\Http\Request;

class SuratPengantarController extends Controller
{
    public function index()
    {
        $warga = auth()->user()->warga;
        $suratList = SuratPengantar::where('warga_id', $warga?->id)
            ->latest()
            ->get();

        return view('surat_pengantar.index', compact('suratList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ]);

        $warga = auth()->user()->warga;

        if (! $warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        SuratPengantar::create([
            'warga_id' => $warga->id,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan surat pengantar berhasil dibuat. Menunggu persetujuan Ketua RT.');
    }

    public function approvalIndex()
    {
        $suratList = SuratPengantar::with('warga')
            ->latest()
            ->get();

        return view('surat_pengantar.approval', compact('suratList'));
    }

    public function approve(SuratPengantar $suratPengantar)
    {
        $suratPengantar->update(['status' => 'disetujui']);

        return back()->with('success', 'Surat pengantar berhasil disetujui.');
    }

    public function reject(SuratPengantar $suratPengantar)
    {
        $suratPengantar->update(['status' => 'ditolak']);

        return back()->with('error', 'Surat pengantar ditolak.');
    }

    public function cetak(SuratPengantar $suratPengantar)
    {
        $user = auth()->user();

        if ($user->isWarga() && $suratPengantar->warga_id !== $user->warga?->id) {
            abort(403);
        }

        if ($suratPengantar->status !== 'disetujui') {
            abort(403, 'Surat belum disetujui.');
        }

        return view('surat_pengantar.cetak', [
            'surat' => $suratPengantar->load('warga'),
        ]);
    }
}
