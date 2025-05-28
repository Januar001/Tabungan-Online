<?php

namespace App\Models;

use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dokumen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nasabah_id',
        'jenis',
        'path',
        'original_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jenis' => 'string', // Enum bisa di-cast sebagai string
    ];

    /**
     * Get the nasabah that owns the dokumen.
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
