<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranBulanan extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_bulanan';

    protected $fillable = [
        'warga_id',
        'bulan',
        'tahun',
        'jenis_iuran',
        'nominal',
        'status',
        'tanggal_bayar',
        'pemasukan_id',
        'bukti_bayar_path',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function pemasukan(): BelongsTo
    {
        return $this->belongsTo(Pemasukan::class, 'pemasukan_id');
    }
}
