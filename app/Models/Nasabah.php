<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'nasabah';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'nama_ibu_kandung',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan_terakhir',
        'status_perkawinan',
        'pekerjaan',
        'npwp',
        'no_telepon',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function pengajuanRekening(): HasMany
    {
        return $this->hasMany(PengajuanRekening::class, 'nasabah_id');
    }

    public function alamat(): HasMany
    {
        return $this->hasMany(Alamat::class, 'nasabah_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
