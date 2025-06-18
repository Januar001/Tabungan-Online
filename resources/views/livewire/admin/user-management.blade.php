<div>
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
            <p class="text-muted mb-0">Kelola pengguna dan level akses aplikasi.</p>
        </div>
        <div>
            {{-- Tombol untuk memicu modal tambah user --}}
            <button type="button" class="btn btn-primary" wire:click="openAddModal" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah User
            </button>
        </div>
    </div>

    {{-- Alert untuk pesan sukses atau error --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        {{-- Header Card: Pencarian --}}
        <div class="card-header bg-light py-3">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Cari nama atau email...">
                </div>
            </div>
        </div>

        {{-- Body Card: Tabel Data --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Tanggal Bergabung</th>
                            <th scope="col" class="text-center">Level Akses</th>
                            <th scope="col" width="200px">Ubah Level</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="bi bi-person-circle fs-2 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($user->isSuperAdmin())
                                        <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Super Admin</span>
                                    @elseif($user->isAdmin())
                                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Admin</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">User</span>
                                    @endif
                                </td>
                                <td class="position-relative">
                                    @if(!$user->isSuperAdmin())
                                        <select class="form-select form-select-sm" 
                                            wire:change="ubahRole({{ $user->id }}, $event.target.value)"
                                            wire:confirm="Anda yakin ingin mengubah level akses untuk '{{ $user->name }}'?">
                                            <option value="{{ \App\Models\User::ROLE_USER }}" @if($user->is_admin == \App\Models\User::ROLE_USER) selected @endif>User</option>
                                            <option value="{{ \App\Models\User::ROLE_ADMIN }}" @if($user->is_admin == \App\Models\User::ROLE_ADMIN) selected @endif>Admin</option>
                                        </select>
                                    @else
                                        <span class="text-muted small d-block text-center">-</span>
                                    @endif
                                    <div wire:loading wire:target="ubahRole({{ $user->id }})" class="position-absolute top-50 start-50 translate-middle">
                                        <div class="spinner-border spinner-border-sm" role="status"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                     @if(!$user->isSuperAdmin())
                                        <button class="btn btn-sm btn-outline-danger" 
                                            wire:click="hapusUser({{ $user->id }})" 
                                            wire:confirm="ANDA YAKIN? Menghapus user '{{ $user->name }}' tidak bisa dibatalkan.">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                     @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="text-center p-5">
                                        <i class="bi bi-people-fill fs-1 text-muted"></i>
                                        <h5 class="mt-3">User Tidak Ditemukan</h5>
                                        <p class="text-muted">Tidak ada data user yang cocok dengan pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="card-footer bg-transparent border-0 pt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
    
    {{-- =============================================== --}}
    {{--         MODAL UNTUK TAMBAH/EDIT USER            --}}
    {{-- =============================================== --}}
    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">{{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="simpanUser">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model="email">
                             @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model="password">
                             @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                         <div class="mb-3">
                            <label for="is_admin" class="form-label">Level Akses</label>
                            <select class="form-select @error('is_admin') is-invalid @enderror" id="is_admin" wire:model="is_admin">
                                <option value="">Pilih Level</option>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                             @error('is_admin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="simpanUser">Simpan</span>
                            <span wire:loading wire:target="simpanUser">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .avatar { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Dijalankan saat event 'close-modal' diterima dari server
        Livewire.on('close-modal', (event) => {
            // Ambil instance modal bootstrap dari ID modalnya
            var userModal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
            if(userModal) {
                 // Tutup modal
                userModal.hide();
            }
        });
    });
</script>
@endpush