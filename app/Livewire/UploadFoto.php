<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class UploadFoto extends Component
{
    use WithFileUploads;

    public $fileIdentitas;

    public $fileSelfie;

    public $persetujuan = false;


    public function render()
    {
        return view('livewire.upload-foto');
    }

    public function save(){
        $this->validate([
            'fileIdentitas' => 'required|image|max:2048',
            'fileSelfie' => 'required|image|max:2048',
            'persetujuan' => 'accepted',
        ]);

        // Simpan file identitas
        $this->fileIdentitas->store('identitas');

        // Simpan file selfie
        $this->fileSelfie->store('selfie');

        session()->flash('message', 'Foto berhasil diunggah!');
    }
}
