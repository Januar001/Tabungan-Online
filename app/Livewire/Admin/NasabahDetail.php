<?php

namespace App\Livewire\Admin;

use App\Models\Nasabah;
use Livewire\Component;

class NasabahDetail extends Component
{
    public Nasabah $nasabah;

    // Properti untuk form modal edit
    public $modalTitle = '';
    public $nasabahId;
    public $nama_lengkap, $nama_panggilan, $jenis_kelamin, $nama_ibu_kandung,
           $tempat_lahir, $tanggal_lahir, $agama, $pendidikan_terakhir,
           $status_perkawinan, $pekerjaan, $npwp, $no_telepon;

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon'   => 'required|string|max:15',
            'nama_ibu_kandung' => 'required|string|max:255',
        ];
    }

    public function mount(Nasabah $nasabah)
    {
        // Eager load SEMUA relasi yang dibutuhkan dalam satu query efisien
        $this->nasabah = $nasabah->load([
            'user', 
            'alamat.provinsi', 
            'alamat.kabupaten', 
            'alamat.kecamatan', 
            'pengajuanRekening' => function ($query) {
                $query->latest(); // Urutkan pengajuan dari yang terbaru
            },
            'pengajuanRekening.dokumen', 
            'pengajuanRekening.kontakDarurat', 
            'pengajuanRekening.dataTabunganku', 
            'pengajuanRekening.dataBadanUsaha'
        ]);
    }

    public function openEditModal()
    {
        $this->resetValidation();
        $this->nasabahId = $this->nasabah->id;
        $this->modalTitle = 'Edit Data Nasabah';
        
        $nasabahData = $this->nasabah;
        $this->nama_lengkap = $nasabahData->nama_lengkap;
        $this->nama_panggilan = $nasabahData->nama_panggilan;
        $this->jenis_kelamin = $nasabahData->jenis_kelamin;
        $this->nama_ibu_kandung = $nasabahData->nama_ibu_kandung;
        $this->tempat_lahir = $nasabahData->tempat_lahir;
        $this->tanggal_lahir = $nasabahData->tanggal_lahir;
        $this->agama = $nasabahData->agama;
        $this->pendidikan_terakhir = $nasabahData->pendidikan_terakhir;
        $this->status_perkawinan = $nasabahData->status_perkawinan;
        $this->pekerjaan = $nasabahData->pekerjaan;
        $this->npwp = $nasabahData->npwp;
        $this->no_telepon = $nasabahData->no_telepon;
    }

    public function simpanNasabah()
    {
        $validatedData = $this->validate();
        $this->nasabah->update($validatedData);
        
        session()->flash('message', 'Data nasabah berhasil diperbarui.');
        $this->dispatch('close-modal');
    }

    public function hapusNasabah()
    {
        $this->nasabah->delete();
        session()->flash('message', 'Data nasabah dan semua riwayat terkait berhasil dihapus.');
        return $this->redirectRoute('admin.nasabah.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.nasabah-detail')->layout('layouts.admin');
    }
}