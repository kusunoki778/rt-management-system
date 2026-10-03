<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_bulanan', function (Blueprint $table) {
            $table->string('bukti_bayar_path')->nullable()->after('pemasukan_id');
        });

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
            DB::statement("CREATE TABLE pembayaran_bulanan_new (
                id integer primary key autoincrement not null,
                warga_id integer not null,
                bulan integer not null,
                tahun integer not null,
                jenis_iuran varchar not null default 'kas_bulanan',
                nominal numeric not null,
                status varchar check (\"status\" in ('lunas', 'belum_bayar', 'menunggu_verifikasi')) not null default 'belum_bayar',
                tanggal_bayar datetime,
                pemasukan_id integer,
                bukti_bayar_path varchar,
                created_at datetime,
                updated_at datetime,
                foreign key(\"warga_id\") references \"warga\"(\"id\") on delete cascade,
                foreign key(\"pemasukan_id\") references \"pemasukan\"(\"id\") on delete set null
            )");
            DB::statement("INSERT INTO pembayaran_bulanan_new (id, warga_id, bulan, tahun, jenis_iuran, nominal, status, tanggal_bayar, pemasukan_id, bukti_bayar_path, created_at, updated_at)
                SELECT id, warga_id, bulan, tahun, jenis_iuran, nominal, status, tanggal_bayar, pemasukan_id, bukti_bayar_path, created_at, updated_at FROM pembayaran_bulanan");
            DB::statement("DROP TABLE pembayaran_bulanan");
            DB::statement("ALTER TABLE pembayaran_bulanan_new RENAME TO pembayaran_bulanan");
            DB::statement('PRAGMA foreign_keys=ON');
        } else {
            DB::statement("ALTER TABLE pembayaran_bulanan MODIFY status ENUM('lunas', 'belum_bayar', 'menunggu_verifikasi') DEFAULT 'belum_bayar'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
            DB::statement("CREATE TABLE pembayaran_bulanan_new (
                id integer primary key autoincrement not null,
                warga_id integer not null,
                bulan integer not null,
                tahun integer not null,
                jenis_iuran varchar not null default 'kas_bulanan',
                nominal numeric not null,
                status varchar check (\"status\" in ('lunas', 'belum_bayar')) not null default 'belum_bayar',
                tanggal_bayar datetime,
                pemasukan_id integer,
                created_at datetime,
                updated_at datetime,
                foreign key(\"warga_id\") references \"warga\"(\"id\") on delete cascade,
                foreign key(\"pemasukan_id\") references \"pemasukan\"(\"id\") on delete set null
            )");
            DB::statement("INSERT INTO pembayaran_bulanan_new (id, warga_id, bulan, tahun, jenis_iuran, nominal, status, tanggal_bayar, pemasukan_id, created_at, updated_at)
                SELECT id, warga_id, bulan, tahun, jenis_iuran, nominal, status, tanggal_bayar, pemasukan_id, created_at, updated_at FROM pembayaran_bulanan");
            DB::statement("DROP TABLE pembayaran_bulanan");
            DB::statement("ALTER TABLE pembayaran_bulanan_new RENAME TO pembayaran_bulanan");
            DB::statement('PRAGMA foreign_keys=ON');
        } else {
            DB::statement("ALTER TABLE pembayaran_bulanan MODIFY status ENUM('lunas', 'belum_bayar') DEFAULT 'belum_bayar'");
        }

        Schema::table('pembayaran_bulanan', function (Blueprint $table) {
            $table->dropColumn('bukti_bayar_path');
        });
    }
};
