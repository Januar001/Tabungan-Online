<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
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

    // PENYESUAIAN: Method submit() hanya memvalidasi persetujuan
    public function submit()
    {
        // Validasi terakhir hanya untuk persetujuan di Step 4
        $this->validate(
            ['persetujuan' => 'accepted'],
            ['persetujuan.accepted' => 'Anda harus menyetujui syarat dan ketentuan untuk melanjutkan.']
        );

        // Simpan file ke storage
        $identitasPath = $this->fileIdentitas->store('documents');
        $selfiePath = $this->fileSelfie->store('documents');

        $aktaPath = null;
        $npwpPath = null;
        if ($this->product === 'simade' && $this->simadeType === 'badan_usaha') {
            $aktaPath = $this->fileAkta->store('documents');
            $npwpPath = $this->fileNpwp->store('documents');
        }


        session()->flash('message', 'Pengajuan berhasil dikirim! Terima kasih telah membuka rekening.');
        
        // Reset form dan kembali ke awal
        $this->reset();
        $this->mount(); // Panggil mount lagi untuk load data awal jika perlu
    }
}