<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktivitas extends Model
{
    use HasFactory;

    protected $table = 'aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'detail',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function log(string $aktivitas, ?string $detail = null): static
    {
        return static::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'detail' => $detail,
            'ip_address' => request()->ip(),
        ]);
    }
}
