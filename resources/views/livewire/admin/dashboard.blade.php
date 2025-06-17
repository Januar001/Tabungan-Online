<div>
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="text-muted mb-0">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>
        <div>
            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-text me-2"></i>Lihat Semua Pengajuan
            </a>
        </div>
    </div>

    {{-- Kartu Statistik (4 Kartu) --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $jumlahPengajuan }}</div>
                        </div>
                        <div class="col-auto"><i class="bi bi-journal-text fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Menunggu Persetujuan</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $pengajuanPending }}</div>
                        </div>
                        <div class="col-auto"><i class="bi bi-hourglass-split fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Rekening Aktif</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $jumlahAktif }}</div>
                        </div>
                        <div class="col-auto"><i class="bi bi-patch-check-fill fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Total Nasabah</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $jumlahNasabah }}</div>
                        </div>
                        <div class="col-auto"><i class="bi bi-people-fill fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik dan Aktivitas Terbaru --}}
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-primary">Tren Pengajuan (7 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div wire:ignore>
                        <div id="submissionChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($pengajuanTerbaru as $pengajuan)
                        <a href="{{ route('admin.pengajuan.detail', $pengajuan) }}" wire:navigate class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <div class="fw-bold">{{ $pengajuan->nasabah->nama_lengkap }}</div>
                                <small class="text-muted">Mengajukan {{ $pengajuan->produk }} - {{ $pengajuan->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge rounded-pill 
                                @if($pengajuan->status == 'pending') bg-warning text-dark
                                @else bg-secondary @endif">
                                {{ ucfirst($pengajuan->status) }}
                            </span>
                        </a>
                    @empty
                        <div class="list-group-item">Tidak ada aktivitas terbaru.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card .border-left-primary { border-left: .25rem solid #0d6efd !important; }
    .card .border-left-success { border-left: .25rem solid #198754 !important; }
    .card .border-left-info { border-left: .25rem solid #0dcaf0 !important; }
    .card .border-left-warning { border-left: .25rem solid #ffc107 !important; }
    .text-gray-300 { color: #dee2e6 !important; }
</style>
@endpush

@push('scripts')
{{-- Library ApexCharts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener('livewire:init', () => {
        // Ambil data dari properti publik komponen Livewire
        const chartData = @json($chartData);

        const options = {
            series: [{
                name: 'Jumlah Pengajuan',
                data: chartData.data
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: chartData.labels
            },
            tooltip: {
                x: {
                    format: 'dd MMMM'
                },
            },
        };

        const chart = new ApexCharts(document.querySelector("#submissionChart"), options);
        chart.render();
    });
</script>
@endpush