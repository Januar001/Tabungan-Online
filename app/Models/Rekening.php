<?php

namespace App\Models;

use App\Models\Nasabah;
use App\Models\ProdukTabungan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekening extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekening';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'no_rekening';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; // Karena primary key adalah string (no_rekening)

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string'; // Karena primary key adalah string

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_rekening',
        'nasabah_id',
        'produk_tabungan_id',
        'saldo',
        'tgl_buka',
        'status',
        'cabang_pembuka',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'saldo' => 'decimal:2', // Pastikan saldo di-cast sebagai decimal
        'tgl_buka' => 'date',   // Pastikan tgl_buka di-cast sebagai date
        'status' => 'string',   // Enum bisa di-cast sebagai string
    ];

    /**
     * Get the nasabah that owns the rekening.
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    /**
     * Get the produk_tabungan that owns the rekening.
     */
    public function produkTabungan()
    {
        return $this->belongsTo(ProdukTabungan::class);
    }
}
