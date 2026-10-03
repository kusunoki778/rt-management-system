<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_bulanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->cascadeOnDelete();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->string('jenis_iuran')->default('kas_bulanan'); // 'kas_bulanan' or 'iuran_sampah'
            $table->decimal('nominal', 12, 2);
            $table->enum('status', ['lunas', 'belum_bayar'])->default('belum_bayar');
            $table->dateTime('tanggal_bayar')->nullable();
            $table->foreignId('pemasukan_id')->nullable()->constrained('pemasukan')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_bulanan');
    }
};
