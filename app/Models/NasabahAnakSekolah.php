<?php

namespace App\Models;

use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NasabahAnakSekolah extends Model
{
    use HasFactory;

    protected $table = 'nasabah_anak_sekolah';

    protected $fillable = [
        'nasabah_id',
        'nama_sekolah',
        'kelas',
        'nama_wali',
        'no_identitas_wali',
        'hubungan_wali'
    ];

    /**
     * Relasi ke model Nasabah
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    // Konstanta untuk hubungan wali
    public const HUBUNGAN_WALI = [
        'orang_tua' => 'Orang Tua',
        'wali' => 'Wali',
        'kakak' => 'Kakak',
        'kerabat' => 'Kerabat',
        'lainnya' => 'Lainnya'
    ];
}
