<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanWarga extends Model
{
    use HasFactory;

    protected $table = 'laporan_warga';

    protected $fillable = [
        'warga_id',
        'kategori',
        'judul',
        'deskripsi',
        'foto_path',
        'status',
        'tanggapan_rt',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
