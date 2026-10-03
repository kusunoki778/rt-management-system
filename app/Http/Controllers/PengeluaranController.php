<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\KategoriPengeluaran;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with(['kategori', 'creator']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('keterangan', 'like', "%$q%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_pengeluaran_id', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pengeluaran = $query->latest('tanggal')->paginate(15)->withQueryString();
        $kategoris = KategoriPengeluaran::all();

        return view('pengeluaran.index', compact('pengeluaran', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriPengeluaran::all();
        return view('pengeluaran.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_pengeluaran_id' => ['required', 'exists:kategori_pengeluaran,id'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
        ]);

        $validated['created_by'] = auth()->id();
        $pengeluaran = Pengeluaran::create($validated);

        Aktivitas::log('Tambah Pengeluaran', "Pengeluaran Rp " . number_format($pengeluaran->nominal, 0, ',', '.') . " - " . $pengeluaran->kategori->nama_kategori);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $kategoris = KategoriPengeluaran::all();
        return view('pengeluaran.edit', compact('pengeluaran', 'kategoris'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validated = $request->validate([
            'kategori_pengeluaran_id' => ['required', 'exists:kategori_pengeluaran,id'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
        ]);

        $pengeluaran->update($validated);
        Aktivitas::log('Edit Pengeluaran', "Data pengeluaran ID #{$pengeluaran->id} diperbarui.");

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        Aktivitas::log('Hapus Pengeluaran', "Data pengeluaran ID #{$pengeluaran->id} dihapus.");

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
