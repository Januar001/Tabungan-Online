<div class="container my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-12">

            <div class="text-center mb-4">
                <h1 class="fw-bold">Cek Status Pengajuan</h1>
                <p class="lead text-muted">Lacak progres pengajuan rekening Anda di sini.</p>
            </div>

            {{-- Form Pencarian - Dibuat lebih responsif --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3 p-md-4">
                    <form wire:submit.prevent="cekStatus" class="d-flex flex-column flex-md-row gap-2">
                        <div class="flex-grow-1">
                            <label for="kodePengajuan" class="form-label visually-hidden">Kode Pengajuan</label>
                            <input type="text" id="kodePengajuan" class="form-control"
                                wire:model="kodePengajuan" placeholder="Masukkan Kode Pengajuan Anda">
                        </div>
                        <div class="flex-grow-1">
                            <label for="noTelepon" class="form-label visually-hidden">Nomor Telepon</label>
                            <input type="text" id="noTelepon" class="form-control"
                                wire:model="noTelepon" placeholder="Masukkan Nomor Telepon Anda">
                        </div>
                        <div class="d-grid d-md-block">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove><i class="bi bi-search"></i> Cek</span>
                                <span wire:loading><span class="spinner-border spinner-border-sm"></span>
                                    Mencari...</span>
                            </button>
                        </div>
                    </form>
                    @error('kodePengajuan')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @error('noTelepon')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @if ($errorMessage)
                        <div class="alert alert-danger mt-3 mb-0">{{ $errorMessage }}</div>
                    @endif
                </div>
            </div>

            {{-- Area Hasil Pengecekan - Dibuat lebih responsif --}}
            @if ($pengajuan)
                <div class="card shadow-sm mt-4">
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-4 g-lg-5">
                            <div class="col-12 col-lg-12 mb-4 mb-lg-0">
                                <div class="mb-4">
                                    <p class="text-muted mb-0">Status Pengajuan untuk:</p>
                                    <h3 class="fw-bold">{{ $pengajuan->nasabah->nama_lengkap }}</h3>
                                    <h5 class="fw-light text-primary">{{ $pengajuan->kode_pengajuan }}</h5>
                                </div>

                                {{-- Blok Instruksi Dinamis --}}
                                @if ($pengajuan->status == 'menunggu_pembayaran')
                                    <div class="alert alert-primary border-0" style="background-color: #cfe2ff;">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-wallet2 fs-2 me-3"></i>
                                            <h4 class="alert-heading mb-0">Lakukan Setoran Awal</h4>
                                        </div>
                                        <p>Selamat! Pengajuan Anda telah disetujui. Langkah terakhir adalah melakukan
                                            setoran awal <b>minimal Rp 50.000</b> untuk mengaktifkan rekening Anda.</p>
                                        <hr>
                                        <p class="fw-bold">Silakan pilih salah satu metode di bawah ini:</p>

                                        <div class="row g-3">
                                            {{-- Kolom untuk Metode Transfer --}}
                                            <div class="col-lg-7">
                                                <h6><i class="bi bi-send-fill"></i> <strong>Metode 1: Transfer
                                                        Bank</strong></h6>
                                                <p class="small text-muted">Anda dapat melakukan transfer ke salah satu
                                                    rekening di bawah ini. Pastikan jumlah yang ditransfer sesuai.</p>

                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="bi bi-bank fs-4 me-3 text-primary"></i>
                                                        <div>
                                                            <strong class="d-block">Bank BCA</strong>
                                                            <span class="text-muted">No. Rekening:</span>
                                                            123-456-7890<br>
                                                            <span class="text-muted">Atas Nama:</span> PT. BPR Maju
                                                            Bersama
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="bi bi-bank fs-4 me-3 text-danger"></i>
                                                        <div>
                                                            <strong class="d-block">Bank BRI</strong>
                                                            <span class="text-muted">No. Rekening:</span>
                                                            098-765-4321<br>
                                                            <span class="text-muted">Atas Nama:</span> PT. BPR Maju
                                                            Bersama
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="bi bi-bank fs-4 me-3 text-warning"></i>
                                                        <div>
                                                            <strong class="d-block">Bank Mandiri</strong>
                                                            <span class="text-muted">No. Rekening:</span>
                                                            555-444-333<br>
                                                            <span class="text-muted">Atas Nama:</span> PT. BPR Maju
                                                            Bersama
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="alert alert-warning small mt-3 p-2">
                                                    <strong>PENTING:</strong> Setelah transfer, mohon kirimkan bukti
                                                    pembayaran ke nomor WhatsApp layanan pelanggan kami agar dapat
                                                    segera diproses.
                                                </div>
                                            </div>  

                                            {{-- Kolom untuk Metode Setor Tunai --}}
                                            <div class="col-lg-5">
                                                <h6><i class="bi bi-building"></i> <strong>Metode 2: Setor
                                                        Tunai</strong></h6>
                                                <p class="small text-muted">Kunjungi kantor cabang kami terdekat dengan
                                                    membawa:</p>
                                                <ul class="list-unstyled">
                                                    <li class="mb-2"><i
                                                            class="bi bi-person-badge text-primary me-2"></i>Kartu
                                                        Identitas (KTP/KIA)</li>
                                                    <li class="mb-2"><i
                                                            class="bi bi-receipt-cutoff text-primary me-2"></i>Kode
                                                        Pengajuan Anda</li>
                                                    <li class="mb-2"><i
                                                            class="bi bi-cash-coin text-primary me-2"></i>Uang setoran
                                                        awal (min. Rp 50.000)</li>
                                                </ul>
                                                <p class="small text-muted mt-3">Sampaikan kepada teller bahwa Anda
                                                    ingin melakukan setoran awal untuk pendaftaran online.</p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($pengajuan->status == 'aktif')
                                    <div class="alert alert-success">
                                        <h5 class="alert-heading"><i class="bi bi-check-circle-fill"></i> Rekening Telah
                                            Aktif!</h5>
                                        <p>Selamat! Rekening Anda sudah aktif. Silakan kunjungi kantor cabang terdekat
                                            untuk pengambilan buku tabungan & kartu ATM.</p>
                                    </div>
                                @elseif($pengajuan->status == 'ditolak')
                                    <div class="alert alert-danger">
                                        <h5 class="alert-heading"><i class="bi bi-x-octagon-fill"></i> Pengajuan Ditolak
                                        </h5>
                                        <p class="mb-0">Mohon maaf, pengajuan Anda belum dapat kami setujui. Hubungi
                                            layanan pelanggan kami untuk informasi lebih lanjut.</p>
                                    </div>
                                @else
                                    <div class="alert alert-light border">
                                        <h5 class="alert-heading"><i class="bi bi-hourglass-split"></i> Sedang Dalam
                                            Proses</h5>
                                        <p class="mb-0">Tim kami sedang melakukan verifikasi data Anda. Terima kasih
                                            telah menunggu.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 col-lg-5">
                                <h5 class="mb-3">Riwayat Proses</h5>
                                <div class="status-timeline">
                                    @php
                                        $statusOrder = [
                                            'pending' => 0,
                                            'diproses' => 0,
                                            'menunggu_pembayaran' => 1,
                                            'aktif' => 2,
                                            'disetujui' => 1,
                                        ]; // disetujui sama dengan menunggu pembayaran
                                        $currentStepIndex = $statusOrder[$pengajuan->status] ?? 0;
                                    @endphp

                                    <div class="step is-complete">
                                        <div class="step-icon"><i class="bi bi-check-lg"></i></div>
                                        <div>
                                            <h6 class="step-title">Pengajuan Diterima</h6>
                                            <p class="step-desc">Formulir telah kami terima.</p>
                                            <p class="step-date">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>

                                    <div
                                        class="step {{ $currentStepIndex >= 1 ? 'is-complete' : '' }} {{ $pengajuan->status == 'ditolak' ? 'is-rejected' : '' }}">
                                        <div class="step-icon">
                                            @if ($pengajuan->status == 'ditolak')
                                                <i class="bi bi-x-lg"></i>
                                            @else
                                                <i class="bi bi-check-lg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="step-title">Verifikasi Data</h6>
                                            @if ($pengajuan->status == 'ditolak')
                                                <p class="step-desc">Pengajuan ditolak oleh sistem.</p>
                                            @elseif($currentStepIndex >= 1)
                                                <p class="step-desc">Data Anda berhasil disetujui.</p>
                                            @else
                                                <p class="step-desc">Menunggu persetujuan admin.</p>
                                            @endif
                                            @if ($currentStepIndex >= 1)
                                                <p class="step-date">{{ $pengajuan->updated_at->format('d M Y, H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="step {{ $currentStepIndex >= 2 ? 'is-complete' : '' }}"
                                        @if ($pengajuan->status == 'ditolak') style="display: none;" @endif>
                                        <div class="step-icon"><i class="bi bi-check-lg"></i></div>
                                        <div>
                                            <h6 class="step-title">Rekening Aktif</h6>
                                            @if ($currentStepIndex >= 2)
                                                <p class="step-desc">Setoran awal dikonfirmasi.</p>
                                                <p class="step-date">
                                                    {{ $pengajuan->updated_at->format('d M Y, H:i') }}</p>
                                            @else
                                                <p class="step-desc">Menunggu setoran awal.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- CSS untuk Progress Tracker (tidak berubah, sudah responsif) --}}
@push('styles')
    <style>
        .status-timeline {
            position: relative;
            padding-left: 40px;
        }

        .status-timeline::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 5px;
            bottom: 5px;
            width: 2px;
            background-color: #e9ecef;
        }

        .status-timeline .step {
            position: relative;
            display: flex;
            gap: 1rem;
            padding-bottom: 2rem;
        }

        .status-timeline .step:last-child {
            padding-bottom: 0;
        }

        .status-timeline .step-icon {
            position: absolute;
            left: -28px;
            top: 0;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: bold;
        }

        .status-timeline .step-title {
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .status-timeline .step-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }

        .status-timeline .step-date {
            font-size: 0.8rem;
            color: #adb5bd;
        }

        .status-timeline .step.is-complete .step-icon {
            background-color: #198754;
        }

        .status-timeline .step.is-complete .step-title {
            color: #198754;
        }

        .status-timeline .step.is-rejected .step-icon {
            background-color: #dc3545;
        }

        .status-timeline .step.is-rejected .step-title {
            color: #dc3545;
        }
    </style>
@endpush
