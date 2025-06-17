<?php

namespace App\Livewire\Admin;

use App\Models\PengajuanRekening;
use Livewire\Component;
use Livewire\WithPagination;

class PengajuanList extends Component
{
    use WithPagination;

    // Properti untuk filter dan pencarian
    public $search = '';
    public $filterStatus = '';
    public $filterProduk = '';

    // Properti untuk menampung pilihan filter
    public $listStatus;
    public $listProduk;

    public function mount()
    {
        // Siapkan data untuk dropdown filter
        $this->listStatus = ['pending', 'diproses', 'menunggu_pembayaran', 'aktif', 'disetujui', 'ditolak'];
        $this->listProduk = ['tabunganku', 'simade'];
    }

    // Reset halaman setiap kali ada perubahan pada filter atau pencarian
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingFilterProduk() { $this->resetPage(); }

    public function render()
    {
        $pengajuans = PengajuanRekening::with('nasabah') // Eager loading
            ->when($this->search, function ($query) {
                // Logika pencarian
                $query->where('kode_pengajuan', 'like', '%'.$this->search.'%')
                      ->orWhereHas('nasabah', function($subQuery) {
                          $subQuery->where('nama_lengkap', 'like', '%'.$this->search.'%');
                      });
            })
            ->when($this->filterStatus, function ($query) {
                // Logika filter status
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterProduk, function ($query) {
                // Logika filter produk
                $query->where('produk', $this->filterProduk);
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10);

        return view('livewire.admin.pengajuan-list', [
            'pengajuans' => $pengajuans
        ])->layout('layouts.admin');
    }
}