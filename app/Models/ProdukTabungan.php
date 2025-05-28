<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukTabungan extends Model
{
    use HasFactory;

    protected $table = 'produk_tabungan';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'jenis_pelanggan',
        'min_umur',
        'max_umur',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_umur' => 'integer',
        'max_umur' => 'integer',
    ];

    public const JENIS_PELANGGAN = [
        'perorangan' => 'Perorangan',
        'badan_usaha' => 'Badan Usaha',
        'anak_sekolah' => 'Anak Sekolah'
    ];
}
