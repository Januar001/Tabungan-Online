<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatPengajuan extends Component
{
    use WithPagination;

    /**
     * Dijalankan pertama kali saat komponen dimuat.
     * Digunakan untuk pemeriksaan otorisasi.
     */
    public function mount()
    {
        // Jika user yang login adalah admin atau superadmin,
        // langsung hentikan proses dan tampilkan halaman 403 Forbidden.
        if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses Ditolak: Halaman ini hanya untuk nasabah.');
        }
    }

    /**
     * Merender tampilan.
     * Logika di sini sekarang bisa lebih simpel.
     */
    public function render()
    {
        $user = Auth::user();
        $pengajuans = collect(); // Default collection kosong

        // Kita bisa langsung asumsikan user adalah nasabah biasa
        if ($user && $user->nasabah) {
            $pengajuans = $user->nasabah->pengajuanRekening()
                ->latest()
                ->paginate(5);
        }

        return view('livewire.riwayat-pengajuan', [
            'pengajuans' => $pengajuans
        ])
        ->layout('layouts.app');
    }
}