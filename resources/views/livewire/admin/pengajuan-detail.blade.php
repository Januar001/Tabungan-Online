<div>
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Detail Pengajuan</h1>
            <p class="mb-0">Kode: <strong>{{ $pengajuan->kode_pengajuan }}</strong></p>
        </div>
        <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary" wire:navigate>
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            {{-- Semua card detail informasi nasabah, alamat, dll. letakkan di sini --}}
            {{-- (Kode dari jawaban sebelumnya tidak perlu diubah) --}}
            @include('livewire.admin.partials.pengajuan-detail-data')
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="bi bi-diagram-3-fill me-2"></i>Alur Proses & Aksi
                    </h6>
                </div>
                <div class="card-body">

                    {{-- TAMPILAN JIKA PENGAJUAN DITOLAK --}}
                    @if ($pengajuan->status == 'ditolak')
                        <div class="text-center p-3">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                            <h5 class="mt-3">Pengajuan Ditolak</h5>
                            <p class="text-muted small">
                                Ditolak pada: {{ $pengajuan->updated_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @else
                        {{-- TAMPILAN UNTUK ALUR NORMAL --}}
                        <ul class="timeline-steps">
                            <li class="step-item @if (in_array($pengajuan->status, ['pending', 'diproses'])) is-active @else is-done @endif">
                                <div class="step-marker">1</div>
                                <div class="step-details">
                                    <h6 class="step-title">Pemeriksaan Data</h6>
                                    @if (in_array($pengajuan->status, ['pending', 'diproses']))
                                        <p class="step-description">Admin perlu memeriksa kelengkapan data dan dokumen.
                                        </p>
                                        <div class="d-grid gap-2 mt-3">
                                            <button wire:click="setujui"
                                                wire:confirm="Anda yakin data sudah valid dan ingin MENYETUJUI pengajuan ini?"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Setujui
                                            </button>
                                            <button wire:click="tolak"
                                                wire:confirm="Anda yakin ingin MENOLAK pengajuan ini?"
                                                class="btn btn-sm btn-danger">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                        </div>
                                    @else
                                        <p class="step-description text-success">
                                            <i class="bi bi-check-circle-fill"></i> Data disetujui
                                        </p>
                                    @endif
                                </div>
                            </li>

                            <li
                                class="step-item @if ($pengajuan->status == 'menunggu_pembayaran') is-active @elseif($pengajuan->status == 'aktif') is-done @endif">
                                <div class="step-marker">2</div>
                                <div class="step-details">
                                    <h6 class="step-title">Setoran Awal</h6>
                                    @if ($pengajuan->status == 'menunggu_pembayaran')
                                        <p class="step-description">Menunggu konfirmasi pembayaran setoran awal dari
                                            nasabah.</p>
                                        <div class="d-grid mt-3">
                                            <button wire:click="konfirmasiPembayaran"
                                                wire:confirm="Konfirmasi bahwa pembayaran telah diterima?"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-patch-check-fill"></i> Konfirmasi Pembayaran
                                            </button>
                                        </div>
                                    @elseif($pengajuan->status == 'aktif')
                                        <p class="step-description text-success">
                                            <i class="bi bi-check-circle-fill"></i> Pembayaran dikonfirmasi
                                        </p>
                                    @else
                                        <p class="step-description text-muted">Menunggu persetujuan data.</p>
                                    @endif
                                </div>
                            </li>

                            <li class="step-item @if ($pengajuan->status == 'aktif') is-done @endif">
                                <div class="step-marker">3</div>
                                <div class="step-details">
                                    <h6 class="step-title">Rekening Aktif</h6>
                                    @if ($pengajuan->status == 'aktif')
                                        <p class="step-description text-success">
                                            <i class="bi bi-check-circle-fill"></i> Selesai & Aktif
                                        </p>
                                    @else
                                        <p class="step-description text-muted">Menunggu pembayaran.</p>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Kartu Dokumen Terlampir (tidak berubah) --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="bi bi-paperclip me-2"></i>Dokumen Terlampir</h6>
                </div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @forelse($pengajuan->dokumen as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-truncate"
                                    style="max-width: 200px;">{{ ucwords(str_replace('_', ' ', $doc->jenis_dokumen)) }}</span>
                                {{-- KODE YANG BENAR --}}
                                {{-- SESUDAH --}}
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#dokumenModal"
                                    data-src="{{ route('admin.dokumen.show', ['path' => $doc->path_file]) }}"
                                    data-title="{{ ucwords(str_replace('_', ' ', $doc->jenis_dokumen)) }}"
                                    data-download-url="{{ route('admin.dokumen.show', ['path' => $doc->path_file, 'download' => 'true']) }}">
                                    <i class="bi bi-eye"></i> Lihat
                                </button>
                            </li>
                        @empty
                            <li class="list-group-item">Tidak ada dokumen yang dilampirkan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dokumenModalLabel">Judul Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    {{-- Gambar akan dimuat di sini oleh JavaScript --}}
                    <img id="modalImage" src="" class="img-fluid" alt="Dokumen">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- Tombol download akan memiliki link yang di-set oleh JavaScript --}}
                    <a id="modalDownloadButton" href="#" class="btn btn-primary" download>
                        <i class="bi bi-download"></i> Download File
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS UNTUK TIMELINE --}}
@push('styles')
    <style>
        .timeline-steps {
            list-style: none;
            padding-left: 0;
            position: relative;
        }

        /* Garis vertikal di belakang */
        .timeline-steps::before {
            content: '';
            position: absolute;
            left: 14px;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .step-marker {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #adb5bd;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            z-index: 1;
        }

        .step-details {
            margin-left: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f1f1;
            width: 100%;
        }

        .step-item:last-child .step-details {
            border-bottom: none;
            padding-bottom: 0;
        }

        .step-title {
            font-weight: bold;
        }

        .step-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Styling untuk status */
        .step-item.is-active .step-marker {
            background-color: #0d6efd;
            /* Biru - sedang aktif */
        }

        .step-item.is-active .step-title {
            color: #0d6efd;
        }

        .step-item.is-done .step-marker {
            background-color: #198754;
            /* Hijau - selesai */
            content: '\F26E';
            /* Ganti angka dengan ikon cek dari Bootstrap Icons */
            font-family: 'bootstrap-icons';
            font-size: 1rem;
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dokumenModal = document.getElementById('dokumenModal');
            dokumenModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Tombol yang memicu modal
                const src = button.getAttribute('data-src');
                const title = button.getAttribute('data-title');
                const downloadUrl = button.getAttribute('data-download-url');

                // Set judul modal
                dokumenModal.querySelector('.modal-title').textContent = title;

                // Set gambar
                const modalImage = dokumenModal.querySelector('#modalImage');
                modalImage.src = src;

                // Set link download
                const modalDownloadButton = dokumenModal.querySelector('#modalDownloadButton');
                modalDownloadButton.href = downloadUrl;
            });
        });
    </script>
    
@endpush
