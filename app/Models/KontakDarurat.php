<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontakDarurat extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'kontak_darurat';

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'pengajuan_rekening_id',
        'nama_lengkap',
        'hubungan',
        'alamat',
        'no_telepon',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model PengajuanRekening.
     */
    public function pengajuanRekening(): BelongsTo
    {
        return $this->belongsTo(PengajuanRekening::class);
    }
}
