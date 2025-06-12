<div class="container">
    <div class="form-section active" id="section4">
        <h4 class="mb-4">Upload Dokumen</h4>
        <form wire:submit="save" >
            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="file-upload" id="uploadIdentitas" style="cursor:pointer;" onclick="document.getElementById('fileIdentitas').click()">
                        <i class="fas fa-id-card"></i>
                        <p>Upload Foto Identitas (KTP/Kartu Pelajar)</p>
                        <input type="file" wire:model="fileIdentitas" id="fileIdentitas" accept="image/*,.pdf"
                            style="display: none;" onchange="document.getElementById('fileNameIdentitas').innerText = this.files[0] ? this.files[0].name : 'Belum ada file dipilih'">
                        <div class="file-name" id="fileNameIdentitas">Belum ada file dipilih</div>
                        @error('fileIdentitas')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="file-upload" id="uploadSelfie" style="cursor:pointer;" onclick="document.getElementById('fileSelfie').click()">
                        <i class="fas fa-user-circle"></i>
                        <p>Upload Foto Selfie dengan Identitas</p>
                        <input type="file" wire:model="fileSelfie" id="fileSelfie" accept="image/*"
                            style="display: none;" onchange="document.getElementById('fileNameSelfie').innerText = this.files[0] ? this.files[0].name : 'Belum ada file dipilih'">
                        <div class="file-name" id="fileNameSelfie">Belum ada file dipilih</div>
                        @error('fileSelfie')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div> --}}
            <label for="fileIdentitas" class="form-label">Upload Foto Identitas (KTP/Kartu Pelajar)</label>
            <input type="file" wire:model="fileIdentitas"  class="form-control mb-3" required>
            @error('fileIdentitas')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <label for="fileSelfie" class="form-label">Upload Foto Selfie</label>
            <input type="file" wire:model="fileSelfie"  class="form-control mb-3" required>
            @error('fileSelfie')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <div id="dokumenTambahanContainer" class="mt-3"></div>

            <hr class="my-4">

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="persetujuan" wire:model.live="persetujuan" required>
                <label class="form-check-label" for="persetujuan">
                    Dengan menandatangani formulir ini, saya menyatakan bahwa data sebagaimana tersebut di atas adalah
                    benar
                    dan
                    merupakan data terbaru saya. Bilamana ternyata di kemudian hari informasi tersebut tidak benar, saya
                    bersedia mempertanggungjawabkannya.
                </label>
                @error('persetujuan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-navigation">
                <button type="button" class="btn btn-outline-primary prev-btn" data-prev="section3">Sebelumnya</button>
                <button type="submit" class="btn btn-success" @if (!$persetujuan) disabled @endif>
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>
