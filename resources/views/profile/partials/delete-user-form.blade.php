<section>
    <header>
        <h5 class="fw-bold text-danger">Hapus Akun</h5>
        <p class="text-muted small">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
    </header>
    
    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        Hapus Akun Saya
    </button>

    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Anda yakin ingin menghapus akun?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Setelah akun Anda dihapus, semua datanya akan hilang selamanya. Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.</p>
                    <div class="mt-3">
                        <label for="password" class="form-label visually-hidden">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                        @if($errors->userDeletion->get('password')) <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div> @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</section>