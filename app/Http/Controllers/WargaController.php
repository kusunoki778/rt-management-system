<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama', 'like', "%$q%")
                   ->orWhere('nik', 'like', "%$q%")
                   ->orWhere('nomor_rumah', 'like', "%$q%")
                   ->orWhere('no_hp', 'like', "%$q%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $warga = $query->latest()->paginate(15)->withQueryString();

        return view('warga.index', compact('warga'));
    }

    public function create()
    {
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:warga,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'nomor_rumah' => ['required', 'string', 'max:20'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:tetap,kontrak,pindah'],
        ]);

        $warga = Warga::create($validated);

        Aktivitas::log('Tambah Data Warga', "Warga baru ditambahkan: {$warga->nama} (NIK: {$warga->nik})");

        return redirect()->route('warga.index')->with('success', "Data warga {$warga->nama} berhasil ditambahkan.");
    }

    public function show(Warga $warga)
    {
        $warga->load(['pemasukan.kategori', 'pembayaranBulanan']);
        return view('warga.show', ['warga' => $warga]);
    }

    public function edit(Warga $warga)
    {
        return view('warga.edit', ['warga' => $warga]);
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:warga,nik,' . $warga->id],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'nomor_rumah' => ['required', 'string', 'max:20'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:tetap,kontrak,pindah'],
        ]);

        $warga->update($validated);

        Aktivitas::log('Edit Data Warga', "Data warga diperbarui: {$warga->nama}");

        return redirect()->route('warga.index')->with('success', "Data warga {$warga->nama} berhasil diperbarui.");
    }

    public function destroy(Warga $warga)
    {
        $nama = $warga->nama;
        $warga->delete();

        Aktivitas::log('Hapus Data Warga', "Data warga dihapus: {$nama}");

        return redirect()->route('warga.index')->with('success', "Data warga {$nama} berhasil dihapus.");
    }
}
