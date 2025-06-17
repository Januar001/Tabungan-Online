<?php

namespace App\Models;

use App\Models\PengajuanRekening;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPengajuan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'dokumen_pengajuan';

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'pengajuan_rekening_id',
        'jenis_dokumen',
        'path_file',
        'nama_asli_file',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model PengajuanRekening.
     * Setiap dokumen dimiliki oleh satu pengajuan rekening.
     */
    public function pengajuanRekening(): BelongsTo
    {
        return $this->belongsTo(PengajuanRekening::class);
    }
}
