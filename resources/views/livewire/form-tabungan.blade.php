<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form wire:submit="submit" enctype="multipart/form-data">
                <div class="form-container">
                    <!-- Form Header with Step Indicator -->
                    <div class="form-header">
                        <h2>Pembukaan Rekening Tabungan {{ ucfirst($product) }}</h2>
                        <div class="step-indicator">
                            @foreach (range(1, $totalSteps) as $step)
                                <div class="step 
                                {{ $currentStep == $step ? 'active' : '' }}
                                {{ $currentStep > $step ? 'completed' : '' }}"
                                    wire:click="goToStep({{ $step }})" style="cursor: pointer;">
                                    {{ $step }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 1: Pilih Produk -->
                    <div class="form-section {{ $currentStep == 1 ? 'active' : '' }}" id="section1">
                        <h4 class="mb-4 text-center">Pilih Jenis Tabungan</h4>
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-4">
                                <div class="product-card shadow-sm border rounded-4 p-3 h-100 position-relative bg-gradient
                                    {{ $product == 'tabunganku' ? 'selected border-primary bg-primary-subtle' : 'border-light bg-white' }}"
                                    wire:click="selectProduct('tabunganku')" data-product="tabunganku"
                                    style="transition: box-shadow .2s, background .3s;">
                                    <input type="radio" class="d-none" id="productTabunganku" value="tabunganku"
                                        wire:model.live="product">
                                    <label for="productTabunganku" class="w-100 h-100 m-0 p-0 d-block">
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('assets/img/tabunganku.png') }}" alt="TabunganKu"
                                                class="img-fluid product-img
                                                {{ $product == 'tabunganku' ? 'img-selected' : '' }}"
                                                style="max-height:80px; transition: transform .3s;">
                                        </div>
                                        <h5 class="fw-bold text-primary text-center">TabunganKu</h5>
                                        <p class="small text-center mb-2">Khusus untuk pelajar/mahasiswa usia 7-17 tahun</p>
                                        <ul class="text-muted small ps-3">
                                            <li>Bebas biaya admin</li>
                                            <li>Kartu debit khusus pelajar</li>
                                            <li>Buku tabungan digital</li>
                                        </ul>
                                        @if ($product == 'tabunganku')
                                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">Dipilih</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-5 mb-4">
                                <div class="product-card shadow-sm border rounded-4 p-3 h-100 position-relative bg-gradient
                                    {{ $product == 'simade' ? 'selected border-success bg-success-subtle' : 'border-light bg-white' }}"
                                    wire:click="selectProduct('simade')" data-product="simade"
                                    style="transition: box-shadow .2s, background .3s;">
                                    <input type="radio" class="d-none" id="productSimade" value="simade"
                                        wire:model.live="product">
                                    <label for="productSimade" class="w-100 h-100 m-0 p-0 d-block">
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('assets/img/simade.jpg') }}" alt="SIMADE"
                                                class="img-fluid product-img
                                                {{ $product == 'simade' ? 'img-selected' : '' }}"
                                                style="max-height:80px; transition: transform .3s;">
                                        </div>
                                        <h5 class="fw-bold text-success text-center">SIMADE</h5>
                                        <p class="small text-center mb-2">Untuk perorangan dan badan usaha</p>
                                        <ul class="text-muted small ps-3">
                                            <li>Bunga kompetitif</li>
                                            <li>Kartu debit premium</li>
                                            <li>Akses mobile banking</li>
                                        </ul>
                                        @if ($product == 'simade')
                                            <span class="badge bg-success position-absolute top-0 end-0 m-2">Dipilih</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if ($product == 'simade')
                            <hr>
                            <h5 class="mb-3 text-center">Pilih Jenis SIMADE</h5>
                            <div class="d-flex justify-content-center gap-4 mb-4">
                                <div class="simade-type-card {{ $simadeType == 'perorangan' ? 'active' : '' }}"
                                    wire:click="$set('simadeType', 'perorangan')" style="cursor:pointer;">
                                    <input class="form-check-input d-none" type="radio" wire:model.live="simadeType"
                                        name="simadeType" id="simadePersonal" value="perorangan">
                                    <label class="form-check-label w-100 h-100 d-block text-center p-3" for="simadePersonal">
                                        <i class="fas fa-user fa-2x mb-2 text-primary"></i>
                                        <div class="fw-bold mt-2">Perorangan</div>
                                    </label>
                                </div>
                                <div class="simade-type-card {{ $simadeType == 'badan_usaha' ? 'active' : '' }}"
                                    wire:click="$set('simadeType', 'badan_usaha')" style="cursor:pointer;">
                                    <input class="form-check-input d-none" type="radio" wire:model.live="simadeType"
                                        name="simadeType" id="simadeBusiness" value="badan_usaha">
                                    <label class="form-check-label w-100 h-100 d-block text-center p-3" for="simadeBusiness">
                                        <i class="fas fa-building fa-2x mb-2 text-success"></i>
                                        <div class="fw-bold mt-2">Badan Usaha</div>
                                    </label>
                                </div>
                            </div>

                        @endif

                        <div class="form-navigation text-center">
                            <button type="button" class="btn btn-primary px-5" wire:click="nextStep">Selanjutnya</button>
                        </div>
                    </div>

                    <!-- Step 2: Data Pribadi -->
                    <div class="form-section {{ $currentStep == 2 ? 'active' : '' }}" id="section2">
                        <h4 class="mb-4">Data Pribadi</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="namaLengkap" class="form-label required-field">Nama Lengkap</label>
                                    <input type="text"
                                        class="form-control @error('dataPribadi.namaLengkap') is-invalid @enderror"
                                        id="namaLengkap" wire:model.blur="dataPribadi.namaLengkap" required>
                                    @error('dataPribadi.namaLengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="namaPanggilan" class="form-label">Nama Panggilan/Alias</label>
                                    <input type="text" class="form-control" id="namaPanggilan"
                                        wire:model.blur="dataPribadi.namaPanggilan">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required-field">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                wire:model.blur="dataPribadi.jenisKelamin" name="jenisKelamin"
                                                id="lakiLaki" value="L">
                                            <label class="form-check-label" for="lakiLaki">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                wire:model.blur="dataPribadi.jenisKelamin" name="jenisKelamin"
                                                id="perempuan" value="P">
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                    @error('dataPribadi.jenisKelamin')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="namaIbu" class="form-label required-field">Nama Ibu Kandung</label>
                                    <input type="text"
                                        class="form-control @error('dataPribadi.namaIbu') is-invalid @enderror"
                                        id="namaIbu" wire:model.blur="dataPribadi.namaIbu" required>
                                    @error('dataPribadi.namaIbu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempatLahir" class="form-label required-field">Tempat Lahir</label>
                                    <input type="text"
                                        class="form-control @error('dataPribadi.tempatLahir') is-invalid @enderror"
                                        id="tempatLahir" wire:model.blur="dataPribadi.tempatLahir" required>
                                    @error('dataPribadi.tempatLahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggalLahir" class="form-label required-field">Tanggal Lahir</label>
                                    <input type="date"
                                        class="form-control @error('dataPribadi.tanggalLahir') is-invalid @enderror"
                                        id="tanggalLahir" wire:model.blur="dataPribadi.tanggalLahir" required>
                                    @error('dataPribadi.tanggalLahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="agama" class="form-label required-field">Agama</label>
                                    <select class="form-select @error('dataPribadi.agama') is-invalid @enderror"
                                        id="agama" wire:model.blur="dataPribadi.agama" required>
                                        <option value="" selected disabled>Pilih Agama</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="buddha">Buddha</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    @error('dataPribadi.agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pendidikan" class="form-label required-field">Pendidikan
                                        Terakhir</label>
                                    <select class="form-select @error('dataPribadi.pendidikan') is-invalid @enderror"
                                        id="pendidikan" wire:model.blur="dataPribadi.pendidikan" required>
                                        <option value="" selected disabled>Pilih Pendidikan</option>
                                        <option value="sd">SD</option>
                                        <option value="smp">SMP</option>
                                        <option value="sma">SMA/SMK</option>
                                        @if ($product !== 'tabunganku')
                                            <option value="diploma">Diploma</option>
                                            <option value="s1">S1</option>
                                            <option value="s2">S2</option>
                                            <option value="s3">S3</option>
                                        @endif
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    @error('dataPribadi.pendidikan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenisIdentitas" class="form-label required-field">Jenis
                                        Identitas</label>
                                    <select
                                        class="form-select @error('dataPribadi.jenisIdentitas') is-invalid @enderror"
                                        id="jenisIdentitas" wire:model.blur="dataPribadi.jenisIdentitas" required>
                                        @if ($product == 'tabunganku')
                                            <option value="" selected disabled>Pilih Identitas</option>
                                            <option value="kartu_pelajar">Kartu Pelajar/Mahasiswa</option>
                                        @else
                                            <option value="" selected disabled>Pilih Identitas</option>
                                            <option value="ktp">KTP</option>
                                            <option value="kartu_pelajar">Kartu Pelajar/Mahasiswa</option>
                                            <option value="paspor">Paspor</option>
                                            <option value="sim">SIM</option>
                                            <option value="lainnya">Lainnya</option>
                                        @endif
                                    </select>
                                    @error('dataPribadi.jenisIdentitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="noIdentitas" class="form-label required-field">Nomor Identitas</label>
                                    <input type="text"
                                        class="form-control @error('dataPribadi.noIdentitas') is-invalid @enderror"
                                        id="noIdentitas" wire:model.blur="dataPribadi.noIdentitas" required>
                                    @error('dataPribadi.noIdentitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label required-field">Provinsi</label>
                                    <select id="provinsi" wire:model.live="selectedProvinsi"
                                        class="form-select @error('selectedProvinsi') is-invalid @enderror" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsi as $p)
                                            <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedProvinsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if (!empty($selectedProvinsi))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kabupaten"
                                            class="form-label required-field">Kabupaten/Kota</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <select id="kabupaten" wire:model.live="selectedKabupaten"
                                                class="form-select @error('selectedKabupaten') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                                @foreach ($kabupaten as $k)
                                                    <option value="{{ $k['id'] }}">{{ $k['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('selectedKabupaten')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            @if (!empty($selectedKabupaten))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label required-field">Kecamatan</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <select id="kecamatan" wire:model.live="selectedKecamatan"
                                                class="form-select @error('selectedKecamatan') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach ($kecamatan as $kec)
                                                    <option value="{{ $kec['id'] }}">{{ $kec['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('selectedKecamatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            @if (!empty($selectedKecamatan))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="desa" class="form-label required-field">Desa/Kelurahan</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <select id="desa" wire:model.live="selectedDesa"
                                                class="form-select @error('selectedDesa') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Desa/Kelurahan --</option>
                                                @foreach ($desa as $d)
                                                    <option value="{{ $d['id'] }}">{{ $d['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('selectedDesa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="alamatIdentitas" class="form-label required-field">Alamat (Sesuai
                                Identitas)</label>
                            <textarea class="form-control @error('dataPribadi.alamatIdentitas') is-invalid @enderror" id="alamatIdentitas"
                                rows="3" wire:model.blur="dataPribadi.alamatIdentitas" required></textarea>
                            @error('dataPribadi.alamatIdentitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kodePos" class="form-label required-field">Kode Pos</label>
                                    <input type="text"
                                        class="form-control @error('dataPribadi.kodePos') is-invalid @enderror"
                                        id="kodePos" wire:model.blur="dataPribadi.kodePos" required>
                                    @error('dataPribadi.kodePos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="noTelp" class="form-label required-field">No. Telepon</label>
                                    <input type="text"
                                        class="form-control @error('dataPribadi.noTelp') is-invalid @enderror"
                                        id="noTelp" wire:model.blur="dataPribadi.noTelp" required>
                                    @error('dataPribadi.noTelp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label required-field">Status Perkawinan</label>
                                    <select class="form-select @error('dataPribadi.status') is-invalid @enderror"
                                        id="status" wire:model.blur="dataPribadi.status" required>
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="belum_menikah">Belum Menikah</option>
                                        @if ($product !== 'tabunganku')
                                            <option value="menikah">Menikah</option>
                                            <option value="janda">Janda</option>
                                            <option value="duda">Duda</option>
                                        @endif
                                    </select>
                                    @error('dataPribadi.status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="npwp" class="form-label">NPWP</label>
                                    <input type="text" class="form-control" id="npwp"
                                        wire:model.blur="dataPribadi.npwp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label required-field">Pekerjaan</label>
                                    <select class="form-select @error('dataPribadi.pekerjaan') is-invalid @enderror"
                                        id="pekerjaan" wire:model.blur="dataPribadi.pekerjaan" required>
                                        @if ($product == 'tabunganku')
                                            <option value="" selected disabled>Pilih Pekerjaan</option>
                                            <option value="pelajar_mahasiswa">Pelajar/Mhs</option>
                                        @else
                                            <option value="" selected disabled>Pilih Pekerjaan</option>
                                            <option value="pegawai_negeri">Pegawai Negeri</option>
                                            <option value="pegawai_swasta">Pegawai Swasta</option>
                                            <option value="wiraswasta">Wiraswasta</option>
                                            <option value="profesional">Profesional</option>
                                            <option value="pensiunan">Pensiunan</option>
                                            <option value="tni_polri">TNI/Polri</option>
                                            <option value="pelajar_mahasiswa">Pelajar/Mhs</option>
                                            <option value="lainnya">Lainnya</option>
                                        @endif
                                    </select>
                                    @error('dataPribadi.pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="penghasilan" class="form-label required-field">Penghasilan Per
                                        Bulan</label>
                                    <select class="form-select @error('dataPribadi.penghasilan') is-invalid @enderror"
                                        id="penghasilan" wire:model.blur="dataPribadi.penghasilan" required>
                                        <option value="" selected disabled>Pilih Penghasilan</option>
                                        <option value="<1jt">&lt; Rp1.000.000</option>
                                        <option value="1-3jt">Rp1.000.000 - Rp3.000.000</option>
                                        <option value="3-5jt">Rp3.000.000 - Rp5.000.000</option>
                                        <option value="5-10jt">Rp5.000.000 - Rp10.000.000</option>
                                        <option value=">10jt">&gt; Rp10.000.000</option>
                                    </select>
                                    @error('dataPribadi.penghasilan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sumberDana" class="form-label required-field">Sumber Dana</label>
                                    <select class="form-select @error('dataPribadi.sumberDana') is-invalid @enderror"
                                        id="sumberDana" wire:model.blur="dataPribadi.sumberDana" required>
                                        <option value="" selected disabled>Pilih Sumber Dana</option>
                                        <option value="penghasilan">Penghasilan</option>
                                        <option value="warisan">Warisan</option>
                                        <option value="hibah">Hibah</option>
                                        <option value="undian">Undian</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    @error('dataPribadi.sumberDana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tujuanPenggunaanDana" class="form-label required-field">Tujuan Penggunaan
                                Dana</label>
                            <input type="text"
                                class="form-control @error('dataPribadi.tujuanPenggunaanDana') is-invalid @enderror"
                                id="tujuanPenggunaanDana" wire:model.blur="dataPribadi.tujuanPenggunaanDana" required>
                            @error('dataPribadi.tujuanPenggunaanDana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn btn-outline-primary"
                                wire:click="prevStep">Sebelumnya</button>
                            <button type="button" class="btn btn-primary" wire:click="nextStep">Selanjutnya</button>
                        </div>
                    </div>

                    <!-- Step 3: Data Tambahan -->
                    <div class="form-section {{ $currentStep == 3 ? 'active' : '' }}" id="section3">
                        <h4 class="mb-4">Data Tambahan</h4>

                        <div id="data-tambahan-container">
                            @if ($product === 'tabunganku')
                                <h5 class="mb-3">Data Sekolah</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="namaSekolah" class="form-label required-field">Nama
                                                Sekolah</label>
                                            <input type="text"
                                                class="form-control @error('dataTabunganku.namaSekolah') is-invalid @enderror"
                                                id="namaSekolah" wire:model.blur="dataTabunganku.namaSekolah" required>
                                            @error('dataTabunganku.namaSekolah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kelas" class="form-label required-field">Kelas</label>
                                            <input type="text"
                                                class="form-control @error('dataTabunganku.kelas') is-invalid @enderror"
                                                id="kelas" wire:model.blur="dataTabunganku.kelas" required>
                                            @error('dataTabunganku.kelas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mt-4">Data Wali</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="namaWali" class="form-label required-field">Nama Wali</label>
                                            <input type="text"
                                                class="form-control @error('dataTabunganku.namaWali') is-invalid @enderror"
                                                id="namaWali" wire:model.blur="dataTabunganku.namaWali" required>
                                            @error('dataTabunganku.namaWali')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="noIdentitasWali" class="form-label required-field">No.
                                                Identitas
                                                Wali</label>
                                            <input type="text"
                                                class="form-control @error('dataTabunganku.noIdentitasWali') is-invalid @enderror"
                                                id="noIdentitasWali" wire:model.blur="dataTabunganku.noIdentitasWali" required>
                                            @error('dataTabunganku.noIdentitasWali')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="hubunganWali" class="form-label required-field">Hubungan dengan
                                        Wali</label>
                                    <input type="text"
                                        class="form-control @error('dataTabunganku.hubunganWali') is-invalid @enderror"
                                        id="hubunganWali" wire:model.blur="dataTabunganku.hubunganWali" required>
                                    @error('dataTabunganku.hubunganWali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @elseif($product === 'simade' && $simadeType === 'badan_usaha')
                                <h5 class="mb-3">Data Perusahaan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="namaPerusahaan" class="form-label required-field">Nama
                                                Perusahaan</label>
                                            <input type="text"
                                                class="form-control @error('badanUsaha.namaPerusahaan') is-invalid @enderror"
                                                id="namaPerusahaan" wire:model.blur="badanUsaha.namaPerusahaan" required>
                                            @error('badanUsaha.namaPerusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="noAktaPendirian" class="form-label">No. Akta Pendirian</label>
                                            <input type="text" class="form-control" id="noAktaPendirian"
                                                wire:model.blur="badanUsaha.noAktaPendirian">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="noIzinUsaha" class="form-label">No. Izin Usaha</label>
                                            <input type="text" class="form-control" id="noIzinUsaha"
                                                wire:model.blur="badanUsaha.noIzinUsaha">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="npwpPerusahaan" class="form-label required-field">NPWP
                                                Perusahaan</label>
                                            <input type="text"
                                                class="form-control @error('badanUsaha.npwpPerusahaan') is-invalid @enderror"
                                                id="npwpPerusahaan" wire:model.blur="badanUsaha.npwpPerusahaan" required>
                                            @error('badanUsaha.npwpPerusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="namaPengurus" class="form-label required-field">Nama
                                                Pengurus</label>
                                            <input type="text"
                                                class="form-control @error('badanUsaha.namaPengurus') is-invalid @enderror"
                                                id="namaPengurus" wire:model.blur="badanUsaha.namaPengurus" required>
                                            @error('badanUsaha.namaPengurus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jabatan" class="form-label required-field">Jabatan</label>
                                            <input type="text"
                                                class="form-control @error('badanUsaha.jabatan') is-invalid @enderror"
                                                id="jabatan" wire:model.blur="badanUsaha.jabatan" required>
                                            @error('badanUsaha.jabatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="noTelpPerusahaan" class="form-label required-field">No.
                                                Telepon
                                                Perusahaan</label>
                                            <input type="text"
                                                class="form-control @error('badanUsaha.noTelpPerusahaan') is-invalid @enderror"
                                                id="noTelpPerusahaan" wire:model.blur="badanUsaha.noTelpPerusahaan" required>
                                            @error('badanUsaha.noTelpPerusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bidangUsaha" class="form-label required-field">Bidang
                                                Usaha</label>
                                            <input type="text"
                                                class="form-control @error('badanUsaha.bidangUsaha') is-invalid @enderror"
                                                id="bidangUsaha" wire:model.blur="badanUsaha.bidangUsaha" required>
                                            @error('badanUsaha.bidangUsaha')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Upload Dokumen --}}
                        <h5 class="mt-4">Upload Dokumen</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fileIdentitas" class="form-label required-field">Foto/Scan
                                        Identitas</label>
                                    <input type="file"
                                        class="form-control @error('fileIdentitas') is-invalid @enderror"
                                        id="fileIdentitas" wire:model="fileIdentitas" accept="image/*,.pdf">
                                    @error('fileIdentitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($fileIdentitas)
                                        <div class="mt-2">
                                            @if (Str::endsWith(strtolower($fileIdentitas->getClientOriginalName()), [
                                                    '.jpg',
                                                    '.jpeg',
                                                    '.png',
                                                    '.gif',
                                                    '.bmp',
                                                    '.webp',
                                                ]))
                                                <img src="{{ $fileIdentitas->temporaryUrl() }}"
                                                    alt="Preview Identitas" class="img-thumbnail"
                                                    style="max-height: 180px;">
                                            @else
                                                <a href="{{ $fileIdentitas->temporaryUrl() }}" target="_blank">Lihat
                                                    Dokumen</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fileSelfie" class="form-label required-field">Foto Selfie dengan
                                        Identitas</label>
                                    <input type="file"
                                        class="form-control @error('fileSelfie') is-invalid @enderror"
                                        id="fileSelfie" wire:model="fileSelfie" accept="image/*">
                                    @error('fileSelfie')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($fileSelfie)
                                        <div class="mt-2">
                                            <img src="{{ $fileSelfie->temporaryUrl() }}" alt="Preview Selfie"
                                                class="img-thumbnail" style="max-height: 180px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($product === 'simade' && $simadeType === 'badan_usaha')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fileAkta" class="form-label required-field">Akta Pendirian
                                            Perusahaan</label>
                                        <input type="file"
                                            class="form-control @error('fileAkta') is-invalid @enderror"
                                            id="fileAkta" wire:model="fileAkta" accept="image/*,.pdf">
                                        @error('fileAkta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($fileAkta)
                                            <div class="mt-2">
                                                @if (Str::endsWith(strtolower($fileAkta->getClientOriginalName()), ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp']))
                                                    <img src="{{ $fileAkta->temporaryUrl() }}" alt="Preview Akta"
                                                        class="img-thumbnail" style="max-height: 180px;">
                                                @else
                                                    <a href="{{ $fileAkta->temporaryUrl() }}" target="_blank">Lihat
                                                        Dokumen</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fileNpwp" class="form-label required-field">NPWP
                                            Perusahaan</label>
                                        <input type="file"
                                            class="form-control @error('fileNpwp') is-invalid @enderror"
                                            id="fileNpwp" wire:model="fileNpwp" accept="image/*,.pdf">
                                        @error('fileNpwp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($fileNpwp)
                                            <div class="mt-2">
                                                @if (Str::endsWith(strtolower($fileNpwp->getClientOriginalName()), ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp']))
                                                    <img src="{{ $fileNpwp->temporaryUrl() }}" alt="Preview NPWP"
                                                        class="img-thumbnail" style="max-height: 180px;">
                                                @else
                                                    <a href="{{ $fileNpwp->temporaryUrl() }}" target="_blank">Lihat
                                                        Dokumen</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <h5 class="mt-4">Kontak Darurat</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="namaKontakDarurat" class="form-label required-field">Nama
                                        Lengkap</label>
                                    <input type="text"
                                        class="form-control @error('namaKontakDarurat') is-invalid @enderror"
                                        id="namaKontakDarurat" wire:model.blur="namaKontakDarurat" required>
                                    @error('namaKontakDarurat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hubunganKontakDarurat"
                                        class="form-label required-field">Hubungan</label>
                                    <input type="text"
                                        class="form-control @error('hubunganKontakDarurat') is-invalid @enderror"
                                        id="hubunganKontakDarurat" wire:model.blur="hubunganKontakDarurat" required>
                                    @error('hubunganKontakDarurat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamatKontakDarurat" class="form-label required-field">Alamat</label>
                            <textarea class="form-control @error('alamatKontakDarurat') is-invalid @enderror" id="alamatKontakDarurat"
                                rows="2" wire:model.blur="alamatKontakDarurat" required></textarea>
                            @error('alamatKontakDarurat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="teleponKontakDarurat" class="form-label required-field">Nomor Telepon</label>
                            <input type="text"
                                class="form-control @error('teleponKontakDarurat') is-invalid @enderror"
                                id="teleponKontakDarurat" wire:model.blur="teleponKontakDarurat" required>
                            @error('teleponKontakDarurat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn btn-outline-primary"
                                wire:click="prevStep">Sebelumnya</button>
                            <button type="button" class="btn btn-primary" wire:click="nextStep">Selanjutnya</button>
                        </div>
                    </div>

                    <!-- Step 4: Konfirmasi & Submit -->
                    <div class="form-section {{ $currentStep == 4 ? 'active' : '' }}" id="section4">
                        <h4 class="mb-4">Konfirmasi Data</h4>
                        <div class="alert alert-info">
                            Silakan periksa kembali seluruh data yang telah Anda isi.
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="persetujuan"
                                wire:model.live="persetujuan" required>
                            <label class="form-check-label" for="persetujuan">
                                Saya menyatakan bahwa data yang saya isi adalah benar dan saya menyetujui <a
                                    href="#" target="_blank">syarat & ketentuan</a> yang berlaku.
                            </label>
                            @error('persetujuan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-navigation">
                            <button type="button" class="btn btn-outline-primary"
                                wire:click="prevStep">Sebelumnya</button>

                            {{-- 2. Hapus wire:click dari tombol ini. Biarkan hanya type="submit" --}}
                            <button type="submit" class="btn btn-success"
                                @if (!$persetujuan) disabled @endif>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
