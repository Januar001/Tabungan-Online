<div>
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Nasabah</h1>
            <p class="text-muted mb-0">Kelola data pusat semua nasabah terdaftar.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" wire:click="openAddModal" data-bs-toggle="modal"
                data-bs-target="#nasabahModal">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Nasabah
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                placeholder="Cari nama atau nomor telepon nasabah...">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Nasabah</th>
                            <th>Kontak</th>
                            <th class="text-center">Jml. Pengajuan</th>
                            <th>Tgl. Bergabung</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nasabahs as $nasabah)
                            <tr wire:key="{{ $nasabah->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle fs-2 text-secondary me-3"></i>
                                        <div>
                                            <a href="{{ route('admin.nasabah.detail', $nasabah) }}" wire:navigate
                                                class="text-decoration-none text-dark">
                                                <h6 class="fw-bold mb-0">{{ $nasabah->nama_lengkap }}</h6>
                                                <small
                                                    class="text-muted">{{ $nasabah->user ? $nasabah->user->email : 'Tidak ada akun' }}</small>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $nasabah->no_telepon }}</td>
                                <td class="text-center">{{ $nasabah->pengajuan_rekening_count }}</td>
                                <td>{{ $nasabah->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><button class="dropdown-item"
                                                    wire:click="openEditModal({{ $nasabah->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#nasabahModal"><i
                                                        class="bi bi-pencil-fill me-2"></i>Edit</button></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><button class="dropdown-item text-danger"
                                                    wire:click="hapusNasabah({{ $nasabah->id }})"
                                                    wire:confirm="ANDA YAKIN? Menghapus nasabah akan menghapus SEMUA data pengajuan terkait."><i
                                                        class="bi bi-trash-fill me-2"></i>Hapus</button></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5">
                                    <i class="bi bi-people-fill fs-1 text-muted"></i>
                                    <h5 class="mt-3">Data Nasabah Tidak Ditemukan</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($nasabahs->hasPages())
            <div class="card-footer bg-transparent border-0 pt-4">{{ $nasabahs->links() }}</div>
        @endif
    </div>

    {{-- Modal Tambah/Edit Nasabah --}}
    <div wire:ignore.self class="modal fade" id="nasabahModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="simpanNasabah">
                    <div class="modal-body">
                        {{-- Form dibuat 2 kolom agar tidak terlalu panjang --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    wire:model="nama_lengkap">
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Panggilan</label>
                                <input type="text" class="form-control" wire:model="nama_panggilan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" wire:model="jenis_kelamin">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ibu Kandung</label>
                                <input type="text"
                                    class="form-control @error('nama_ibu_kandung') is-invalid @enderror"
                                    wire:model="nama_ibu_kandung">
                                @error('nama_ibu_kandung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                    wire:model="no_telepon">
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" wire:model="pekerjaan">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            const nasabahModal = new bootstrap.Modal(document.getElementById('nasabahModal'));
            Livewire.on('close-modal', () => {
                nasabahModal.hide();
            });
        });
    </script>
@endpush
