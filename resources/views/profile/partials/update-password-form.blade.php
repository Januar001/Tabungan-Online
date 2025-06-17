<section>
    <header>
        <h5 class="fw-bold">Ubah Password</h5>
        <p class="text-muted small">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
             @if($errors->updatePassword->get('current_password')) <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div> @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            @if($errors->updatePassword->get('password')) <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div> @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
             @if($errors->updatePassword->get('password_confirmation')) <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div> @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            @if (session('status') === 'password-updated')
                <p class="text-success small mb-0">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>