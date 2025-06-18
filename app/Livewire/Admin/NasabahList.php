<?php

namespace App\Livewire\Admin;

use App\Models\Nasabah;
use Livewire\Component;
use Livewire\WithPagination;

class NasabahList extends Component
{
    use WithPagination;

    // Properti untuk UI
    public $search = '';
    public $modalTitle = '';
    public $nasabahId;

    // Properti untuk data nasabah (form)
    public $nama_lengkap, $nama_panggilan, $jenis_kelamin, $nama_ibu_kandung,
           $tempat_lahir, $tanggal_lahir, $agama, $pendidikan_terakhir,
           $status_perkawinan, $pekerjaan, $npwp, $no_telepon;

    // Aturan validasi
    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon'   => 'required|string|max:15',
            'nama_ibu_kandung' => 'required|string|max:255',
            // Tambahkan aturan lain jika diperlukan
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    public function openAddModal()
    {
        $this->resetValidation();
        $this->reset(); // Reset semua properti publik
        $this->modalTitle = 'Tambah Nasabah Baru';
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $nasabah = Nasabah::findOrFail($id);
        
        $this->nasabahId = $id;
        $this->modalTitle = 'Edit Data Nasabah';
        
        // Isi properti form dengan data yang ada
        $this->nama_lengkap = $nasabah->nama_lengkap;
        $this->nama_panggilan = $nasabah->nama_panggilan;
        $this->jenis_kelamin = $nasabah->jenis_kelamin;
        $this->nama_ibu_kandung = $nasabah->nama_ibu_kandung;
        $this->tempat_lahir = $nasabah->tempat_lahir;
        $this->tanggal_lahir = $nasabah->tanggal_lahir;
        $this->agama = $nasabah->agama;
        $this->pendidikan_terakhir = $nasabah->pendidikan_terakhir;
        $this->status_perkawinan = $nasabah->status_perkawinan;
        $this->pekerjaan = $nasabah->pekerjaan;
        $this->npwp = $nasabah->npwp;
        $this->no_telepon = $nasabah->no_telepon;
    }

    public function simpanNasabah()
    {
        $this->validate();

        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'nama_panggilan' => $this->nama_panggilan,
            'jenis_kelamin' => $this->jenis_kelamin,
            'nama_ibu_kandung' => $this->nama_ibu_kandung,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'agama' => $this->agama,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,
            'status_perkawinan' => $this->status_perkawinan,
            'pekerjaan' => $this->pekerjaan,
            'npwp' => $this->npwp,
            'no_telepon' => $this->no_telepon,
        ];

        if ($this->nasabahId) {
            // Update data
            Nasabah::find($this->nasabahId)->update($data);
            session()->flash('message', 'Data nasabah berhasil diperbarui.');
        } else {
            // Buat data baru
            Nasabah::create($data);
            session()->flash('message', 'Nasabah baru berhasil ditambahkan.');
        }

        $this->dispatch('close-modal');
    }

    public function hapusNasabah($id)
    {
        Nasabah::find($id)->delete();
        session()->flash('message', 'Data nasabah dan semua riwayat terkait berhasil dihapus.');
    }

    public function render()
    {
        $nasabahs = Nasabah::withCount('pengajuanRekening') // Hitung jumlah pengajuan
            ->where(function ($query) {
                $query->where('nama_lengkap', 'like', '%'.$this->search.'%')
                      ->orWhere('no_telepon', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.nasabah-list', [
            'nasabahs' => $nasabahs,
        ])->layout('layouts.admin');
    }
}