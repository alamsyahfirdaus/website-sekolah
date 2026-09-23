<?php

namespace App\Models;

use Database\Factories\EkstrakurikulerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ekstrakurikuler extends Model
{
    /** @use HasFactory<EkstrakurikulerFactory> */
    use HasFactory;

    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama_ekskul',
        'id_guru',
        'jadwal_latihan',
        'deskripsi',
        'gambar',
    ];

    /**
     * Relasi ke Guru (Pembina ekstrakurikuler).
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }
}
