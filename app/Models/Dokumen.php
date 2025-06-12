<?php

namespace App\Models;

use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'nasabah_id',
        'jenis',
        'path',
        'original_name'
    ];

    /**
     * Relasi ke model Nasabah
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    // Konstanta untuk jenis dokumen
    public const JENIS_DOKUMEN = [
        'KTP' => 'KTP',
        'foto_selfie' => 'Foto Selfie',
        'akta' => 'Akta',
        'npwp' => 'NPWP',
        'kk' => 'Kartu Keluarga',
        'surat_kerja' => 'Surat Keterangan Kerja',
        'bukti_alamat' => 'Bukti Alamat',
        'lainnya' => 'Dokumen Lainnya'
    ];

    /**
     * Get the full storage path
     */
    public function getFullPathAttribute()
    {
        return storage_path('app/' . $this->path);
    }

    /**
     * Get the public URL for the document
     */
    public function getPublicUrlAttribute()
    {
        return asset('storage/' . str_replace('public/', '', $this->path));
    }
}
