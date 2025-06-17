<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PengajuanRekening;
use App\Models\Nasabah;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    // Properti untuk Statistik
    public $jumlahPengajuan;
    public $pengajuanPending;
    public $jumlahNasabah;
    public $jumlahAktif;

    // Properti untuk Grafik
    public $chartData;

    // Properti untuk Aktivitas Terbaru
    public $pengajuanTerbaru;

    public function mount()
    {
        // Statistik Utama
        $this->jumlahPengajuan = PengajuanRekening::count();
        $this->pengajuanPending = PengajuanRekening::where('status', 'pending')->count();
        $this->jumlahNasabah = Nasabah::count();
        $this->jumlahAktif = PengajuanRekening::where('status', 'aktif')->count();

        // Data untuk Grafik (Pengajuan per hari selama 7 hari terakhir)
        $this->prepareChartData();

        // Aktivitas Terbaru
        $this->pengajuanTerbaru = PengajuanRekening::with('nasabah')
            ->latest()
            ->take(5)
            ->get();
    }

    protected function prepareChartData()
    {
        $pengajuanPerHari = PengajuanRekening::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('count(*) as jumlah')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $labels = [];
        $data = [];

        // Buat label untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('d M');
        }

        // Inisialisasi data dengan 0
        $data = array_fill(0, 7, 0);

        // Isi data dari database
        foreach ($pengajuanPerHari as $item) {
            $date = Carbon::parse($item->tanggal)->format('d M');
            $index = array_search($date, $labels);
            if ($index !== false) {
                $data[$index] = $item->jumlah;
            }
        }
        
        $this->chartData = [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.admin');
    }
}