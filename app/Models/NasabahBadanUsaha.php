<?php

namespace App\Models;

use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NasabahBadanUsaha extends Model
{
    use HasFactory;

    protected $table = 'nasabah_badan_usaha';

    protected $fillable = [
        'nasabah_id',
        'nama_perusahaan',
        'no_akta_pendirian',
        'no_izin_usaha',
        'npwp_perusahaan',
        'jabatan',
        'no_telp_perusahaan'
    ];

    /**
     * Relasi ke model Nasabah
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    // Konstanta untuk jabatan umum
    public const JABATAN = [
        'direktur' => 'Direktur',
        'komisaris' => 'Komisaris',
        'manager' => 'Manager',
        'pemilik' => 'Pemilik',
        'lainnya' => 'Lainnya'
    ];
}
