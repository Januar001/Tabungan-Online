<div>
    <h1 class="h3 mb-4 text-gray-800">Daftar Pengajuan Rekening</h1>

    <div class="card shadow-sm">
        {{-- Header Card: Filter dan Pencarian --}}
        <div class="card-header bg-light py-3">
            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                        placeholder="Cari kode atau nama...">
                </div>
                <div class="col-md-3 col-lg-2">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach ($listStatus as $status)
                            <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select wire:model.live="filterProduk" class="form-select">
                        <option value="">Semua Produk</option>
                        @foreach ($listProduk as $produk)
                            <option value="{{ $produk }}">{{ ucfirst($produk) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Body Card: Tabel Data --}}
        <div class="card-body">
            {{-- Informasi Jumlah Data & Paginasi --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted small mb-0">
                    Menampilkan {{ $pengajuans->firstItem() }} sampai {{ $pengajuans->lastItem() }} dari
                    {{ $pengajuans->total() }} hasil
                </p>
            </div>

            <div class="table-responsive" style="padding-bottom: 10%">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nasabah</th>
                            <th scope="col">Detail Pengajuan</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $pengajuan)
                            <tr wire:key="{{ $pengajuan->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="bi bi-person-circle fs-2 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $pengajuan->nasabah->nama_lengkap }}</h6>
                                            <small class="text-muted">{{ $pengajuan->nasabah->no_telepon }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $pengajuan->kode_pengajuan }}</span><br>
                                    <small class="text-muted">
                                        Produk: <span
                                            class="badge {{ $pengajuan->produk == 'simade' ? 'bg-primary-subtle text-primary-emphasis' : 'bg-info-subtle text-info-emphasis' }}">{{ ucfirst($pengajuan->produk) }}</span>
                                        | Tgl: {{ $pengajuan->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <span
                                        class="badge rounded-pill fs-6
                                        @if ($pengajuan->status == 'pending') bg-warning text-dark
                                        @elseif($pengajuan->status == 'menunggu_pembayaran') bg-info text-dark
                                        @elseif($pengajuan->status == 'aktif' || $pengajuan->status == 'disetujui') bg-success
                                        @elseif($pengajuan->status == 'ditolak') bg-danger 
                                        @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ', $pengajuan->status)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.pengajuan.detail', $pengajuan) }}"
                                                    wire:navigate>
                                                    <i class="bi bi-eye me-2"></i>Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-danger"
                                                    wire:click="hapusPengajuan({{ $pengajuan->id }})"
                                                    wire:confirm="Anda yakin ingin menghapus pengajuan dengan kode '{{ $pengajuan->kode_pengajuan }}'? Aksi ini tidak bisa dibatalkan.">
                                                    <i class="bi bi-trash-fill me-2"></i>Hapus Pengajuan
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center p-5">
                                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                                        <h5 class="mt-3">Data Tidak Ditemukan</h5>
                                        <p class="text-muted">Tidak ada data yang cocok dengan filter atau pencarian
                                            Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Card: Paginasi --}}
            @if ($pengajuans->hasPages())
                <div class="card-footer bg-light border-0 pt-4">
                    {{ $pengajuans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        .avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush
