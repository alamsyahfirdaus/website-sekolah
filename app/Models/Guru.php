<?php

namespace App\Models;

use Database\Factories\GuruFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    /** @use HasFactory<GuruFactory> */
    use HasFactory;

    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'nama_guru',
        'nip',
        'mapel',
        'foto',
    ];

    /**
     * Relasi ke Ekstrakurikuler (1 Guru -> N Ekstrakurikuler).
     */
    public function ekstrakurikuler(): HasMany
    {
        return $this->hasMany(Ekstrakurikuler::class, 'id_guru', 'id_guru');
    }
}
