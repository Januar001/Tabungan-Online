<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PengajuanRekening;
use Illuminate\Support\Facades\Http;

class PengajuanDetail extends Component
{
    public PengajuanRekening $pengajuan;

    public $namaDesa = [];

    // Method 'mount' ini akan dipanggil saat komponen dibuat.
    // Laravel akan otomatis meng-inject model PengajuanRekening dari route.
    public function mount(PengajuanRekening $pengajuan)
    {
        // Muat semua relasi dari database
        $this->pengajuan = $pengajuan->load([
            'nasabah.alamat.provinsi',
            'nasabah.alamat.kabupaten',
            'nasabah.alamat.kecamatan',
            'dokumen',
            'kontakDarurat',
            'dataTabunganku',
            'dataBadanUsaha'
        ]);

        // --- LOGIKA BARU: AMBIL NAMA DESA DARI API ---
        // Loop melalui setiap alamat yang dimiliki nasabah
        foreach ($this->pengajuan->nasabah->alamat as $alamat) {
            if ($alamat->desa_id) {
                $response = Http::get("https://januar001.github.io/api-wilayah-indonesia/api/village/{$alamat->desa_id}.json");

                if ($response->successful()) {
                    // Simpan nama desa ke dalam array dengan key berupa ID alamat
                    $this->namaDesa[$alamat->id] = $response->json()['name'];
                } else {
                    $this->namaDesa[$alamat->id] = 'Data Tidak Ditemukan';
                }
            }
        }
    }

    // Aksi untuk menyetujui pengajuan
    public function setujui()
    {
        // Sekarang, tombol setujui akan mengubah status menjadi 'menunggu_pembayaran'
        $this->pengajuan->update(['status' => 'menunggu_pembayaran']);

        session()->flash('message', 'Pengajuan disetujui dan sekarang menunggu pembayaran setoran awal dari nasabah.');
    }

    // Aksi untuk menolak pengajuan
    public function tolak()
    {
        $this->pengajuan->update(['status' => 'ditolak']);

        // Tampilkan pesan sukses
        session()->flash('message', 'Pengajuan telah ditolak.');
    }

    public function render()
    {
        return view('livewire.admin.pengajuan-detail')->layout('layouts.admin');
    }

    public function konfirmasiPembayaran()
    {
        // Di sini logika untuk mengaktifkan rekening bisa ditambahkan
        // Contoh: Generate nomor rekening, dll.

        $this->pengajuan->update(['status' => 'aktif']);

        session()->flash('message', 'Pembayaran telah dikonfirmasi. Rekening nasabah sekarang aktif.');
    }
}
