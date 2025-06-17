<?php

namespace App\Livewire;

use Exception;
use Carbon\Carbon;
use App\Models\Alamat;
use App\Models\Nasabah;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\KontakDarurat;
use Livewire\WithFileUploads;
use App\Models\DataBadanUsaha;
use App\Models\DataTabunganku;
use App\Models\DokumenPengajuan;
use App\Models\PengajuanRekening;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class FormTabungan extends Component
{
    use WithFileUploads;

    // Properti untuk menyimpan daftar pilihan
    public $provinsi = [];
    public $kabupaten = [];
    public $kecamatan = [];
    public $desa = [];

    // Properti untuk menyimpan nilai yang terpilih
    public $selectedProvinsi = null;
    public $selectedKabupaten = null;
    public $selectedKecamatan = null;
    public $selectedDesa = null;

    // Base URL dari API
    protected $apiBaseUrl = 'https://januar001.github.io/api-wilayah-indonesia/api/';

    // Step management
    public $currentStep = 1;
    public $totalSteps = 4;

    // Product selection
    public $product = '';
    public $simadeType = 'perorangan';

    // Personal data
    public $dataPribadi = [
        'namaLengkap' => '',
        'namaPanggilan' => '',
        'jenisKelamin' => 'L',
        'namaIbu' => '',
        'tempatLahir' => '',
        'tanggalLahir' => '',
        'agama' => '',
        'pendidikan' => '',
        'jenisIdentitas' => '',
        'noIdentitas' => '',
        'alamatIdentitas' => '',
        'kodePos' => '',
        'kota' => '',
        'noTelp' => '',
        'status' => '',
        'npwp' => '',
        'pekerjaan' => '',
        'penghasilan' => '',
        'sumberDana' => '',
        'tujuanPenggunaanDana' => '',
    ];

    // Additional data for TabunganKu
    public $dataTabunganku = [
        'namaSekolah' => '',
        'kelas' => '',
        'namaWali' => '',
        'noIdentitasWali' => '',
        'hubunganWali' => '',
    ];

    // Additional data for SIMADE Badan Usaha
    public $badanUsaha = [
        'namaPerusahaan' => '',
        'noAktaPendirian' => '',
        'noIzinUsaha' => '',
        'npwpPerusahaan' => '',
        'namaPengurus' => '',
        'jabatan' => '',
        'noTelpPerusahaan' => '',
        'bidangUsaha' => '',
    ];

    // Emergency contact
    public $namaKontakDarurat = '';
    public $hubunganKontakDarurat = '';
    public $alamatKontakDarurat = '';
    public $teleponKontakDarurat = '';

    // Documents
    public $fileIdentitas;
    public $fileSelfie;
    public $fileAkta;
    public $fileNpwp;

    public $fileNameIdentitas = 'Belum ada file dipilih';
    public $fileNameSelfie = 'Belum ada file dipilih';
    public $fileNameAkta = 'Belum ada file dipilih';
    public $fileNameNpwp = 'Belum ada file dipilih';

    // Agreement
    public $persetujuan = false;

    public function render()
    {
        return view('livewire.form-tabungan');
    }

    public function mount()
    {
        $response = Http::get($this->apiBaseUrl . 'provinces.json');
        if ($response->successful()) {
            $this->provinsi = $response->json();
        }
    }

    public function updatedSelectedProvinsi($provinsiId)
    {
        $this->reset(['selectedKabupaten', 'selectedKecamatan', 'selectedDesa', 'kabupaten', 'kecamatan', 'desa']);
        if ($provinsiId) {
            $response = Http::get($this->apiBaseUrl . "regencies/{$provinsiId}.json");
            if ($response->successful()) {
                $this->kabupaten = $response->json();
            }
        }
    }

    public function updatedSelectedKabupaten($kabupatenId)
    {
        $this->reset(['selectedKecamatan', 'selectedDesa', 'kecamatan', 'desa']);
        if ($kabupatenId) {
            $response = Http::get($this->apiBaseUrl . "districts/{$kabupatenId}.json");
            if ($response->successful()) {
                $this->kecamatan = $response->json();
            }
        }
    }

    public function updatedSelectedKecamatan($kecamatanId)
    {
        $this->reset(['selectedDesa', 'desa']);
        if ($kecamatanId) {
            $response = Http::get($this->apiBaseUrl . "villages/{$kecamatanId}.json");
            if ($response->successful()) {
                $this->desa = $response->json();
            }
        }
    }

    // Navigation methods
    public function nextStep()
    {
        try {
            $this->validateCurrentStep();
            if ($this->currentStep < $this->totalSteps) {
                $this->currentStep++;
            }
        } catch (ValidationException $e) {
            // Biarkan Livewire menangani error validasi secara otomatis
            throw $e;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        // Hanya izinkan navigasi ke step yang sudah dilewati atau step saat ini
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }


    public function selectProduct($product)
    {
        $this->product = $product;
    }

    // PENYESUAIAN: Logika validasi per step yang sudah diperbaiki
    private function validateCurrentStep()
    {
        if ($this->currentStep === 1) {
            $this->validate(
                ['product' => 'required'],
                ['product.required' => 'Silakan pilih salah satu jenis tabungan.']
            );

            if ($this->product === 'simade') {
                $this->validate(
                    ['simadeType' => 'required'],
                    ['simadeType.required' => 'Silakan pilih jenis SIMADE.']
                );
            }
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'dataPribadi.namaLengkap' => ['required'],
                'dataPribadi.jenisKelamin' => ['required'],
                'dataPribadi.namaIbu' => ['required'],
                'dataPribadi.tempatLahir' => ['required'],
                'dataPribadi.tanggalLahir' => [
                    'required', 'date',
                    function ($attribute, $value, $fail) {
                        $tanggalLahir = \Carbon\Carbon::parse($value);
                        $usia = $tanggalLahir->diffInYears(now());
                        if ($this->product === 'tabunganku') {
                            if ($usia < 7 || $usia > 17) {
                                $fail('Usia untuk TabunganKu harus antara 7 sampai 17 tahun.');
                            }
                        } else {
                            if ($usia < 17) {
                                $fail('Usia minimal untuk produk ini adalah 17 tahun.');
                            }
                        }
                    },
                ],
                'dataPribadi.agama' => ['required'],
                'dataPribadi.pendidikan' => ['required'],
                'dataPribadi.jenisIdentitas' => ['required'],
                'dataPribadi.noIdentitas' => ['required'],
                'dataPribadi.alamatIdentitas' => ['required'],
                'dataPribadi.kodePos' => ['required'],
                'selectedProvinsi' => ['required'],
                'selectedKabupaten' => ['required'],
                'selectedKecamatan' => ['required'],
                'selectedDesa' => ['required'],
                'dataPribadi.noTelp' => ['required'],
                'dataPribadi.status' => ['required'],
                'dataPribadi.pekerjaan' => ['required'],
                'dataPribadi.penghasilan' => ['required'],
                'dataPribadi.sumberDana' => ['required'],
                'dataPribadi.tujuanPenggunaanDana' => ['required'],
            ], [
                // Pesan error untuk step 2
                'dataPribadi.namaLengkap.required' => 'Nama lengkap wajib diisi.',
                'dataPribadi.jenisKelamin.required' => 'Jenis kelamin wajib dipilih.',
                'dataPribadi.namaIbu.required' => 'Nama ibu kandung wajib diisi.',
                'selectedProvinsi.required' => 'Provinsi wajib dipilih.',
                'selectedKabupaten.required' => 'Kabupaten/Kota wajib dipilih.',
                'selectedKecamatan.required' => 'Kecamatan wajib dipilih.',
                'selectedDesa.required' => 'Desa/Kelurahan wajib dipilih.',
                // Tambahkan pesan custom lainnya jika diperlukan
            ]);
        } elseif ($this->currentStep === 3) {
            // Semua validasi untuk Step 3 digabungkan di sini
            $rules = [
                'namaKontakDarurat' => 'required',
                'hubunganKontakDarurat' => 'required',
                'alamatKontakDarurat' => 'required',
                'teleponKontakDarurat' => 'required',
                'fileIdentitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'fileSelfie' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ];

            $messages = [
                'namaKontakDarurat.required' => 'Nama kontak darurat wajib diisi.',
                'hubunganKontakDarurat.required' => 'Hubungan dengan kontak darurat wajib diisi.',
                'alamatKontakDarurat.required' => 'Alamat kontak darurat wajib diisi.',
                'teleponKontakDarurat.required' => 'Nomor telepon kontak darurat wajib diisi.',
                'fileIdentitas.required' => 'Foto/scan identitas wajib diunggah.',
                'fileIdentitas.mimes' => 'Format file identitas harus jpg, jpeg, png, atau pdf.',
                'fileIdentitas.max' => 'Ukuran file identitas maksimal 2MB.',
                'fileSelfie.required' => 'Foto selfie dengan identitas wajib diunggah.',
                'fileSelfie.mimes' => 'Format file selfie harus jpg, jpeg, atau png.',
                'fileSelfie.max' => 'Ukuran file selfie maksimal 2MB.',
            ];

            if ($this->product === 'tabunganku') {
                $rules['dataTabunganku.namaSekolah'] = 'required';
                $rules['dataTabunganku.kelas'] = 'required';
                $rules['dataTabunganku.namaWali'] = 'required';
                $rules['dataTabunganku.noIdentitasWali'] = 'required';
                $rules['dataTabunganku.hubunganWali'] = 'required';

                $messages['dataTabunganku.namaSekolah.required'] = 'Nama sekolah wajib diisi.';
                $messages['dataTabunganku.kelas.required'] = 'Kelas wajib diisi.';
                $messages['dataTabunganku.namaWali.required'] = 'Nama wali wajib diisi.';
                $messages['dataTabunganku.noIdentitasWali.required'] = 'Nomor identitas wali wajib diisi.';
                $messages['dataTabunganku.hubunganWali.required'] = 'Hubungan dengan wali wajib diisi.';
            }

            if ($this->product === 'simade' && $this->simadeType === 'badan_usaha') {
                $rules['badanUsaha.namaPerusahaan'] = 'required';
                $rules['badanUsaha.npwpPerusahaan'] = 'required';
                $rules['badanUsaha.namaPengurus'] = 'required';
                $rules['badanUsaha.jabatan'] = 'required';
                $rules['badanUsaha.noTelpPerusahaan'] = 'required';
                $rules['badanUsaha.bidangUsaha'] = 'required';
                $rules['fileAkta'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
                $rules['fileNpwp'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';

                $messages['badanUsaha.namaPerusahaan.required'] = 'Nama perusahaan wajib diisi.';
                $messages['fileAkta.required'] = 'File akta pendirian wajib diunggah.';
                $messages['fileNpwp.required'] = 'File NPWP perusahaan wajib diunggah.';
            }

            $this->validate($rules, $messages);
        }
    }


    // File upload handling
    public function updatedFileIdentitas()
    {
        $this->validate(['fileIdentitas' => 'file|mimes:jpg,jpeg,png,pdf|max:2048']);
        $this->fileNameIdentitas = $this->fileIdentitas ? $this->fileIdentitas->getClientOriginalName() : 'Belum ada file dipilih';
    }

    public function updatedFileSelfie()
    {
        $this->validate(['fileSelfie' => 'file|mimes:jpg,jpeg,png|max:2048']);
        $this->fileNameSelfie = $this->fileSelfie ? $this->fileSelfie->getClientOriginalName() : 'Belum ada file dipilih';
    }

    public function updatedFileAkta()
    {
        $this->validate(['fileAkta' => 'file|mimes:jpg,jpeg,png,pdf|max:2048']);
        $this->fileNameAkta = $this->fileAkta ? $this->fileAkta->getClientOriginalName() : 'Belum ada file dipilih';
    }

    public function updatedFileNpwp()
    {
        $this->validate(['fileNpwp' => 'file|mimes:jpg,jpeg,png,pdf|max:2048']);
        $this->fileNameNpwp = $this->fileNpwp ? $this->fileNpwp->getClientOriginalName() : 'Belum ada file dipilih';
    }

    public function submit()
    {
        // Validasi terakhir untuk persetujuan di Step 4
        $this->validate(
            ['persetujuan' => 'accepted'],
            ['persetujuan.accepted' => 'Anda harus menyetujui syarat dan ketentuan untuk melanjutkan.']
        );

        // Gunakan DB::transaction untuk memastikan semua data berhasil disimpan atau tidak sama sekali
        try {
            DB::transaction(function () {
                // 1. Simpan file-file ke storage terlebih dahulu
                $identitasPath = $this->fileIdentitas->store('dokumen_pengajuan');
                $selfiePath = $this->fileSelfie->store('dokumen_pengajuan');

                // 2. Buat data Nasabah baru
                $nasabah = Nasabah::create([
                    'user_id'             => auth()->id(),
                    'nama_lengkap'        => $this->dataPribadi['namaLengkap'],
                    'nama_panggilan'      => $this->dataPribadi['namaPanggilan'],
                    'jenis_kelamin'       => $this->dataPribadi['jenisKelamin'],
                    'nama_ibu_kandung'    => $this->dataPribadi['namaIbu'],
                    'tempat_lahir'        => $this->dataPribadi['tempatLahir'],
                    'tanggal_lahir'       => $this->dataPribadi['tanggalLahir'],
                    'agama'               => $this->dataPribadi['agama'],
                    'pendidikan_terakhir' => $this->dataPribadi['pendidikan'],
                    'status_perkawinan'   => $this->dataPribadi['status'],
                    'pekerjaan'           => $this->dataPribadi['pekerjaan'],
                    'npwp'                => $this->dataPribadi['npwp'] ?? null,
                    'no_telepon'          => $this->dataPribadi['noTelp'],
                ]);

                // 3. Buat data Alamat untuk Nasabah
                Alamat::create([
                    'nasabah_id'     => $nasabah->id,
                    'jenis_alamat'   => 'identitas', // Asumsi dari form adalah alamat identitas
                    'alamat_lengkap' => $this->dataPribadi['alamatIdentitas'],
                    'provinsi_id'    => $this->selectedProvinsi,
                    'kabupaten_id'   => $this->selectedKabupaten,
                    'kecamatan_id'   => $this->selectedKecamatan,
                    'desa_id'        => $this->selectedDesa,
                    'kode_pos'       => $this->dataPribadi['kodePos'],
                ]);

                // 4. Buat data Pengajuan Rekening
                $pengajuan = PengajuanRekening::create([
                    'nasabah_id'           => $nasabah->id,
                    'kode_pengajuan'       => 'REG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                    'produk'               => $this->product,
                    'tipe_simade'          => $this->product === 'simade' ? $this->simadeType : null,
                    'penghasilan_per_bulan'=> $this->dataPribadi['penghasilan'],
                    'sumber_dana'          => $this->dataPribadi['sumberDana'],
                    'tujuan_penggunaan'    => $this->dataPribadi['tujuanPenggunaanDana'],
                    'status'               => 'pending', // Status awal
                ]);

                // 5. Simpan data Kontak Darurat
                KontakDarurat::create([
                    'pengajuan_rekening_id' => $pengajuan->id,
                    'nama_lengkap'          => $this->namaKontakDarurat,
                    'hubungan'              => $this->hubunganKontakDarurat,
                    'alamat'                => $this->alamatKontakDarurat,
                    'no_telepon'            => $this->teleponKontakDarurat,
                ]);

                // 6. Simpan data Dokumen Pengajuan (Identitas dan Selfie)
                DokumenPengajuan::create([
                    'pengajuan_rekening_id' => $pengajuan->id,
                    'jenis_dokumen'         => 'identitas_pribadi',
                    'path_file'             => $identitasPath,
                    'nama_asli_file'        => $this->fileIdentitas->getClientOriginalName(),
                ]);
                DokumenPengajuan::create([
                    'pengajuan_rekening_id' => $pengajuan->id,
                    'jenis_dokumen'         => 'selfie_identitas',
                    'path_file'             => $selfiePath,
                    'nama_asli_file'        => $this->fileSelfie->getClientOriginalName(),
                ]);


                // 7. Logika kondisional berdasarkan produk yang dipilih
                if ($this->product === 'tabunganku') {
                    // Simpan data spesifik untuk TabunganKu
                    DataTabunganku::create([
                        'pengajuan_rekening_id' => $pengajuan->id,
                        'nama_sekolah'          => $this->dataTabunganku['namaSekolah'],
                        'kelas'                 => $this->dataTabunganku['kelas'],
                        'nama_wali'             => $this->dataTabunganku['namaWali'],
                        'no_identitas_wali'     => $this->dataTabunganku['noIdentitasWali'],
                        'hubungan_wali'         => $this->dataTabunganku['hubunganWali'],
                    ]);
                } elseif ($this->product === 'simade' && $this->simadeType === 'badan_usaha') {
                    // Simpan file Akta dan NPWP Badan Usaha
                    $aktaPath = $this->fileAkta->store('dokumen_pengajuan');
                    $npwpPath = $this->fileNpwp->store('dokumen_pengajuan');

                    // Simpan data dokumen Akta dan NPWP
                    DokumenPengajuan::create([
                        'pengajuan_rekening_id' => $pengajuan->id,
                        'jenis_dokumen'         => 'akta_perusahaan',
                        'path_file'             => $aktaPath,
                        'nama_asli_file'        => $this->fileAkta->getClientOriginalName(),
                    ]);
                    DokumenPengajuan::create([
                        'pengajuan_rekening_id' => $pengajuan->id,
                        'jenis_dokumen'         => 'npwp_perusahaan',
                        'path_file'             => $npwpPath,
                        'nama_asli_file'        => $this->fileNpwp->getClientOriginalName(),
                    ]);

                    // Simpan data spesifik untuk Badan Usaha
                    DataBadanUsaha::create([
                        'pengajuan_rekening_id' => $pengajuan->id,
                        'nama_perusahaan'       => $this->badanUsaha['namaPerusahaan'],
                        'no_akta_pendirian'     => $this->badanUsaha['noAktaPendirian'] ?? null,
                        'no_izin_usaha'         => $this->badanUsaha['noIzinUsaha'] ?? null,
                        'npwp_perusahaan'       => $this->badanUsaha['npwpPerusahaan'],
                        'jabatan_pengurus'      => $this->badanUsaha['jabatan'],
                        'no_telepon_perusahaan' => $this->badanUsaha['noTelpPerusahaan'],
                        'bidang_usaha'          => $this->badanUsaha['bidangUsaha'],
                    ]);
                }
            });

            // Jika transaksi berhasil, tampilkan pesan sukses
            session()->flash('message', 'Pengajuan berhasil dikirim! Terima kasih telah membuka rekening.');
            
            // Reset form dan kembali ke awal
            $this->reset();
            $this->mount(); // Panggil mount lagi untuk load data awal

        } catch (Exception $e) {
            // Jika terjadi error, tampilkan pesan error dan jangan reset form
            // Ini akan menjaga data yang sudah diisi pengguna
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}