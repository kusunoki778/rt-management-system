<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\KategoriPemasukan;
use App\Models\PembayaranBulanan;
use App\Models\Warga;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasukan::with(['warga', 'kategori', 'creator']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->whereHas('warga', fn($w) => $w->where('nama', 'like', "%$q%"))
                   ->orWhere('keterangan', 'like', "%$q%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_pemasukan_id', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $totalFilter = (clone $query)->sum('nominal');
        $pemasukan = $query->latest('tanggal')->paginate(15)->withQueryString();
        $kategoris = KategoriPemasukan::all();

        return view('pemasukan.index', compact('pemasukan', 'kategoris', 'totalFilter'));
    }

    public function create()
    {
        $kategoris = KategoriPemasukan::all();
        $wargas = Warga::where('status', '!=', 'pindah')->orderBy('nama')->get();
        return view('pemasukan.create', compact('kategoris', 'wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => ['nullable', 'exists:warga,id'],
            'kategori_pemasukan_id' => ['required', 'exists:kategori_pemasukan,id'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'metode_pembayaran' => ['required', 'in:cash,transfer'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $validated['created_by'] = auth()->id();
        $pemasukan = Pemasukan::create($validated);
        $pemasukan->load('kategori');

        // Sinkronisasi otomatis ke PembayaranBulanan jika kategori Kas Bulanan atau Iuran Sampah
        if ($pemasukan->warga_id && $pemasukan->kategori && in_array($pemasukan->kategori->nama_kategori, ['Kas Bulanan', 'Iuran Sampah'])) {
            $jenisIuran = $pemasukan->kategori->nama_kategori === 'Kas Bulanan' ? 'kas_bulanan' : 'iuran_sampah';
            $tgl = Carbon::parse($pemasukan->tanggal);

            PembayaranBulanan::updateOrCreate(
                [
                    'warga_id' => $pemasukan->warga_id,
                    'bulan' => $tgl->month,
                    'tahun' => $tgl->year,
                    'jenis_iuran' => $jenisIuran,
                ],
                [
                    'nominal' => $pemasukan->nominal,
                    'status' => 'lunas',
                    'tanggal_bayar' => $tgl,
                    'pemasukan_id' => $pemasukan->id,
                ]
            );
        }

        Aktivitas::log('Tambah Pemasukan', "Pemasukan Rp " . number_format($pemasukan->nominal, 0, ',', '.') . " - " . ($pemasukan->kategori?->nama_kategori ?? 'Umum'));

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil ditambahkan.');
    }

    public function edit(Pemasukan $pemasukan)
    {
        $kategoris = KategoriPemasukan::all();
        $wargas = Warga::where('status', '!=', 'pindah')->orderBy('nama')->get();
        return view('pemasukan.edit', compact('pemasukan', 'kategoris', 'wargas'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $validated = $request->validate([
            'warga_id' => ['nullable', 'exists:warga,id'],
            'kategori_pemasukan_id' => ['required', 'exists:kategori_pemasukan,id'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'metode_pembayaran' => ['required', 'in:cash,transfer'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $pemasukan->update($validated);
        $pemasukan->load('kategori');

        // Perbarui relasi pembayaran bulanan jika ada
        if ($pemasukan->warga_id && $pemasukan->kategori && in_array($pemasukan->kategori->nama_kategori, ['Kas Bulanan', 'Iuran Sampah'])) {
            $jenisIuran = $pemasukan->kategori->nama_kategori === 'Kas Bulanan' ? 'kas_bulanan' : 'iuran_sampah';
            $tgl = Carbon::parse($pemasukan->tanggal);

            PembayaranBulanan::updateOrCreate(
                [
                    'warga_id' => $pemasukan->warga_id,
                    'bulan' => $tgl->month,
                    'tahun' => $tgl->year,
                    'jenis_iuran' => $jenisIuran,
                ],
                [
                    'nominal' => $pemasukan->nominal,
                    'status' => 'lunas',
                    'tanggal_bayar' => $tgl,
                    'pemasukan_id' => $pemasukan->id,
                ]
            );
        }

        Aktivitas::log('Edit Pemasukan', "Data pemasukan ID #{$pemasukan->id} diperbarui.");

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diperbarui.');
    }

    public function destroy(Pemasukan $pemasukan)
    {
        // Kembalikan status pembayaran bulanan ke belum bayar jika ada relasi
        PembayaranBulanan::where('pemasukan_id', $pemasukan->id)->update([
            'status' => 'belum_bayar',
            'tanggal_bayar' => null,
            'pemasukan_id' => null,
        ]);

        $pemasukan->delete();
        Aktivitas::log('Hapus Pemasukan', "Data pemasukan ID #{$pemasukan->id} dihapus.");

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil dihapus.');
    }
}
