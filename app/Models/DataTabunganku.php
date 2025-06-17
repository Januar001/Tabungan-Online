<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataTabunganku extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'data_tabunganku';

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'pengajuan_rekening_id',
        'nama_sekolah',
        'kelas',
        'nama_wali',
        'no_identitas_wali',
        'hubungan_wali',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model PengajuanRekening.
     * Setiap data tabunganku dimiliki oleh satu pengajuan rekening.
     */
    public function pengajuanRekening(): BelongsTo
    {
        return $this->belongsTo(PengajuanRekening::class);
    }
}
