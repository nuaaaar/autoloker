
<div id="registerCompanyPage" class="validate-form register-company-light" style="display: none;">

    <!-- Progress -->
    <div class="d-flex gap-2 mb-7">

        <div class="flex-grow-1 rounded-pill bg-warning"
             style="height: 4px;">
        </div>

        <div class="flex-grow-1 rounded-pill bg-warning"
             style="height: 4px;">
        </div>

        <div class="flex-grow-1 rounded-pill"
             style="height: 4px; background: #e1e7f0;">
        </div>

    </div>

    <!-- Back -->
    <a href="#"
       id="backToRegisterFromCompany"
       class="register-back text-decoration-none">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali

    </a>

    <!-- Title -->
    <h2 class="fw-bolder mt-5 mb-2"
        style="color: #263f63;">

        Data Perusahaan

    </h2>

    <p class="mb-7 fs-7"
       style="color: #8492a6; line-height: 1.7;">

        Daftarkan perusahaan Anda dan temukan personil tersertifikasi
        dengan cepat.

    </p>

    <!-- Registration Form -->
    <form id="formRegisterCompany">

        <!-- Nama Perusahaan -->
        <div class="mb-5">

            <label class="form-label fs-6 register-label">
                Nama Perusahaan / Instansi
                <i class="text-danger">*</i>
            </label>

            <div class="input-group register-input-group">

                <span class="input-group-text">
                    <i class="bi bi-building"></i>
                </span>

                <input
                    type="text"
                    class="form-control required-field"
                    name="name"
                    placeholder="PT Nama Perusahaan Anda"
                    autocomplete="organization">

            </div>

        </div>

        <!-- Email -->
        <div class="mb-5">

            <label class="form-label fs-6 register-label">
                Email Resmi Perusahaan
                <i class="text-danger">*</i>
            </label>

            <div class="input-group register-input-group">

                <span class="input-group-text">
                    <i class="bi bi-globe"></i>
                </span>

                <input
                    type="email"
                    class="form-control required-field"
                    name="email"
                    placeholder="hrd@perusahaan.com"
                    autocomplete="email">

            </div>

            <small class="register-help">
                Gunakan email domain perusahaan untuk verifikasi lebih cepat.
            </small>

        </div>

        <!-- Password -->
        <div class="mb-5">

            <label class="form-label fs-6 register-label">
                Password
                <i class="text-danger">*</i>
            </label>

            <div class="input-group register-input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    type="password"
                    id="registerPasswordCompany"
                    name="password"
                    class="form-control required-field"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password">

                <button
                    type="button"
                    class="input-group-text register-password-toggle toggle-password"
                    data-target="#registerPasswordCompany"
                    aria-label="Tampilkan atau sembunyikan password">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

            <small class="register-help">
                Minimal 8 karakter, huruf besar, huruf kecil dan angka.
            </small>

        </div>

        <!-- Confirm Password -->
        <div class="mb-5">

            <label class="form-label fs-6 register-label">
                Konfirmasi Password
                <i class="text-danger">*</i>
            </label>

            <div class="input-group register-input-group">

                <span class="input-group-text">
                    <i class="bi bi-shield-lock"></i>
                </span>

                <input
                    type="password"
                    id="registerPasswordConfirmationCompany"
                    name="password_confirmation"
                    class="form-control required-field"
                    placeholder="Ulangi password"
                    autocomplete="new-password">

                <button
                    type="button"
                    class="input-group-text register-password-toggle toggle-password"
                    data-target="#registerPasswordConfirmationCompany"
                    aria-label="Tampilkan atau sembunyikan konfirmasi password">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

        </div>

        <!-- NIB -->
        <div class="mb-5">

            <label class="form-label fs-6 register-label">

                NIB / Nomor Induk Berusaha

                <span class="register-optional">
                    (opsional)
                </span>

            </label>

            <div class="input-group register-input-group">

                <span class="input-group-text">
                    <i class="bi bi-file-earmark-text"></i>
                </span>

                <input
                    type="text"
                    class="form-control"
                    name="nib"
                    placeholder="12345678901234"
                    inputmode="numeric">

            </div>

        </div>

        <!-- Agreement -->
        <div class="form-check mt-6">

            <input
                name="agree"
                class="form-check-input custom-checkbox required-field"
                type="checkbox"
                id="agree">

            <label class="form-check-label register-agreement"
                   for="agree">

                Saya menyetujui

                <a href="#"
                   class="register-highlight">
                    Syarat &amp; Ketentuan
                </a>

                serta

                <a href="#"
                   class="register-highlight">
                    Kebijakan Privasi
                </a>

                AutoLoker.

            </label>

        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="btn btn-warning w-100 mt-6 py-3 fw-bold submit-btn register-submit">

            Daftar Sekarang
            <i class="bi bi-arrow-right ms-2"></i>

        </button>

    </form>

    <!-- Divider -->
    <div class="d-flex align-items-center my-7">

        <div class="flex-grow-1 register-divider"></div>

        <span class="mx-4 text-muted fs-8">
            atau
        </span>

        <div class="flex-grow-1 register-divider"></div>

    </div>

    <!-- Google Registration -->
    <a class="register-google-link"
       href="{{ route('google.login', [
            'role' => 'company',
            'action' => 'register'
       ]) }}">

        <button
            type="button"
            class="btn w-100 py-3 register-google-button">

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
           class="fw-bold text-decoration-none register-highlight ms-1">

            Masuk di sini

        </a>

    </div>

</div>

<!-- ========================================= -->
<!-- LIGHT THEME CSS -->
<!-- ========================================= -->

<style>
    .register-company-light {
        color: #263247;
    }

    .register-company-light .register-back {
        color: #718096;
        font-size: 13px;
        font-weight: 500;
        transition: color .2s ease;
    }

    .register-company-light .register-back:hover {
        color: #c58a00;
    }

    .register-company-light .register-label {
        color: #34445d !important;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .register-company-light .register-input-group {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #dce4ef;
        border-radius: 9px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .register-company-light .register-input-group:focus-within {
        border-color: #e5a000;
        box-shadow: 0 0 0 3px rgba(229, 160, 0, .10);
    }

    .register-company-light .register-input-group .input-group-text {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 46px;
        padding: 12px;
        border: 0;
        background: #ffffff;
        color: #8492a6;
    }

    .register-company-light .register-input-group .form-control {
        min-width: 0;
        height: 48px;
        padding: 10px 12px;
        border: 0 !important;
        outline: none;
        background: #ffffff !important;
        color: #263247 !important;
        font-size: 14px;
        box-shadow: none !important;
    }

    .register-company-light .register-input-group .form-control::placeholder {
        color: #a1adbd !important;
        opacity: 1;
    }

    .register-company-light .register-input-group .form-control:focus {
        background: #ffffff !important;
        color: #263247 !important;
    }

    .register-company-light .register-password-toggle {
        cursor: pointer;
        transition: color .2s ease;
    }

    .register-company-light .register-password-toggle:hover {
        color: #263f63;
    }

    .register-company-light .register-help {
        display: block;
        margin-top: 7px;
        color: #8492a6;
        font-size: 11px;
        line-height: 1.6;
    }

    .register-company-light .register-optional {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 400;
    }

    .register-company-light .register-agreement {
        color: #64748b;
        font-size: 12px;
        line-height: 1.8;
        cursor: pointer;
    }

    .register-company-light .register-highlight {
        color: #c58a00 !important;
        text-decoration: none;
        font-weight: 600;
    }

    .register-company-light .register-highlight:hover {
        color: #9e6c00 !important;
        text-decoration: underline;
    }

    .register-company-light .register-divider {
        height: 1px;
        background: #e1e7f0;
    }

    .register-company-light .register-google-link {
        display: block;
        text-decoration: none;
    }

    .register-company-light .register-google-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff !important;
        color: #34445d !important;
        border: 1px solid #dce4ef !important;
        border-radius: 10px;
        transition: all .2s ease;
    }

    .register-company-light .register-google-button:hover {
        background: #f8fafc !important;
        border-color: #c4cfdf !important;
        box-shadow: 0 4px 12px rgba(35, 55, 90, .06);
    }

    .register-company-light .register-submit {
        border-radius: 10px;
        color: #263247 !important;
        background: #f5b82e !important;
        border-color: #f5b82e !important;
        box-shadow: 0 5px 12px rgba(229, 160, 0, .13);
        transition: all .2s ease;
    }

    .register-company-light .register-submit:hover {
        background: #e9a916 !important;
        border-color: #e9a916 !important;
        transform: translateY(-1px);
    }

    .register-company-light .custom-checkbox {
        border-color: #cbd5e1;
        cursor: pointer;
    }

    .register-company-light .custom-checkbox:checked {
        background-color: #e5a000;
        border-color: #e5a000;
    }

    .register-company-light .custom-checkbox:focus {
        box-shadow: 0 0 0 3px rgba(229, 160, 0, .15);
    }
</style>
