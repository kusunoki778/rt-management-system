<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warga;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\PembayaranBulanan;
use App\Models\Pengumuman;
use App\Models\Aktivitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Pemasukan
        $katMasukKas = KategoriPemasukan::create([
            'nama_kategori' => 'Kas Bulanan',
            'deskripsi' => 'Iuran rutin kas warga bulanan'
        ]);
        $katMasukSampah = KategoriPemasukan::create([
            'nama_kategori' => 'Iuran Sampah',
            'deskripsi' => 'Iuran kebersihan dan pengangkutan sampah'
        ]);
        $katMasukDonasi = KategoriPemasukan::create([
            'nama_kategori' => 'Donasi',
            'deskripsi' => 'Sumbangan sukarela warga atau pihak luar'
        ]);
        $katMasukDenda = KategoriPemasukan::create([
            'nama_kategori' => 'Denda',
            'deskripsi' => 'Denda keterlambatan pembayaran atau pelanggaran aturan RT'
        ]);
        $katMasukLain = KategoriPemasukan::create([
            'nama_kategori' => 'Lainnya',
            'deskripsi' => 'Pemasukan di luar kategori reguler'
        ]);

        // 2. Kategori Pengeluaran
        $katKeluarKebersihan = KategoriPengeluaran::create([
            'nama_kategori' => 'Kebersihan',
            'deskripsi' => 'Honor petugas sampah & alat kebersihan'
        ]);
        $katKeluarKeamanan = KategoriPengeluaran::create([
            'nama_kategori' => 'Keamanan',
            'deskripsi' => 'Honor satpam, ronda, dan perawatan portal'
        ]);
        $katKeluarPerbaikan = KategoriPengeluaran::create([
            'nama_kategori' => 'Perbaikan',
            'deskripsi' => 'Perbaikan fasilitas umum & penerangan jalan'
        ]);
        $katKeluarKonsumsi = KategoriPengeluaran::create([
            'nama_kategori' => 'Konsumsi',
            'deskripsi' => 'Konsumsi rapat RT dan kegiatan warga'
        ]);
        $katKeluarLain = KategoriPengeluaran::create([
            'nama_kategori' => 'Lainnya',
            'deskripsi' => 'Pengeluaran operasional lain-lain'
        ]);

        // 3. Data Warga (20 Warga)
        $wargaList = [
            ['nik' => '3171011501850001', 'nama' => 'Budi Santoso', 'jk' => 'L', 'tmpl' => 'Jakarta', 'tgl' => '1985-01-15', 'no' => 'A-01', 'hp' => '081234567890', 'st' => 'tetap'],
            ['nik' => '3171012003880002', 'nama' => 'Ahmad Fauzi', 'jk' => 'L', 'tmpl' => 'Bandung', 'tgl' => '1988-03-20', 'no' => 'A-02', 'hp' => '081234567891', 'st' => 'tetap'],
            ['nik' => '3171011005900003', 'nama' => 'Siti Rahmawati', 'jk' => 'P', 'tmpl' => 'Bogor', 'tgl' => '1990-05-10', 'no' => 'A-03', 'hp' => '081234567892', 'st' => 'tetap'],
            ['nik' => '3171012507820004', 'nama' => 'Eko Prasetyo', 'jk' => 'L', 'tmpl' => 'Semarang', 'tgl' => '1982-07-25', 'no' => 'B-01', 'hp' => '081234567893', 'st' => 'tetap'],
            ['nik' => '3171010509920005', 'nama' => 'Hendra Wijaya', 'jk' => 'L', 'tmpl' => 'Surabaya', 'tgl' => '1992-09-05', 'no' => 'B-02', 'hp' => '081234567894', 'st' => 'kontrak'],
            ['nik' => '3171011211950006', 'nama' => 'Dewi Sartika', 'jk' => 'P', 'tmpl' => 'Yogyakarta', 'tgl' => '1995-11-12', 'no' => 'B-03', 'hp' => '081234567895', 'st' => 'tetap'],
            ['nik' => '3171011802870007', 'nama' => 'Rina Dahlia', 'jk' => 'P', 'tmpl' => 'Solo', 'tgl' => '1987-02-18', 'no' => 'C-01', 'hp' => '081234567896', 'st' => 'tetap'],
            ['nik' => '3171012204840008', 'nama' => 'Bambang Pamungkas', 'jk' => 'L', 'tmpl' => 'Jakarta', 'tgl' => '1984-04-22', 'no' => 'C-02', 'hp' => '081234567897', 'st' => 'tetap'],
            ['nik' => '3171010806930009', 'nama' => 'Agus Setiawan', 'jk' => 'L', 'tmpl' => 'Malang', 'tgl' => '1993-06-08', 'no' => 'C-03', 'hp' => '081234567898', 'st' => 'kontrak'],
            ['nik' => '3171013008910010', 'nama' => 'Maya Indah', 'jk' => 'P', 'tmpl' => 'Cirebon', 'tgl' => '1991-08-30', 'no' => 'D-01', 'hp' => '081234567899', 'st' => 'tetap'],
            ['nik' => '3171011410860011', 'nama' => 'Dedi Kurniawan', 'jk' => 'L', 'tmpl' => 'Medan', 'tgl' => '1986-10-14', 'no' => 'D-02', 'hp' => '081345678901', 'st' => 'tetap'],
            ['nik' => '3171011912890012', 'nama' => 'Sri Wahyuni', 'jk' => 'P', 'tmpl' => 'Palembang', 'tgl' => '1989-12-19', 'no' => 'D-03', 'hp' => '081345678902', 'st' => 'tetap'],
            ['nik' => '3171010101940013', 'nama' => 'Rudi Hermawan', 'jk' => 'L', 'tmpl' => 'Padang', 'tgl' => '1994-01-01', 'no' => 'E-01', 'hp' => '081345678903', 'st' => 'kontrak'],
            ['nik' => '3171011103830014', 'nama' => 'Nurul Hidayah', 'jk' => 'P', 'tmpl' => 'Lampung', 'tgl' => '1983-03-11', 'no' => 'E-02', 'hp' => '081345678904', 'st' => 'tetap'],
            ['nik' => '3171012805960015', 'nama' => 'Fajar Nugraha', 'jk' => 'L', 'tmpl' => 'Pontianak', 'tgl' => '1996-05-28', 'no' => 'E-03', 'hp' => '081345678905', 'st' => 'tetap'],
            ['nik' => '3171010407810016', 'nama' => 'Titi Kamal', 'jk' => 'P', 'tmpl' => 'Jakarta', 'tgl' => '1981-07-04', 'no' => 'F-01', 'hp' => '081345678906', 'st' => 'tetap'],
            ['nik' => '3171011609900017', 'nama' => 'Irfan Hakim', 'jk' => 'L', 'tmpl' => 'Bandung', 'tgl' => '1990-09-16', 'no' => 'F-02', 'hp' => '081345678907', 'st' => 'tetap'],
            ['nik' => '3171012111870018', 'nama' => 'Lestari Putri', 'jk' => 'P', 'tmpl' => 'Surakarta', 'tgl' => '1987-11-21', 'no' => 'F-03', 'hp' => '081345678908', 'st' => 'tetap'],
            ['nik' => '3171010901920019', 'nama' => 'Gading Marten', 'jk' => 'L', 'tmpl' => 'Jakarta', 'tgl' => '1992-01-09', 'no' => 'G-01', 'hp' => '081345678909', 'st' => 'pindah'],
            ['nik' => '3171011703950020', 'nama' => 'Nia Ramadhani', 'jk' => 'P', 'tmpl' => 'Jakarta', 'tgl' => '1995-03-17', 'no' => 'G-02', 'hp' => '081345678910', 'st' => 'tetap'],
        ];

        $createdWarga = [];
        foreach ($wargaList as $w) {
            $createdWarga[] = Warga::create([
                'nik' => $w['nik'],
                'nama' => $w['nama'],
                'jenis_kelamin' => $w['jk'],
                'tempat_lahir' => $w['tmpl'],
                'tanggal_lahir' => $w['tgl'],
                'alamat' => 'Jl. Merpati RT 05 / RW 02 No. ' . $w['no'],
                'nomor_rumah' => $w['no'],
                'no_hp' => $w['hp'],
                'status' => $w['st'],
            ]);
        }

        // 4. Accounts (Users)
        $admin = User::create([
            'name' => 'Administrator RT',
            'email' => 'admin@rt05.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'warga_id' => $createdWarga[0]->id,
        ]);

        $bendahara = User::create([
            'name' => 'Ibu Bendahara RT',
            'email' => 'bendahara@rt05.id',
            'password' => Hash::make('password'),
            'role' => 'bendahara',
            'warga_id' => $createdWarga[2]->id,
        ]);

        $ketuaRt = User::create([
            'name' => 'Bapak Ketua RT',
            'email' => 'ketuart@rt05.id',
            'password' => Hash::make('password'),
            'role' => 'ketua_rt',
            'warga_id' => $createdWarga[1]->id,
        ]);

        $wargaUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'warga@rt05.id',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'warga_id' => $createdWarga[0]->id,
        ]);

        // Create user accounts for all remaining warga
        foreach ($createdWarga as $index => $w) {
            if ($index > 3) {
                User::create([
                    'name' => $w->nama,
                    'email' => strtolower(str_replace(' ', '', $w->nama)) . '@rt05.id',
                    'password' => Hash::make('password'),
                    'role' => 'warga',
                    'warga_id' => $w->id,
                ]);
            }
        }

        // 5. Historical Pemasukan & Pengeluaran (Last 6 Months)
        $now = Carbon::now();
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = $now->copy()->subMonths($i);
            $year = $monthDate->year;
            $month = $monthDate->month;

            // Generate Monthly Dues for active Warga (non-pindah)
            foreach ($createdWarga as $wIndex => $w) {
                if ($w->status === 'pindah') continue;

                // 80% of residents paid, 20% unpaid for recent months
                $isPaid = ($wIndex % 5 !== 0) || ($i > 2); // recent months have some unpaid

                $tglBayar = $isPaid ? Carbon::create($year, $month, rand(1, 15), rand(8, 17)) : null;

                // Kas Bulanan (Rp 50.000)
                $pemKas = null;
                if ($isPaid) {
                    $pemKas = Pemasukan::create([
                        'warga_id' => $w->id,
                        'kategori_pemasukan_id' => $katMasukKas->id,
                        'nominal' => 50000,
                        'metode_pembayaran' => rand(0, 1) ? 'cash' : 'transfer',
                        'tanggal' => $tglBayar->toDateString(),
                        'keterangan' => 'Kas Bulanan ' . $tglBayar->format('F Y') . ' - ' . $w->nama,
                        'created_by' => $bendahara->id,
                    ]);
                }

                PembayaranBulanan::create([
                    'warga_id' => $w->id,
                    'bulan' => $month,
                    'tahun' => $year,
                    'jenis_iuran' => 'kas_bulanan',
                    'nominal' => 50000,
                    'status' => $isPaid ? 'lunas' : 'belum_bayar',
                    'tanggal_bayar' => $tglBayar,
                    'pemasukan_id' => $pemKas ? $pemKas->id : null,
                ]);

                // Iuran Sampah (Rp 30.000)
                $pemSampah = null;
                if ($isPaid) {
                    $pemSampah = Pemasukan::create([
                        'warga_id' => $w->id,
                        'kategori_pemasukan_id' => $katMasukSampah->id,
                        'nominal' => 30000,
                        'metode_pembayaran' => rand(0, 1) ? 'cash' : 'transfer',
                        'tanggal' => $tglBayar->toDateString(),
                        'keterangan' => 'Iuran Sampah ' . $tglBayar->format('F Y') . ' - ' . $w->nama,
                        'created_by' => $bendahara->id,
                    ]);
                }

                PembayaranBulanan::create([
                    'warga_id' => $w->id,
                    'bulan' => $month,
                    'tahun' => $year,
                    'jenis_iuran' => 'iuran_sampah',
                    'nominal' => 30000,
                    'status' => $isPaid ? 'lunas' : 'belum_bayar',
                    'tanggal_bayar' => $tglBayar,
                    'pemasukan_id' => $pemSampah ? $pemSampah->id : null,
                ]);
            }

            // Monthly Expenses
            Pengeluaran::create([
                'kategori_pengeluaran_id' => $katKeluarKebersihan->id,
                'nominal' => 450000,
                'tanggal' => Carbon::create($year, $month, 20)->toDateString(),
                'keterangan' => 'Honor Petugas Kebersihan & Sampah Bulan ' . $monthDate->format('F Y'),
                'created_by' => $bendahara->id,
            ]);

            Pengeluaran::create([
                'kategori_pengeluaran_id' => $katKeluarKeamanan->id,
                'nominal' => 600000,
                'tanggal' => Carbon::create($year, $month, 25)->toDateString(),
                'keterangan' => 'Honor Petugas Pos Ronda & Keamanan RT ' . $monthDate->format('F Y'),
                'created_by' => $bendahara->id,
            ]);

            if ($i % 2 === 0) {
                Pengeluaran::create([
                    'kategori_pengeluaran_id' => $katKeluarPerbaikan->id,
                    'nominal' => 150000,
                    'tanggal' => Carbon::create($year, $month, 10)->toDateString(),
                    'keterangan' => 'Pembelian Lampu LED Jalan & Perbaikan Kabel Portal',
                    'created_by' => $admin->id,
                ]);
            }
        }

        // Additional Donasi & Lainnya Income
        Pemasukan::create([
            'warga_id' => $createdWarga[3]->id,
            'kategori_pemasukan_id' => $katMasukDonasi->id,
            'nominal' => 500000,
            'metode_pembayaran' => 'transfer',
            'tanggal' => Carbon::now()->subDays(5)->toDateString(),
            'keterangan' => 'Donasi untuk Kerja Bakti Lingkungan dari Bpk. Eko Prasetyo',
            'created_by' => $bendahara->id,
        ]);

        // 6. Pengumuman
        Pengumuman::create([
            'judul' => 'Kerja Bakti Bersih Lingkungan RT 05',
            'isi' => "Kepada Yth. Seluruh Warga RT 05/RW 02,\n\nDiimbau kepada seluruh warga untuk hadir dalam kegiatan Kerja Bakti yang akan dilaksanakan pada:\n\nHari/Tanggal: Minggu, " . Carbon::now()->addDays(3)->translatedFormat('d F Y') . "\nWaktu: 07.00 WIB - Selesai\nTitik Kumpul: Pos Ronda RT 05\n\nMohon membawa peralatan kebersihan masing-masing. Konsumsi disediakan oleh pengurus RT. Terima kasih atas partisipasinya.",
            'status' => 'published',
            'is_pinned' => true,
            'tanggal_publish' => Carbon::now()->subDays(2),
            'created_by' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Jadwal Posyandu Balita & Pemeriksaan Kesehatan Lansia',
            'isi' => "Diberitahukan kepada ibu-ibu dan lansia warga RT 05, Posyandu Balita dan pemeriksaan kesehatan gratis akan dilaksanakan pada:\n\nHari/Tanggal: Sabtu, " . Carbon::now()->addDays(7)->translatedFormat('d F Y') . "\nTempat: Balai Warga RT 05\nWaktu: 08.30 - 11.30 WIB.\n\nJangan lupa membawa buku KIA.",
            'status' => 'published',
            'is_pinned' => false,
            'tanggal_publish' => Carbon::now()->subDays(5),
            'created_by' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Draft: Perencanaan Rapat Warga Menyambut HUT RI',
            'isi' => 'Rencana pembahasan kepanitiaan lomba dan anggaran 17 Agustus.',
            'status' => 'draft',
            'is_pinned' => false,
            'tanggal_publish' => null,
            'created_by' => $admin->id,
        ]);

        // 7. Initial Activity Log
        Aktivitas::create([
            'user_id' => $admin->id,
            'aktivitas' => 'Inisialisasi Sistem RT Management System',
            'detail' => 'Database dan data awal berhasil di-seed oleh Administrator.',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
