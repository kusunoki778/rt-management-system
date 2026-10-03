<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\PembayaranBulanan;
use App\Models\Aktivitas;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isWarga()) {
            return $this->wargaDashboard($user);
        }

        $totalWarga = Warga::where('status', '!=', 'pindah')->count();

        $totalPemasukan = Pemasukan::whereYear('tanggal', now()->year)
            ->sum('nominal');

        $totalPengeluaran = Pengeluaran::whereYear('tanggal', now()->year)
            ->sum('nominal');

        $saldoKas = Pemasukan::sum('nominal') - Pengeluaran::sum('nominal');

        $bulanIni = now()->month;
        $tahunIni = now()->year;

        $wargaBelumBayar = PembayaranBulanan::where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->where('status', 'belum_bayar')
            ->where('jenis_iuran', 'kas_bulanan')
            ->count();

        // Monthly chart data (last 6 months)
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y');
            $chartPemasukan[] = Pemasukan::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('nominal');
            $chartPengeluaran[] = Pengeluaran::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('nominal');
        }

        // Recent transactions
        $recentPemasukan = Pemasukan::with(['warga', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        $recentPengeluaran = Pengeluaran::with(['kategori', 'creator'])
            ->latest()
            ->take(5)
            ->get();

        // Recent activity
        $recentAktivitas = Aktivitas::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Belum bayar list
        $belumBayarList = PembayaranBulanan::with('warga')
            ->where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->where('status', 'belum_bayar')
            ->where('jenis_iuran', 'kas_bulanan')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalWarga', 'totalPemasukan', 'totalPengeluaran', 'saldoKas',
            'wargaBelumBayar', 'chartLabels', 'chartPemasukan', 'chartPengeluaran',
            'recentPemasukan', 'recentPengeluaran', 'recentAktivitas', 'belumBayarList'
        ));
    }

    private function wargaDashboard($user)
    {
        $warga = $user->warga;
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        $riwayatPembayaran = PembayaranBulanan::where('warga_id', $warga?->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->take(12)
            ->get();

        $statusBulanIni = PembayaranBulanan::where('warga_id', $warga?->id)
            ->where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->get();

        $recentPemasukan = Pemasukan::where('warga_id', $warga?->id)
            ->with('kategori')
            ->latest()
            ->take(10)
            ->get();

        $latestPengumuman = Pengumuman::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard.warga', compact('warga', 'riwayatPembayaran', 'statusBulanIni', 'recentPemasukan', 'latestPengumuman'));
    }

    public function transparansi()
    {
        $totalKas = Pemasukan::sum('nominal') - Pengeluaran::sum('nominal');

        $pemasukanBulanIni = Pemasukan::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('nominal');

        $pengeluaranBulanIni = Pengeluaran::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('nominal');

        $totalIuranLunas = PembayaranBulanan::where('status', 'lunas')->sum('nominal');

        $riwayatPengeluaran = Pengeluaran::with('kategori')
            ->latest('tanggal')
            ->take(50)
            ->get();

        return view('dashboard.transparansi', compact(
            'totalKas', 'pemasukanBulanIni', 'pengeluaranBulanIni', 'totalIuranLunas', 'riwayatPengeluaran'
        ));
    }
}
