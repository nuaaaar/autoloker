
<div id="registerSecurityPage" class="validate-form register-security-light" style="display: none;">

    <!-- Progress -->
    <div class="d-flex gap-2 mb-7">

        <div class="flex-grow-1 rounded-pill bg-warning"
             style="height: 4px;"></div>

        <div class="flex-grow-1 rounded-pill bg-warning"
             style="height: 4px;"></div>

        <div class="flex-grow-1 rounded-pill"
             style="height: 4px; background: #e1e7f0;"></div>

    </div>

    <!-- Back -->
    <a href="#"
       id="backToRegisterFromSecurity"
       class="security-back text-decoration-none">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali

    </a>

    <!-- Title -->
    <h2 class="fw-bolder mt-5 mb-2"
        style="color: #263f63;">

        Data Diri

    </h2>

    <p class="mb-7 fs-7"
       style="color: #8492a6; line-height: 1.7;">

        Daftarkan dirimu dan terhubung langsung dengan ratusan perusahaan
        yang butuh jasamu.

    </p>

    <!-- Registration Form -->
    <form id="formRegisterSecurity">

        <!-- Email -->
        <div class="mb-5">

            <label class="form-label fs-6 security-label">
                Email <i class="text-danger">*</i>
            </label>

            <div class="input-group security-input-group">

                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>

                <input
                    type="email"
                    name="email"
                    class="form-control required-field"
                    placeholder="email@contoh.com"
                    autocomplete="email">

            </div>

        </div>

        <!-- Password -->
        <div class="mb-5">

            <label class="form-label fs-6 security-label">
                Password <i class="text-danger">*</i>
            </label>

            <div class="input-group security-input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    type="password"
                    id="registerPassword"
                    name="password"
                    class="form-control required-field"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password">

                <button
                    type="button"
                    class="input-group-text security-password-toggle toggle-password"
                    data-target="#registerPassword"
                    aria-label="Tampilkan atau sembunyikan password">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

            <small class="security-help">
                Minimal 8 karakter, huruf besar, huruf kecil dan angka.
            </small>

        </div>

        <!-- Confirm Password -->
        <div class="mb-5">

            <label class="form-label fs-6 security-label">
                Konfirmasi Password <i class="text-danger">*</i>
            </label>

            <div class="input-group security-input-group">

                <span class="input-group-text">
                    <i class="bi bi-shield-lock"></i>
                </span>

                <input
                    type="password"
                    id="registerPasswordConfirmation"
                    name="password_confirmation"
                    class="form-control required-field"
                    placeholder="Ulangi password"
                    autocomplete="new-password">

                <button
                    type="button"
                    class="input-group-text security-password-toggle toggle-password"
                    data-target="#registerPasswordConfirmation"
                    aria-label="Tampilkan atau sembunyikan konfirmasi password">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

        </div>

        <!-- Nama Lengkap -->
        <div class="mb-5">

            <label class="form-label fs-6 security-label">
                Nama Lengkap <i class="text-danger">*</i>
            </label>

            <div class="input-group security-input-group">

                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>

                <input
                    type="text"
                    class="form-control required-field"
                    name="name"
                    placeholder="Nama lengkap Anda"
                    autocomplete="name">

            </div>

        </div>

        <!-- Nomor WhatsApp -->
        <div class="mb-5">

            <label class="form-label fs-6 security-label">
                Nomor WhatsApp Aktif <i class="text-danger">*</i>
            </label>

            <div class="d-flex gap-2">

                <!-- Country Prefix -->
                <div class="input-group security-input-group"
                     style="width: 112px; flex-shrink: 0;">

                    <span class="input-group-text justify-content-center w-100">
                        🇮🇩
                        <span class="ms-2 fw-semibold">+62</span>
                    </span>

                </div>

                <!-- Phone Number -->
                <div class="input-group flex-grow-1 security-input-group">

                    <input
                        type="text"
                        name="phone_number"
                        id="phone_number"
                        class="form-control required-field"
                        placeholder="8xxxxxxxxxx"
                        inputmode="numeric"
                        autocomplete="tel-national">

                </div>

            </div>

            <small class="security-help">
                Masukkan nomor tanpa angka 0 di depan. Contoh: 81234567890.
            </small>

        </div>

        <!-- Agreement -->
        <div class="form-check mt-6">

            <input
                name="agree"
                class="form-check-input custom-checkbox required-field"
                type="checkbox"
                id="agree">

            <label class="form-check-label security-agreement"
                   for="agree">

                Saya menyetujui

                <a href="#" class="security-highlight">
                    Syarat &amp; Ketentuan
                </a>

                serta

                <a href="#" class="security-highlight">
                    Kebijakan Privasi
                </a>

                AutoLoker.

            </label>

        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="btn btn-warning w-100 mt-6 py-3 fw-bold submit-btn security-submit">

            Daftar Sekarang
            <i class="bi bi-arrow-right ms-2"></i>

        </button>

    </form>

    <!-- Divider -->
    <div class="d-flex align-items-center my-7">

        <div class="flex-grow-1 security-divider"></div>

        <span class="mx-4 text-muted fs-8">
            atau
        </span>

        <div class="flex-grow-1 security-divider"></div>

    </div>

    <!-- Google Registration -->
    <a class="security-google-link"
       href="{{ route('google.login', [
            'role' => 'satpam',
            'action' => 'register'
       ]) }}">

        <button
            type="button"
            class="btn w-100 py-3 security-google-button">

            <img
                src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                width="18"
                height="18"
                class="me-3"
                alt="Google">

            <span class="fw-bold fs-6">
                Daftar dengan Google
            </span>

        </button>

    </a>

    <!-- Back to Login -->
    <div class="text-center mt-7">

        <span class="text-muted fs-8">
            Sudah punya akun?
        </span>

        <a href="#"
           id="btnBackLogin"
           class="fw-bold text-decoration-none security-highlight ms-1">

            Masuk di sini

        </a>

    </div>

</div>

<!-- ========================================= -->
<!-- LIGHT THEME CSS -->
<!-- ========================================= -->

<style>
    .register-security-light {
        color: #263247;
    }

    .register-security-light .security-back {
        color: #718096;
        font-size: 13px;
        font-weight: 500;
        transition: color .2s ease;
    }

    .register-security-light .security-back:hover {
        color: #c58a00;
    }

    .register-security-light .security-label {
        color: #34445d !important;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .register-security-light .security-input-group {
        overflow: hidden;
        min-width: 0;
        background: #ffffff;
        border: 1px solid #dce4ef;
        border-radius: 9px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .register-security-light .security-input-group:focus-within {
        border-color: #e5a000;
        box-shadow: 0 0 0 3px rgba(229, 160, 0, .10);
    }

    .register-security-light .security-input-group .input-group-text {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border: 0;
        background: #ffffff;
        color: #8492a6;
    }

    .register-security-light .security-input-group .form-control {
        min-width: 0;
        height: 48px;
        padding: 10px 12px;
        border: 0 !important;
        background: #ffffff !important;
        color: #263247 !important;
        font-size: 14px;
        box-shadow: none !important;
    }

    .register-security-light .security-input-group .form-control::placeholder {
        color: #a1adbd !important;
        opacity: 1;
    }

    .register-security-light .security-password-toggle {
        cursor: pointer;
        transition: color .2s ease;
    }

    .register-security-light .security-password-toggle:hover {
        color: #263f63;
    }

    .register-security-light .security-help {
        display: block;
        margin-top: 7px;
        color: #8492a6;
        font-size: 11px;
        line-height: 1.6;
    }

    .register-security-light .security-agreement {
        color: #64748b;
        font-size: 12px;
        line-height: 1.8;
        cursor: pointer;
    }

    .register-security-light .security-highlight {
        color: #c58a00 !important;
        text-decoration: none;
        font-weight: 600;
    }

    .register-security-light .security-highlight:hover {
        color: #9e6c00 !important;
        text-decoration: underline;
    }

    .register-security-light .security-divider {
        height: 1px;
        background: #e1e7f0;
    }

    .register-security-light .security-google-link {
        display: block;
        text-decoration: none;
    }

    .register-security-light .security-google-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff !important;
        color: #34445d !important;
        border: 1px solid #dce4ef !important;
        border-radius: 10px;
        transition: all .2s ease;
    }

    .register-security-light .security-google-button:hover {
        background: #f8fafc !important;
        border-color: #c4cfdf !important;
        box-shadow: 0 4px 12px rgba(35, 55, 90, .06);
    }

    .register-security-light .security-submit {
        color: #263247 !important;
        background: #f5b82e !important;
        border-color: #f5b82e !important;
        border-radius: 10px;
        box-shadow: 0 5px 12px rgba(229, 160, 0, .13);
        transition: all .2s ease;
    }

    .register-security-light .security-submit:hover {
        background: #e9a916 !important;
        border-color: #e9a916 !important;
        transform: translateY(-1px);
    }

    .register-security-light .custom-checkbox {
        border-color: #cbd5e1;
        cursor: pointer;
    }

    .register-security-light .custom-checkbox:checked {
        background-color: #e5a000;
        border-color: #e5a000;
    }

    .register-security-light .custom-checkbox:focus {
        box-shadow: 0 0 0 3px rgba(229, 160, 0, .15);
    }

    @media (max-width: 380px) {
        .register-security-light .security-input-group .form-control {
            padding-left: 9px;
            padding-right: 9px;
            font-size: 13px;
        }

        .register-security-light .security-agreement {
            font-size: 11px;
        }
    }
</style>
