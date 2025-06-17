<?php

namespace App\Models;

use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanRekening extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'pengajuan_rekening';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nasabah_id',
        'kode_pengajuan',
        'produk',
        'tipe_simade',
        'penghasilan_per_bulan',
        'sumber_dana',
        'tujuan_penggunaan',
        'status',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }
    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPengajuan::class, 'pengajuan_rekening_id');
    }
    public function dataTabunganku(): HasOne
    {
        return $this->hasOne(DataTabunganku::class, 'pengajuan_rekening_id');
    }
    public function dataBadanUsaha(): HasOne
    {
        return $this->hasOne(DataBadanUsaha::class, 'pengajuan_rekening_id');
    }
    public function kontakDarurat(): HasMany
    {
        return $this->hasMany(KontakDarurat::class, 'pengajuan_rekening_id');
    }
}
