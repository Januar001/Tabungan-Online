<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <!-- Form Header with Step Indicator -->
                <div class="form-header">
                    <h2><i class="fas fa-piggy-bank me-2"></i>Pembukaan Rekening Tabungan</h2>
                    <div class="step-indicator">
                        @foreach(range(1, $totalSteps) as $step)
                            <div class="step 
                                {{ $currentStep == $step ? 'active' : '' }}
                                {{ $currentStep > $step ? 'completed' : '' }}"
                                wire:click="goToStep({{ $step }})"
                                style="cursor: pointer;">
                                {{ $step }}
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Step 1: Pilih Produk -->
                <div class="form-section {{ $currentStep == 1 ? 'active' : '' }}" id="section1">
                    <h4 class="mb-4">Pilih Jenis Tabungan</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-card 
                                {{ $product == 'tabunganku' ? 'selected' : '' }}"
                                wire:click="selectProduct('tabunganku')"
                                data-product="tabunganku">
                                <input type="radio" class="d-none" id="productTabunganku" value="tabunganku" wire:model.live="product">
                                <label for="productTabunganku" class="w-100 h-100 m-0 p-0" style="cursor:pointer;">
                                    <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                                    <h5>TabunganKu</h5>
                                    <p>Khusus untuk pelajar/mahasiswa usia 7-17 tahun</p>
                                    <ul class="text-muted">
                                        <li>Bebas biaya admin</li>
                                        <li>Kartu debit khusus pelajar</li>
                                        <li>Buku tabungan digital</li>
                                    </ul>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-card 
                                {{ $product == 'simade' ? 'selected' : '' }}"
                                wire:click="selectProduct('simade')"
                                data-product="simade">
                                <input type="radio" class="d-none" id="productSimade" value="simade" wire:model.live="product">
                                <label for="productSimade" class="w-100 h-100 m-0 p-0" style="cursor:pointer;">
                                    <div class="icon"><i class="fas fa-user-tie"></i></div>
                                    <h5>SIMADE</h5>
                                    <p>Untuk perorangan dan badan usaha</p>
                                    <ul class="text-muted">
                                        <li>Bunga kompetitif</li>
                                        <li>Kartu debit premium</li>
                                        <li>Akses mobile banking</li>
                                    </ul>
                                </label>
                            </div>
                        </div>
                    </div>

                    @if ($product=='simade')
                        <hr>
                        <h5 class="mb-3">Pilih Jenis SIMADE</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                wire:model="simadeType"
                                name="simadeType" id="simadePersonal" value="perorangan">
                            <label class="form-check-label" for="simadePersonal">
                                Perorangan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                wire:model="simadeType"
                                name="simadeType" id="simadeBusiness" value="badan_usaha">
                            <label class="form-check-label" for="simadeBusiness">
                                Badan Usaha
                            </label>
                        </div>
                    @endif
                    
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline-primary" disabled>Sebelumnya</button>
                        <button type="button" class="btn btn-primary" wire:click="nextStep">Selanjutnya</button>
                    </div>
                </div>
                
                <!-- Step 2: Data Pribadi -->
                <div class="form-section {{ $currentStep == 2 ? 'active' : '' }}" id="section2">
                    <h4 class="mb-4">Data Pribadi</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label required-field">Nama Lengkap</label>
                                <input type="text" class="form-control @error('namaLengkap') is-invalid @enderror" 
                                    id="namaLengkap" wire:model="namaLengkap" required>
                                @error('namaLengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="namaPanggilan" class="form-label">Nama Panggilan/Alias</label>
                                <input type="text" class="form-control" 
                                    id="namaPanggilan" wire:model="namaPanggilan">
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
                                            wire:model="jenisKelamin"
                                            name="jenisKelamin" id="lakiLaki" value="L">
                                        <label class="form-check-label" for="lakiLaki">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" 
                                            wire:model="jenisKelamin"
                                            name="jenisKelamin" id="perempuan" value="P">
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="namaIbu" class="form-label required-field">Nama Ibu Kandung</label>
                                <input type="text" class="form-control @error('namaIbu') is-invalid @enderror" 
                                    id="namaIbu" wire:model="namaIbu" required>
                                @error('namaIbu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tempatLahir" class="form-label required-field">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempatLahir') is-invalid @enderror" 
                                    id="tempatLahir" wire:model="tempatLahir" required>
                                @error('tempatLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggalLahir" class="form-label required-field">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggalLahir') is-invalid @enderror" 
                                    id="tanggalLahir" wire:model="tanggalLahir" required>
                                @error('tanggalLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="agama" class="form-label required-field">Agama</label>
                                <select class="form-select @error('agama') is-invalid @enderror" 
                                    id="agama" wire:model="agama" required>
                                    <option value="" selected disabled>Pilih Agama</option>
                                    <option value="islam">Islam</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="katolik">Katolik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="buddha">Buddha</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pendidikan" class="form-label required-field">Pendidikan Terakhir</label>
                                <select class="form-select @error('pendidikan') is-invalid @enderror" 
                                    id="pendidikan" wire:model="pendidikan" required>
                                    <option value="" selected disabled>Pilih Pendidikan</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA/SMK</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="s1">S1</option>
                                    <option value="s2">S2</option>
                                    <option value="s3">S3</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                @error('pendidikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenisIdentitas" class="form-label required-field">Jenis Identitas</label>
                                <select class="form-select @error('jenisIdentitas') is-invalid @enderror" 
                                    id="jenisIdentitas" wire:model="jenisIdentitas" required>
                                    <option value="" selected disabled>Pilih Identitas</option>
                                    <option value="ktp">KTP</option>
                                    <option value="kartu_pelajar">Kartu Pelajar/Mahasiswa</option>
                                    <option value="paspor">Paspor</option>
                                    <option value="sim">SIM</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                @error('jenisIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="noIdentitas" class="form-label required-field">Nomor Identitas</label>
                                <input type="text" class="form-control @error('noIdentitas') is-invalid @enderror" 
                                    id="noIdentitas" wire:model="noIdentitas" required>
                                @error('noIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamatIdentitas" class="form-label required-field">Alamat (Sesuai Identitas)</label>
                        <textarea class="form-control @error('alamatIdentitas') is-invalid @enderror" 
                            id="alamatIdentitas" rows="3" wire:model="alamatIdentitas" required></textarea>
                        @error('alamatIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kodePos" class="form-label required-field">Kode Pos</label>
                                <input type="text" class="form-control @error('kodePos') is-invalid @enderror" 
                                    id="kodePos" wire:model="kodePos" required>
                                @error('kodePos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="kota" class="form-label required-field">Kota/Kabupaten</label>
                                <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                                    id="kota" wire:model="kota" required>
                                @error('kota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="noTelp" class="form-label required-field">No. Telepon</label>
                                <input type="text" class="form-control @error('noTelp') is-invalid @enderror" 
                                    id="noTelp" wire:model="noTelp" required>
                                @error('noTelp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label required-field">Status Perkawinan</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" wire:model="status" required>
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="belum_menikah">Belum Menikah</option>
                                    <option value="menikah">Menikah</option>
                                    <option value="cerai">Cerai</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="npwp" class="form-label">NPWP</label>
                                <input type="text" class="form-control" 
                                    id="npwp" wire:model="npwp">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label required-field">Pekerjaan</label>
                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                    id="pekerjaan" wire:model="pekerjaan" required>
                                @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="penghasilan" class="form-label required-field">Penghasilan Per Bulan</label>
                                <select class="form-select @error('penghasilan') is-invalid @enderror" 
                                    id="penghasilan" wire:model="penghasilan" required>
                                    <option value="" selected disabled>Pilih Penghasilan</option>
                                    <option value="<1jt">&lt; Rp1.000.000</option>
                                    <option value="1-3jt">Rp1.000.000 - Rp3.000.000</option>
                                    <option value="3-5jt">Rp3.000.000 - Rp5.000.000</option>
                                    <option value="5-10jt">Rp5.000.000 - Rp10.000.000</option>
                                    <option value=">10jt">&gt; Rp10.000.000</option>
                                </select>
                                @error('penghasilan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sumberDana" class="form-label required-field">Sumber Dana</label>
                                <input type="text" class="form-control @error('sumberDana') is-invalid @enderror" 
                                    id="sumberDana" wire:model="sumberDana" required>
                                @error('sumberDana') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tujuanPenggunaanDana" class="form-label required-field">Tujuan Penggunaan Dana</label>
                        <input type="text" class="form-control @error('tujuanPenggunaanDana') is-invalid @enderror" 
                            id="tujuanPenggunaanDana" wire:model="tujuanPenggunaanDana" required>
                        @error('tujuanPenggunaanDana') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline-primary" wire:click="prevStep">Sebelumnya</button>
                        <button type="button" class="btn btn-primary" wire:click="nextStep">Selanjutnya</button>
                    </div>
                </div>
                
                <!-- Step 3: Data Tambahan -->
                <div class="form-section {{ $currentStep == 3 ? 'active' : '' }}" id="section3">
                    <h4 class="mb-4">Data Tambahan</h4>
                    
                    <div id="data-tambahan-container">
                        @if($product === 'tabunganku')
                            <h5 class="mb-3">Data Sekolah</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaSekolah" class="form-label required-field">Nama Sekolah</label>
                                        <input type="text" class="form-control @error('namaSekolah') is-invalid @enderror" 
                                            id="namaSekolah" wire:model="namaSekolah" required>
                                        @error('namaSekolah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label required-field">Kelas</label>
                                        <input type="text" class="form-control @error('kelas') is-invalid @enderror" 
                                            id="kelas" wire:model="kelas" required>
                                        @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mt-4">Data Wali</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaWali" class="form-label required-field">Nama Wali</label>
                                        <input type="text" class="form-control @error('namaWali') is-invalid @enderror" 
                                            id="namaWali" wire:model="namaWali" required>
                                        @error('namaWali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="noIdentitasWali" class="form-label required-field">No. Identitas Wali</label>
                                        <input type="text" class="form-control @error('noIdentitasWali') is-invalid @enderror" 
                                            id="noIdentitasWali" wire:model="noIdentitasWali" required>
                                        @error('noIdentitasWali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="hubunganWali" class="form-label required-field">Hubungan dengan Wali</label>
                                <input type="text" class="form-control @error('hubunganWali') is-invalid @enderror" 
                                    id="hubunganWali" wire:model="hubunganWali" required>
                                @error('hubunganWali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @elseif($product === 'simade' && $simadeType === 'badan_usaha')
                            <h5 class="mb-3">Data Perusahaan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaPerusahaan" class="form-label required-field">Nama Perusahaan</label>
                                        <input type="text" class="form-control @error('namaPerusahaan') is-invalid @enderror" 
                                            id="namaPerusahaan" wire:model="namaPerusahaan" required>
                                        @error('namaPerusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="noAktaPendirian" class="form-label">No. Akta Pendirian</label>
                                        <input type="text" class="form-control" 
                                            id="noAktaPendirian" wire:model="noAktaPendirian">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="noIzinUsaha" class="form-label">No. Izin Usaha</label>
                                        <input type="text" class="form-control" 
                                            id="noIzinUsaha" wire:model="noIzinUsaha">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="npwpPerusahaan" class="form-label required-field">NPWP Perusahaan</label>
                                        <input type="text" class="form-control @error('npwpPerusahaan') is-invalid @enderror" 
                                            id="npwpPerusahaan" wire:model="npwpPerusahaan" required>
                                        @error('npwpPerusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaPengurus" class="form-label required-field">Nama Pengurus</label>
                                        <input type="text" class="form-control @error('namaPengurus') is-invalid @enderror" 
                                            id="namaPengurus" wire:model="namaPengurus" required>
                                        @error('namaPengurus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label required-field">Jabatan</label>
                                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                            id="jabatan" wire:model="jabatan" required>
                                        @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="noTelpPerusahaan" class="form-label required-field">No. Telepon Perusahaan</label>
                                        <input type="text" class="form-control @error('noTelpPerusahaan') is-invalid @enderror" 
                                            id="noTelpPerusahaan" wire:model="noTelpPerusahaan" required>
                                        @error('noTelpPerusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bidangUsaha" class="form-label required-field">Bidang Usaha</label>
                                        <input type="text" class="form-control @error('bidangUsaha') is-invalid @enderror" 
                                            id="bidangUsaha" wire:model="bidangUsaha" required>
                                        @error('bidangUsaha') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <h5 class="mt-4">Kontak Darurat</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="namaKontakDarurat" class="form-label required-field">Nama Lengkap</label>
                                <input type="text" class="form-control @error('namaKontakDarurat') is-invalid @enderror" 
                                    id="namaKontakDarurat" wire:model="namaKontakDarurat" required>
                                @error('namaKontakDarurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hubunganKontakDarurat" class="form-label required-field">Hubungan</label>
                                <input type="text" class="form-control @error('hubunganKontakDarurat') is-invalid @enderror" 
                                    id="hubunganKontakDarurat" wire:model="hubunganKontakDarurat" required>
                                @error('hubunganKontakDarurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamatKontakDarurat" class="form-label required-field">Alamat</label>
                        <textarea class="form-control @error('alamatKontakDarurat') is-invalid @enderror" 
                            id="alamatKontakDarurat" rows="2" wire:model="alamatKontakDarurat" required></textarea>
                        @error('alamatKontakDarurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="teleponKontakDarurat" class="form-label required-field">Nomor Telepon</label>
                        <input type="text" class="form-control @error('teleponKontakDarurat') is-invalid @enderror" 
                            id="teleponKontakDarurat" wire:model="teleponKontakDarurat" required>
                        @error('teleponKontakDarurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline-primary" wire:click="prevStep">Sebelumnya</button>
                        <button type="button" class="btn btn-primary" wire:click="nextStep">Selanjutnya</button>
                    </div>
                </div>

                <!-- Step 4: Konfirmasi & Submit -->
                <div class="form-section {{ $currentStep == 4 ? 'active' : '' }}" id="section4">
                    <h4 class="mb-4">Konfirmasi Data</h4>
                    <div class="alert alert-info">
                        Silakan periksa kembali seluruh data yang telah Anda isi sebelum mengirimkan formulir pembukaan rekening tabungan.
                    </div>
                    <!-- Ringkasan data dapat ditampilkan di sini jika diperlukan -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="persetujuan" wire:model="persetujuan" required>
                        <label class="form-check-label" for="persetujuan">
                            Saya menyatakan bahwa data yang saya isi adalah benar dan saya menyetujui <a href="#" target="_blank">syarat & ketentuan</a> yang berlaku.
                        </label>
                        @error('persetujuan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline-primary" wire:click="prevStep">Sebelumnya</button>
                        <button type="submit" class="btn btn-success" wire:click="submitForm" @if(!$persetujuan) disabled @endif>
                            Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>