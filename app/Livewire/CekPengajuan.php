<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengajuanRekening;

class CekPengajuan extends Component
{
    public $kodePengajuan = '';
    public $noTelepon = '';

    public $pengajuan; // Untuk menyimpan data pengajuan jika ditemukan
    public $errorMessage = '';

    // Method ini akan dijalankan saat form di-submit
    public function cekStatus()
    {
        // Validasi input
        $this->validate([
            'kodePengajuan' => 'required',
            'noTelepon' => 'required',
        ]);

        // Reset state sebelum pencarian baru
        $this->pengajuan = null;
        $this->errorMessage = '';

        // Cari pengajuan berdasarkan Kode dan verifikasi dengan No. Telepon nasabah
        $result = PengajuanRekening::where('kode_pengajuan', $this->kodePengajuan)
            ->whereHas('nasabah', function ($query) {
                $query->where('no_telepon', $this->noTelepon);
            })
            ->first();

        if ($result) {
            $this->pengajuan = $result;
        } else {
            $this->errorMessage = 'Data pengajuan tidak ditemukan. Pastikan Kode Pengajuan dan Nomor Telepon sudah benar.';
        }
    }

    public function render()
    {
        // Karena ini halaman publik, kita gunakan layout 'guest' dari Breeze
        return view('livewire.cek-pengajuan')->layout('layouts.guest');
    }
}
