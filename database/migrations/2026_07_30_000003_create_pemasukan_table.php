<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->nullable()->constrained('warga')->nullOnDelete();
            $table->foreignId('kategori_pemasukan_id')->constrained('kategori_pemasukan')->cascadeOnDelete();
            $table->decimal('nominal', 12, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer'])->default('cash');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};
