<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataBadanUsaha extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'data_badan_usaha';

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'pengajuan_rekening_id',
        'nama_perusahaan',
        'no_akta_pendirian',
        'no_izin_usaha',
        'npwp_perusahaan',
        'jabatan_pengurus',
        'no_telepon_perusahaan',
        'bidang_usaha',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model PengajuanRekening.
     * Setiap data badan usaha dimiliki oleh satu pengajuan rekening.
     */
    public function pengajuanRekening(): BelongsTo
    {
        return $this->belongsTo(PengajuanRekening::class);
    }
}
