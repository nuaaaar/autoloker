<div class="modal fade"
     id="forgotPasswordModal"
     tabindex="-1"
     aria-labelledby="forgotPasswordModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">
                    Lupa Kata Sandi?
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <p class="text-muted">
                        Masukkan alamat email yang terdaftar.
                        Kami akan mengirimkan link untuk mengatur ulang kata sandi Anda.
                    </p>

                    {{-- Notifikasi Berhasil --}}
                    @if (session('forgot_success'))
                        <div class="alert alert-success d-flex align-items-start"
                             role="alert">
                            <i class="ki-duotone ki-check-circle fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            <div>
                                {{ session('forgot_success') }}
                            </div>
                        </div>
                    @endif

                    {{-- Notifikasi Gagal --}}
                    @if (session('forgot_error'))
                        <div class="alert alert-danger d-flex align-items-start"
                             role="alert">
                            <i class="ki-duotone ki-cross-circle fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            <div>
                                {{ session('forgot_error') }}
                            </div>
                        </div>
                    @endif

                    {{-- Notifikasi Validasi --}}
                    @if ($errors->has('email'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="forgot_email" class="form-label">
                            Alamat Email
                        </label>

                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="forgot_email"
                               name="email"
                               placeholder="Masukkan email Anda"
                               value="{{ old('email') }}"
                               required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <small class="text-muted">
                        Link reset password berlaku selama 24 jam.
                    </small>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-warning">
                        Kirim Link Reset Password
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>