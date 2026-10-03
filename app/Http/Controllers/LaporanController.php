<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\PembayaranBulanan;
use App\Models\Warga;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function pemasukan(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $data = Pemasukan::with(['warga', 'kategori', 'creator'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->latest('tanggal')
            ->get();

        $total = $data->sum('nominal');
        $perKategori = $data->groupBy('kategori.nama_kategori')->map(fn($g) => $g->sum('nominal'));

        return view('laporan.pemasukan', compact('data', 'total', 'perKategori', 'bulan', 'tahun'));
    }

    public function pengeluaran(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $data = Pengeluaran::with(['kategori', 'creator'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->latest('tanggal')
            ->get();

        $total = $data->sum('nominal');
        $perKategori = $data->groupBy('kategori.nama_kategori')->map(fn($g) => $g->sum('nominal'));

        return view('laporan.pengeluaran', compact('data', 'total', 'perKategori', 'bulan', 'tahun'));
    }

    public function pembayaran(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $wargas = Warga::where('status', '!=', 'pindah')->orderBy('nama')->get();
        $wargaIds = $wargas->pluck('id');

        // Optimasi N+1: Ambil semua data iuran periode ini dalam 1 query
        $semuaIuran = PembayaranBulanan::whereIn('warga_id', $wargaIds)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->groupBy('warga_id');

        $pembayaranData = [];
        foreach ($wargas as $w) {
            $iuranWarga = $semuaIuran->get($w->id, collect());
            $kas = $iuranWarga->firstWhere('jenis_iuran', 'kas_bulanan');
            $sampah = $iuranWarga->firstWhere('jenis_iuran', 'iuran_sampah');

            $pembayaranData[] = [
                'warga' => $w,
                'kas_bulanan' => $kas,
                'iuran_sampah' => $sampah,
            ];
        }

        $totalLunas = collect($pembayaranData)->filter(fn($d) => $d['kas_bulanan'] && $d['kas_bulanan']->status === 'lunas')->count();
        $totalBelumBayar = collect($pembayaranData)->filter(fn($d) => !$d['kas_bulanan'] || $d['kas_bulanan']->status === 'belum_bayar')->count();

        return view('laporan.pembayaran', compact('pembayaranData', 'bulan', 'tahun', 'totalLunas', 'totalBelumBayar'));
    }

    public function generateTagihan(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $wargas = Warga::where('status', '!=', 'pindah')->get();

        foreach ($wargas as $w) {
            PembayaranBulanan::firstOrCreate(
                [
                    'warga_id' => $w->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jenis_iuran' => 'kas_bulanan',
                ],
                [
                    'nominal' => 50000,
                    'status' => 'belum_bayar',
                ]
            );

            PembayaranBulanan::firstOrCreate(
                [
                    'warga_id' => $w->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jenis_iuran' => 'iuran_sampah',
                ],
                [
                    'nominal' => 30000,
                    'status' => 'belum_bayar',
                ]
            );
        }

        Aktivitas::log('Generate Tagihan', "Tagihan iuran dibuat untuk periode {$bulan}/{$tahun}");

        return redirect()->route('laporan.pembayaran', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', "Tagihan iuran periode {$bulan}/{$tahun} berhasil digenerate untuk seluruh warga aktif.");
    }
}
