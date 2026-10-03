<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPemasukan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pemasukan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function pemasukan(): HasMany
    {
        return $this->hasMany(Pemasukan::class, 'kategori_pemasukan_id');
    }
}
