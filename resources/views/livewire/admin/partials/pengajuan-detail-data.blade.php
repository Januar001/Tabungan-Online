<div class="card shadow-sm mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-primary">Data Pemohon (Nasabah)</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3"><strong>Nama Lengkap:</strong><br>{{ $pengajuan->nasabah->nama_lengkap }}</div>
            <div class="col-md-6 mb-3"><strong>Nama Panggilan:</strong><br>{{ $pengajuan->nasabah->nama_panggilan ?? '-' }}</div>
            <div class="col-md-6 mb-3"><strong>Jenis Kelamin:</strong><br>{{ $pengajuan->nasabah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            <div class="col-md-6 mb-3"><strong>Nama Ibu Kandung:</strong><br>{{ $pengajuan->nasabah->nama_ibu_kandung }}</div>
            <div class="col-md-6 mb-3"><strong>Tempat, Tgl Lahir:</strong><br>{{ $pengajuan->nasabah->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuan->nasabah->tanggal_lahir)->format('d F Y') }}</div>
            <div class="col-md-6 mb-3"><strong>Agama:</strong><br>{{ ucfirst($pengajuan->nasabah->agama) }}</div>
            <div class="col-md-6 mb-3"><strong>Status Perkawinan:</strong><br>{{ ucwords(str_replace('_', ' ', $pengajuan->nasabah->status_perkawinan)) }}</div>
            <div class="col-md-6 mb-3"><strong>Pendidikan Terakhir:</strong><br>{{ strtoupper($pengajuan->nasabah->pendidikan_terakhir) }}</div>
            <div class="col-md-6 mb-3"><strong>No. Telepon:</strong><br>{{ $pengajuan->nasabah->no_telepon }}</div>
            <div class="col-md-6 mb-3"><strong>NPWP Pribadi:</strong><br>{{ $pengajuan->nasabah->npwp ?? '-' }}</div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Data Alamat</h6></div>
    <div class="card-body">
        @forelse($pengajuan->nasabah->alamat as $alamat)
            <h6 class="fw-bold">Alamat {{ ucfirst($alamat->jenis_alamat) }}</h6>
            <p class="mb-1">{{ $alamat->alamat_lengkap }}</p>
            <p class="mb-1">Desa/Kel. <strong>{{ $namaDesa[$alamat->id] ?? '...' }}</strong>, Kec. {{ $alamat->kecamatan?->nama ?? 'N/A' }}</p>
            <p class="mb-1">{{ $alamat->kabupaten?->nama ?? 'N/A' }}, PROVINSI {{ $alamat->provinsi?->nama ?? 'N/A' }}</p>
            <p>Kode Pos: {{ $alamat->kode_pos }}</p>
            @if(!$loop->last) <hr> @endif
        @empty
            <p>Data alamat tidak ditemukan.</p>
        @endforelse
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Informasi Pekerjaan & Keuangan</h6></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3"><strong>Pekerjaan:</strong><br>{{ $pengajuan->nasabah->pekerjaan }}</div>
            <div class="col-md-6 mb-3"><strong>Penghasilan/Bulan:</strong><br>{{ $pengajuan->penghasilan_per_bulan }}</div>
            <div class="col-md-6 mb-3"><strong>Sumber Dana:</strong><br>{{ $pengajuan->sumber_dana }}</div>
            <div class="col-md-6 mb-3"><strong>Tujuan Penggunaan:</strong><br>{{ $pengajuan->tujuan_penggunaan }}</div>
        </div>
    </div>
</div>

@if($pengajuan->dataTabunganku)
    {{-- Card untuk DataTabunganKu --}}
@endif
@if($pengajuan->dataBadanUsaha)
    {{-- Card untuk DataBadanUsaha --}}
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Kontak Darurat</h6></div>
    <div class="card-body">
        @forelse($pengajuan->kontakDarurat as $kontak)
            <div class="row">
                <div class="col-md-6 mb-2"><strong>Nama:</strong> {{ $kontak->nama_lengkap }}</div>
                <div class="col-md-6 mb-2"><strong>Hubungan:</strong> {{ $kontak->hubungan }}</div>
                <div class="col-md-6 mb-2"><strong>No. Telepon:</strong> {{ $kontak->no_telepon }}</div>
                <div class="col-md-12"><strong>Alamat:</strong> {{ $kontak->alamat }}</div>
            </div>
            @if(!$loop->last) <hr class="my-3"> @endif
        @empty
            <p>Tidak ada data kontak darurat.</p>
        @endforelse
    </div>
</div>