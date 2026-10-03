<?php

namespace App\Http\Controllers;

use App\Models\LaporanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanWargaController extends Controller
{
    public function wargaIndex()
    {
        $warga = auth()->user()->warga;
        $laporanList = LaporanWarga::where('warga_id', $warga?->id)
            ->latest()
            ->get();

        return view('pelaporan.warga', compact('laporanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => ['required', 'string', 'max:50'],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $warga = auth()->user()->warga;

        if (! $warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        $data = $request->only(['kategori', 'judul', 'deskripsi']);
        $data['warga_id'] = $warga->id;
        $data['status'] = 'menunggu';

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('laporan', 'public');
        }

        LaporanWarga::create($data);

        return back()->with('success', 'Laporan berhasil dibuat. Menunggu tindak lanjut RT.');
    }

    public function adminIndex(Request $request)
    {
        $query = LaporanWarga::with('warga')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul', 'like', "%$q%")
                    ->orWhere('deskripsi', 'like', "%$q%")
                    ->orWhereHas('warga', function ($w) use ($q) {
                        $w->where('nama', 'like', "%$q%");
                    });
            });
        }

        $laporanList = $query->paginate(10)->withQueryString();

        return view('pelaporan.admin', compact('laporanList'));
    }

    public function updateStatus(Request $request, LaporanWarga $laporan)
    {
        $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai,ditolak'],
            'tanggapan_rt' => ['nullable', 'string', 'max:1000'],
        ]);

        $laporan->update([
            'status' => $request->status,
            'tanggapan_rt' => $request->tanggapan_rt,
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
