<?php

namespace App\Models;

use App\Models\Nasabah;
use App\Models\ProdukTabungan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';
    protected $primaryKey = 'no_rekening';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_rekening',
        'nasabah_id',
        'produk_tabungan_id',
        'saldo',
        'tgl_buka',
        'status',
        'cabang_pembuka'
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
        'tgl_buka' => 'date'
    ];

    /**
     * Relasi ke model Nasabah
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    /**
     * Relasi ke model ProdukTabungan
     */
    public function produkTabungan()
    {
        return $this->belongsTo(ProdukTabungan::class);
    }

    // Konstanta untuk status rekening
    public const STATUS = [
        'aktif' => 'Aktif',
        'nonaktif' => 'Nonaktif',
        'diblokir' => 'Diblokir'
    ];

    // Method untuk menambah saldo
    public function tambahSaldo($jumlah)
    {
        $this->saldo += $jumlah;
        return $this->save();
    }

    // Method untuk mengurangi saldo
    public function kurangiSaldo($jumlah)
    {
        if ($this->saldo >= $jumlah) {
            $this->saldo -= $jumlah;
            return $this->save();
        }
        return false;
    }
}
