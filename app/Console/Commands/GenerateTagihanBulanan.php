<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Warga;
use App\Models\PembayaranBulanan;
use Carbon\Carbon;

class GenerateTagihanBulanan extends Command
{
    protected $signature = 'tagihan:generate {--bulan=} {--tahun=}';
    protected $description = 'Generate tagihan iuran bulanan (Kas RT & Iuran Sampah) untuk seluruh warga aktif';

    public function handle(): int
    {
        $bulan = (int) ($this->option('bulan') ?: now()->month);
        $tahun = (int) ($this->option('tahun') ?: now()->year);

        $wargas = Warga::where('status', '!=', 'pindah')->get();

        if ($wargas->isEmpty()) {
            $this->warn('Tidak ada warga aktif yang ditemukan.');
            return self::SUCCESS;
        }

        $count = 0;
        foreach ($wargas as $w) {
            // Kas Bulanan (Rp 50.000)
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

            // Iuran Sampah (Rp 30.000)
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

            $count++;
        }

        $namaBulan = Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y');
        $this->info("Berhasil men-generate tagihan iuran untuk {$count} warga pada periode {$namaBulan}.");

        return self::SUCCESS;
    }
}
