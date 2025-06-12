<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = [
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'nama_ibu_kandung',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'jenis_identitas',
        'no_identitas',
        'alamat_identitas',
        'alamat_domisili',
        'kode_pos',
        'kota',
        'no_telp',
        'status',
        'npwp',
        'pekerjaan',
        'penghasilan',
        'sumber_dana'
    ];

    // Konstanta untuk enum
    public const JENIS_KELAMIN = [
        'L' => 'Laki-laki',
        'P' => 'Perempuan'
    ];

    public const AGAMA = [
        'Islam' => 'Islam',
        'Kristen' => 'Kristen',
        'Katolik' => 'Katolik',
        'Hindu' => 'Hindu',
        'Buddha' => 'Buddha',
        'Konghucu' => 'Konghucu',
        'Lainnya' => 'Lainnya'
    ];

    public const PENDIDIKAN = [
        'SD' => 'SD',
        'SMP' => 'SMP',
        'SMA/K' => 'SMA/SMK',
        'Diploma' => 'Diploma',
        'S1' => 'S1',
        'S2' => 'S2',
        'S3' => 'S3',
        'Lainnya' => 'Lainnya'
    ];

    public const PEKERJAAN = [
        'PNS' => 'PNS',
        'TNI/POLRI' => 'TNI/Polri',
        'Wiraswasta' => 'Wiraswasta',
        'Karyawan Swasta' => 'Karyawan Swasta',
        'Pelajar/Mahasiswa' => 'Pelajar/Mahasiswa',
        'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
        'Lainnya' => 'Lainnya'
    ];

    public const PENGHASILAN = [
        '< 1 juta' => 'Kurang dari 1 juta',
        '1-3 juta' => '1-3 juta',
        '3-5 juta' => '3-5 juta',
        '5-10 juta' => '5-10 juta',
        '> 10 juta' => 'Lebih dari 10 juta',
        'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'
    ];

    // Fungsi untuk menghitung umur
    public function getUmurAttribute()
    {
        return now()->diffInYears($this->tanggal_lahir);
    }

    public function anakSekolah()
    {
        return $this->hasOne(NasabahAnakSekolah::class);
    }

    public function badanUsaha()
    {
        return $this->hasOne(NasabahBadanUsaha::class);
    }

    public function rekening()
    {
        return $this->hasMany(Rekening::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }
}
