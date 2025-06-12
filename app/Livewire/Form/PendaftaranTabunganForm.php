<?php

namespace App\Livewire\Form;

use Livewire\Form;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class PendaftaranTabunganForm extends Form
{
    use WithFileUploads;

    // --- PROPERTI DATA ---
    // Step 1: Product selection
    public string $product = '';
    public string $simadeType = 'perorangan';

    // Step 2: Personal data & Wilayah
    public array $dataPribadi = [
        'namaLengkap' => '', 'namaPanggilan' => '', 'jenisKelamin' => 'L', 'namaIbu' => '',
        'tempatLahir' => '', 'tanggalLahir' => '', 'agama' => '', 'pendidikan' => '',
        'jenisIdentitas' => '', 'noIdentitas' => '', 'alamatIdentitas' => '',
        'kodePos' => '', 'noTelp' => '', 'status' => '', 'npwp' => '',
        'pekerjaan' => '', 'penghasilan' => '', 'sumberDana' => '', 'tujuanPenggunaanDana' => '',
    ];
    public $selectedProvinsi = null;
    public $selectedKabupaten = null;
    public $selectedKecamatan = null;
    public $selectedDesa = null;

    // Step 3: Conditional & Emergency Contact
    public array $dataTabunganku = ['namaSekolah' => '', 'kelas' => '', 'namaWali' => '', 'noIdentitasWali' => '', 'hubunganWali' => ''];
    public array $badanUsaha = ['namaPerusahaan' => '', 'noAktaPendirian' => '', 'noIzinUsaha' => '', 'npwpPerusahaan' => '', 'namaPengurus' => '', 'jabatan' => '', 'noTelpPerusahaan' => '', 'bidangUsaha' => ''];
    public string $namaKontakDarurat = '';
    public string $hubunganKontakDarurat = '';
    public string $alamatKontakDarurat = '';
    public string $teleponKontakDarurat = '';

    // Step 4: Documents & Agreement
    #[Validate]
    public $fileIdentitas;
    #[Validate]
    public $fileSelfie;
    #[Validate]
    public $fileAkta;
    #[Validate]
    public $fileNpwp;
    public bool $persetujuan = false;

    // --- ATURAN VALIDASI YANG TERPUSAT ---

    public function rules()
    {
        $rules = [
            // Aturan untuk Step 1
            'product' => 'required',
            'simadeType' => 'required_if:product,simade',

            // Aturan untuk Step 2
            'dataPribadi.namaLengkap' => 'required|min:3',
            'dataPribadi.namaIbu' => 'required|min:3',
            'dataPribadi.tempatLahir' => 'required',
            'dataPribadi.tanggalLahir' => 'required|date',
            'dataPribadi.noIdentitas' => 'required|numeric|digits:16',
            'dataPribadi.alamatIdentitas' => 'required|min:10',
            'dataPribadi.noTelp' => 'required|numeric|min:10',
            'selectedProvinsi' => 'required',
            'selectedKabupaten' => 'required',
            'selectedKecamatan' => 'required',
            'selectedDesa' => 'required',

            // Aturan untuk Step 3
            'namaKontakDarurat' => 'required',
            'hubunganKontakDarurat' => 'required',
            'alamatKontakDarurat' => 'required',
            'teleponKontakDarurat' => 'required|numeric',

            // Aturan untuk Step 4
            'fileIdentitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB
            'fileSelfie' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'persetujuan' => 'accepted',
        ];

        // Aturan Kondisional untuk Step 3
        if ($this->product === 'tabunganku') {
            $rules['dataTabunganku.namaSekolah'] = 'required';
            $rules['dataTabunganku.namaWali'] = 'required';
            $rules['dataTabunganku.noIdentitasWali'] = 'required|numeric|digits:16';
        } elseif ($this->product === 'simade' && $this->simadeType === 'badan_usaha') {
            $rules['badanUsaha.namaPerusahaan'] = 'required';
            $rules['badanUsaha.npwpPerusahaan'] = 'required|numeric';
            $rules['badanUsaha.namaPengurus'] = 'required';
        }
        
        // Aturan Kondisional untuk Step 4
        if ($this->product === 'simade' && $this->simadeType === 'badan_usaha') {
             $rules['fileAkta'] = 'required|file|mimes:pdf|max:2048';
             $rules['fileNpwp'] = 'required|file|mimes:pdf,jpg,png|max:2048';
        }

        return $rules;
    }
    
    // --- METODE VALIDASI PER LANGKAH ---

    public function validateStep(int $step)
    {
        $rulesForStep = match($step) {
            1 => ['product', 'simadeType'],
            2 => [
                'dataPribadi.namaLengkap', 'dataPribadi.namaIbu', 'dataPribadi.tempatLahir',
                'dataPribadi.tanggalLahir', 'dataPribadi.noIdentitas', 'dataPribadi.alamatIdentitas',
                'dataPribadi.noTelp', 'selectedProvinsi', 'selectedKabupaten', 'selectedKecamatan', 'selectedDesa'
            ],
            3 => [
                'namaKontakDarurat', 'hubunganKontakDarurat', 'alamatKontakDarurat', 'teleponKontakDarurat',
                'dataTabunganku.namaSekolah', 'dataTabunganku.namaWali', 'dataTabunganku.noIdentitasWali',
                'badanUsaha.namaPerusahaan', 'badanUsaha.npwpPerusahaan', 'badanUsaha.namaPengurus'
            ],
            4 => ['fileIdentitas', 'fileSelfie', 'persetujuan', 'fileAkta', 'fileNpwp'],
            default => []
        };
        
        // Hanya validasi field yang relevan untuk step ini
        $this->validate($this->only($rulesForStep));
    }

    // --- LOGIKA PENYIMPANAN ---
    
    public function save()
    {
        // Validasi semua field sekali lagi sebelum menyimpan
        $this->validate();

        // Simpan file
        $paths = [];
        $paths['identitas'] = $this->fileIdentitas->store('dokumen_tabungan', 'public');
        $paths['selfie'] = $this->fileSelfie->store('dokumen_tabungan', 'public');
        
        if ($this->product === 'simade' && $this->simadeType === 'badan_usaha') {
            $paths['akta'] = $this->fileAkta->store('dokumen_tabungan', 'public');
            $paths['npwp'] = $this->fileNpwp->store('dokumen_tabungan', 'public');
        }

        // TODO: Implementasi penyimpanan data ke database
        // Contoh:
        // Pengajuan::create([
        //     'product' => $this->product,
        //     ...$this->dataPribadi,
        //     ...$this->badanUsaha,
        //     'file_identitas_path' => $paths['identitas'],
        //     // ... dan seterusnya
        // ]);

        // Reset form setelah berhasil
        $this->reset();
    }
}
