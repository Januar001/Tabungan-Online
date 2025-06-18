<div>
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.nasabah.index') }}" class="btn btn-sm btn-outline-secondary mb-2" wire:navigate>
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Nasabah
            </a>
            <h1 class="h3 mb-0">Detail Nasabah</h1>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row gy-4">
        {{-- ====================================================== --}}
        {{-- KOLOM KIRI: PROFIL UTAMA, BIODATA, ALAMAT, AKSI       --}}
        {{-- ====================================================== --}}
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle display-4 text-primary me-3"></i>
                        <div>
                            <h4 class="fw-bold mb-0">{{ $nasabah->nama_lengkap }}</h4>
                            <p class="text-muted mb-0">{{ $nasabah->user->email ?? 'Tidak terhubung ke akun' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" wire:click="openEditModal" data-bs-toggle="modal" data-bs-target="#nasabahModal">
                            <i class="bi bi-pencil-fill me-2"></i>Edit Data Nasabah
                        </button>
                        <button class="btn btn-outline-danger" wire:click="hapusNasabah" wire:confirm="ANDA YAKIN? Menghapus nasabah akan menghapus SEMUA data pengajuan terkait.">
                            <i class="bi bi-trash-fill me-2"></i>Hapus Nasabah
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light"><h6 class="mb-0 fw-bold">Biodata Lengkap</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Nama Panggilan</dt><dd class="col-sm-7">{{ $nasabah->nama_panggilan ?: '-' }}</dd>
                        <dt class="col-sm-5">Jenis Kelamin</dt><dd class="col-sm-7">{{ $nasabah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        <dt class="col-sm-5">Nama Ibu Kandung</dt><dd class="col-sm-7">{{ $nasabah->nama_ibu_kandung }}</dd>
                        <dt class="col-sm-5">Tempat, Tgl Lahir</dt><dd class="col-sm-7">{{ $nasabah->tempat_lahir }}, {{ \Carbon\Carbon::parse($nasabah->tanggal_lahir)->format('d F Y') }}</dd>
                        <dt class="col-sm-5">Agama</dt><dd class="col-sm-7">{{ ucfirst($nasabah->agama) }}</dd>
                        <dt class="col-sm-5">Status Perkawinan</dt><dd class="col-sm-7">{{ ucwords(str_replace('_', ' ', $nasabah->status_perkawinan)) }}</dd>
                        <dt class="col-sm-5">Pendidikan</dt><dd class="col-sm-7">{{ strtoupper($nasabah->pendidikan_terakhir) }}</dd>
                        <dt class="col-sm-5">Pekerjaan</dt><dd class="col-sm-7">{{ $nasabah->pekerjaan }}</dd>
                        <dt class="col-sm-5">No. Telepon</dt><dd class="col-sm-7">{{ $nasabah->no_telepon }}</dd>
                        <dt class="col-sm-5">NPWP</dt><dd class="col-sm-7">{{ $nasabah->npwp ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light"><h6 class="mb-0 fw-bold">Alamat Terdaftar</h6></div>
                <div class="card-body">
                     @forelse($nasabah->alamat as $alamat)
                        <h6 class="fw-bold text-primary">{{ ucfirst($alamat->jenis_alamat) }}</h6>
                        <address class="mb-0">
                            {{ $alamat->alamat_lengkap }}<br>
                            {{ $alamat->kecamatan?->nama ?? 'N/A' }}, {{ $alamat->kabupaten?->nama ?? 'N/A' }}<br>
                            {{ $alamat->provinsi?->nama ?? 'N/A' }} - {{ $alamat->kode_pos }}
                        </address>
                        @if(!$loop->last) <hr> @endif
                    @empty
                        <p class="mb-0 text-muted">Data alamat tidak ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- KOLOM KANAN: RIWAYAT PENGAJUAN (DENGAN ACCORDION)     --}}
        {{-- ====================================================== --}}
        <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                 <h4 class="mb-0">Riwayat Pengajuan</h4>
                 <span class="badge bg-primary rounded-pill">{{ $nasabah->pengajuanRekening->count() }} Pengajuan</span>
            </div>
           
            <div class="accordion" id="riwayatAccordion">
                @forelse ($nasabah->pengajuanRekening as $pengajuan)
                <div class="accordion-item" wire:key="pengajuan-{{ $pengajuan->id }}">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $pengajuan->id }}">
                            <div class="d-flex justify-content-between w-100 pe-3">
                                <span class="fw-bold">{{ $pengajuan->kode_pengajuan }} ({{ ucfirst($pengajuan->produk) }})</span>
                                <span class="badge rounded-pill 
                                    @if($pengajuan->status == 'aktif') bg-success 
                                    @elseif($pengajuan->status == 'ditolak') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst(str_replace('_', ' ', $pengajuan->status)) }}
                                </span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-{{ $pengajuan->id }}" class="accordion-collapse collapse" data-bs-parent="#riwayatAccordion">
                        <div class="accordion-body">
                            <strong>Detail Pengajuan:</strong>
                            <ul>
                                <li>Tanggal: {{ $pengajuan->created_at->format('d M Y') }}</li>
                                <li>Sumber Dana: {{ $pengajuan->sumber_dana }}</li>
                                <li>Tujuan: {{ $pengajuan->tujuan_penggunaan }}</li>
                                <li>Dokumen Terlampir: {{ $pengajuan->dokumen->count() }} file</li>
                            </ul>
                            <a href="{{ route('admin.pengajuan.detail', $pengajuan) }}" class="btn btn-sm btn-outline-primary" wire:navigate>Lihat Detail Pengajuan &rarr;</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center p-5 border rounded bg-light">
                    <p class="mb-0 text-muted">Tidak ada riwayat pengajuan untuk nasabah ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    {{-- Modal Edit Nasabah --}}
    <div wire:ignore.self class="modal fade" id="nasabahModal" tabindex="-1">
       {{-- ... Isi modal sama persis seperti di halaman daftar ... --}}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        const nasabahModal = new bootstrap.Modal(document.getElementById('nasabahModal'));
        Livewire.on('close-modal', () => { nasabahModal.hide(); });
    });
</script>
@endpush