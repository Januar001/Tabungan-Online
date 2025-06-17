<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            
            {{-- Header Halaman --}}
            <div class="text-center text-md-start mb-4">
                <h1 class="h2 fw-bold mb-0">Riwayat Pengajuan Saya</h1>
                <p class="text-muted">Lacak semua progres pengajuan rekening Anda di sini.</p>
            </div>

            {{-- Daftar Pengajuan --}}
            @forelse($pengajuans as $pengajuan)
                <div class="card shadow-sm mb-4" wire:key="{{ $pengajuan->id }}">
                    <div class="card-body p-4">
                        <div class="row gy-4">
                            
                            {{-- KOLOM KIRI: DETAIL UTAMA & INSTRUKSI --}}
                            <div class="col-lg-7">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                    <div>
                                        <h5 class="fw-bold text-primary mb-0">{{ $pengajuan->kode_pengajuan }}</h5>
                                        <small class="text-muted">Tgl: {{ $pengajuan->created_at->format('d F Y') }}</small>
                                    </div>
                                    <span class="badge rounded-pill fs-6 px-3 py-2
                                        @if($pengajuan->status == 'pending') bg-warning text-dark
                                        @elseif($pengajuan->status == 'menunggu_pembayaran') bg-info text-dark
                                        @elseif($pengajuan->status == 'aktif' || $pengajuan->status == 'disetujui') bg-success
                                        @elseif($pengajuan->status == 'ditolak') bg-danger 
                                        @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ',$pengajuan->status)) }}
                                    </span>
                                </div>
                                <p class="mb-2"><strong>Produk Diajukan:</strong> {{ ucfirst($pengajuan->produk) }}</p>
                                
                                {{-- Keterangan / Instruksi Tambahan --}}
                                @if($pengajuan->status == 'menunggu_pembayaran')
                                    <div class="alert alert-primary p-2 mt-3 small">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <strong>Langkah Selanjutnya:</strong> Lakukan setoran awal untuk mengaktifkan rekening Anda.
                                    </div>
                                @elseif($pengajuan->status == 'aktif')
                                     <div class="alert alert-success p-2 mt-3 small">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <strong>Selesai:</strong> Rekening Anda telah aktif dan siap digunakan.
                                    </div>
                                @endif
                            </div>

                            {{-- KOLOM KANAN: TIMELINE STATUS --}}
                            <div class="col-lg-5 border-start-lg">
                                <div class="ps-lg-4">
                                    <div class="status-timeline-sm">
                                        @php
                                            $statusOrder = ['pending' => 0, 'diproses' => 0, 'menunggu_pembayaran' => 1, 'aktif' => 2, 'disetujui' => 1];
                                            $currentStepIndex = $statusOrder[$pengajuan->status] ?? 0;
                                        @endphp

                                        <div class="step {{ $currentStepIndex >= 0 ? 'is-complete' : '' }}">
                                            <div class="step-icon"><i class="bi bi-check"></i></div>
                                            <div class="step-label">Diajukan</div>
                                        </div>
                                        <div class="step {{ $currentStepIndex >= 1 ? 'is-complete' : '' }} {{ $pengajuan->status == 'ditolak' ? 'is-rejected' : '' }}">
                                            <div class="step-icon">
                                                @if($pengajuan->status == 'ditolak') <i class="bi bi-x"></i> @else <i class="bi bi-check"></i> @endif
                                            </div>
                                            <div class="step-label">{{ $pengajuan->status == 'ditolak' ? 'Ditolak' : 'Disetujui' }}</div>
                                        </div>
                                        <div class="step {{ $currentStepIndex >= 2 ? 'is-complete' : '' }}" @if($pengajuan->status == 'ditolak') style="visibility: hidden;"@endif>
                                            <div class="step-icon"><i class="bi bi-check"></i></div>
                                            <div class="step-label">Aktif</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika belum ada pengajuan --}}
                <div class="text-center py-5 border rounded bg-white shadow-sm">
                    <img src="https://via.placeholder.com/150/E9ECEF/6C757D?text=BPR" alt="Icon" class="mb-4 rounded-circle">
                    <h3 class="fw-bold">Anda Belum Memiliki Pengajuan</h4>
                    <p class="text-muted">Mulailah perjalanan finansial Anda bersama kami sekarang.</p>
                    <a href="{{ route('halaman.form') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-2"></i>Buat Pengajuan Pertama Anda
                    </a>
                </div>
            @endforelse

            {{-- Link Paginasi --}}
            @if($pengajuans->hasPages())
                <div class="mt-4">
                    {{ $pengajuans->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

@push('styles')
<style>
.status-timeline-sm {
    position: relative;
    padding-left: 30px;
}
.status-timeline-sm::before {
    content: ''; position: absolute; left: 9px; top: 0; bottom: 0; width: 2px; background-color: #e9ecef;
}
.status-timeline-sm .step {
    position: relative; display: flex; align-items: center; padding-bottom: 1.25rem;
}
.status-timeline-sm .step:last-child {
    padding-bottom: 0;
}
.status-timeline-sm .step-icon {
    position: absolute; left: -21px; width: 20px; height: 20px; border-radius: 50%;
    background-color: #e9ecef; color: white; display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; font-weight: bold; border: 2px solid #f8f9fa;
}
.status-timeline-sm .step-label { font-size: 0.9rem; font-weight: 500; color: #6c757d; }
/* Status Complete */
.status-timeline-sm .step.is-complete .step-icon { background-color: #198754; }
.status-timeline-sm .step.is-complete .step-label { color: #212529; font-weight: 600; }
/* Status Rejected */
.status-timeline-sm .step.is-rejected .step-icon { background-color: #dc3545; }
.status-timeline-sm .step.is-rejected .step-label { color: #dc3545; font-weight: 600; }
/* Border helper untuk mobile */
@media (min-width: 992px) {
    .border-start-lg { border-left: 1px solid #dee2e6 !important; }
}
</style>
@endpush