{{-- File: resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h4 class="mb-0">Dashboard</h4>
                </div>

                <div class="card-body p-4">
                    <p class="fs-5 mb-3">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p class="mb-4">Ini adalah halaman dasbor utama Anda. Dari sini Anda bisa melihat ringkasan aktivitas atau mengakses fitur-fitur lain yang tersedia.</p>
                    <div class="mb-4 text-center">
                        <a href="{{ route('halaman.form') }}" class="btn btn-success btn-lg px-4 py-2 shadow-sm" style="font-size: 1.2rem;">
                            <i class="bi bi-plus-circle me-2"></i> Ajukan Tabungan Baru
                        </a>
                    </div>
                    <hr>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <a href="{{ route('pengajuan.riwayat') }}" class="btn btn-primary">
                            <i class="bi bi-clock-history"></i> Lihat Riwayat Pengajuan
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                            <i class="bi bi-person-fill"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection