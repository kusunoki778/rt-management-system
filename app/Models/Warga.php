<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nomor_rumah',
        'no_hp',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'warga_id');
    }

    public function pemasukan(): HasMany
    {
        return $this->hasMany(Pemasukan::class, 'warga_id');
    }

    public function pembayaranBulanan(): HasMany
    {
        return $this->hasMany(PembayaranBulanan::class, 'warga_id');
    }

    public function suratPengantar(): HasMany
    {
        return $this->hasMany(SuratPengantar::class, 'warga_id');
    }

    public function laporanWarga(): HasMany
    {
        return $this->hasMany(LaporanWarga::class, 'warga_id');
    }
}
