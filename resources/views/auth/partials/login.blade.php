
<div id="loginPage" class="validate-form login-page-light">

    <!-- Title -->
    <h1 class="fs-2 fw-bolder mb-1" style="color: #263f63;">
        Masuk ke Akun Anda
    </h1>

    <p class="fs-7 mb-3" style="color: #8492a6;">
        Pilih peran Anda untuk melanjutkan
    </p>

    <!-- Role Selector -->
    <div class="rounded-pill p-1 d-flex mb-3 mt-3"
         style="background: #edf1f7; border: 1px solid #e1e7f0;">

        <button
            type="button"
            class="btn btn-warning rounded-pill fw-bold flex-fill text-dark role-btn btnSatpam active">

            👤 Satpam / Cleaning Service

        </button>

        <button
            type="button"
            class="btn rounded-pill fw-bold flex-fill role-btn text-muted btnPerusahaan">

            🏢 Perusahaan

        </button>

    </div>

    <!-- ========================================= -->
    <!-- LOGIN SATPAM -->
    <!-- ========================================= -->

    <div class="loginSatpam">

        <!-- Tabs -->
        <ul class="nav custom-tabs mb-5">

            <li class="nav-item">
                <a class="nav-link active fw-bold fs-8 px-0 me-3"
                   data-bs-toggle="tab"
                   href="#login-password">

                    Email / Password

                </a>
            </li>

            {{-- Tab WhatsApp OTP dapat diaktifkan kembali jika diperlukan
            <li class="nav-item">
                <a class="nav-link fw-bold fs-8 px-0"
                   data-bs-toggle="tab"
                   href="#login-otp">
                    WhatsApp OTP
                </a>
            </li>
            --}}

        </ul>

        <div class="tab-content">

            <!-- Password Login -->
            <div class="tab-pane fade show active" id="login-password">

                <form id="formLoginSatpam">

                    <input type="hidden" name="role" value="satpam">

                    <!-- Email / WhatsApp -->
                    <div class="mb-5">

                        <label class="form-label fw-semibold fs-6 login-label">
                            Email / No. WhatsApp
                        </label>

                        <div class="input-group input-group-lg login-input-group">

                            <span class="input-group-text">
                                <i class="bi bi-chat-left"></i>
                            </span>

                            <input
                                type="text"
                                name="email"
                                class="form-control required-field"
                                id="email"
                                placeholder="08xxxxxxxxxx atau email@anda.com"
                                autocomplete="username">

                        </div>

                    </div>

                    <!-- Password -->
                    <div class="mb-3">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="form-label fw-semibold fs-6 mb-0 login-label">
                                Kata Sandi
                            </label>

                            <a href="#"
                               class="fw-bold text-decoration-none login-link">

                                Lupa kata sandi?

                            </a>

                        </div>

                        <div class="input-group input-group-lg login-input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control required-field"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password">

                            <button
                                type="button"
                                id="togglePassword"
                                class="input-group-text login-password-toggle"
                                aria-label="Tampilkan atau sembunyikan kata sandi">

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        class="btn btn-warning w-100 py-3 fw-bold fs-6 mt-6 login-submit"
                        id="btnLogin">

                        Masuk Sekarang
                        <i class="bi bi-arrow-right ms-2"></i>

                    </button>

                </form>

            </div>

            <!-- OTP Login -->
            <div class="tab-pane fade" id="login-otp">

                <label class="form-label fw-semibold fs-6 mb-1 login-label">
                    No. WhatsApp
                </label>

                <div class="input-group input-group-lg mb-6 login-input-group">

                    <span class="input-group-text">
                        🇮🇩
                        <span class="ms-2 fw-semibold">+62</span>
                    </span>

                    <input
                        type="text"
                        id="phone_number"
                        class="form-control required-field"
                        placeholder="81234567890"
                        inputmode="numeric">

                </div>

                <button
                    type="button"
                    class="btn btn-success w-100 py-3 fw-bold fs-6"
                    id="btnOtp"
                    disabled>

                    Kirim OTP

                </button>

            </div>

        </div>

        <!-- Divider -->
        <div class="d-flex align-items-center my-7">

            <div class="flex-grow-1 login-divider"></div>

            <span class="mx-4 text-muted fs-8 text-nowrap">
                atau masuk dengan
            </span>

            <div class="flex-grow-1 login-divider"></div>

        </div>

        <!-- Google Login -->
        <a class="login-google-link"
           href="{{ route('google.login', [
                'role' => 'satpam',
                'action' => 'login'
           ]) }}">

            <button
                type="button"
                class="btn w-100 py-3 login-google-button">

                <img
                    src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                    width="18"
                    height="18"
                    class="me-3"
                    alt="Google">

                <span class="fw-bold fs-6">
                    Masuk dengan Google
                </span>

            </button>

        </a>

        <!-- Register -->
        <div class="text-center mt-7">

            <span class="text-muted fs-8">
                Belum punya akun?
            </span>

            <a href="#"
               id="showRegister"
               class="fw-bold text-decoration-none login-link ms-1">

                Daftar Sekarang

            </a>

        </div>

    </div>

    <!-- ========================================= -->
    <!-- LOGIN PERUSAHAAN -->
    <!-- ========================================= -->

    <div class="loginPerusahaan" style="display: none;">

        <div class="tab-content">

            <!-- Password Login -->
            <div class="tab-pane fade show active" id="login-password-company">

                <form id="formLoginCompany">

                    <input type="hidden" name="role" value="company">

                    <!-- Email Company -->
                    <div class="mb-5">

                        <label class="form-label fw-semibold fs-6 login-label">
                            Email Perusahaan
                        </label>

                        <div class="input-group input-group-lg login-input-group">

                            <span class="input-group-text">
                                <i class="bi bi-globe"></i>
                            </span>

                            <input
                                type="text"
                                name="email"
                                class="form-control required-field"
                                id="emailCompany"
                                placeholder="hrd@perusahaan.com"
                                autocomplete="username">

                        </div>

                    </div>

                    <!-- Password Company -->
                    <div class="mb-3">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="form-label fw-semibold fs-6 mb-0 login-label">
                                Kata Sandi
                            </label>

                            <a href="#"
                               class="fw-bold text-decoration-none login-link">

                                Lupa kata sandi?

                            </a>

                        </div>

                        <div class="input-group input-group-lg login-input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="passwordCompany"
                                class="form-control required-field"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password">

                            <button
                                type="button"
                                id="togglePasswordCompany"
                                class="input-group-text login-password-toggle"
                                aria-label="Tampilkan atau sembunyikan kata sandi">

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>

                    <!-- Login Company -->
                    <button
                        type="submit"
                        class="btn btn-warning w-100 py-3 fw-bold fs-6 mt-6 login-submit"
                        id="btnLoginCompany">

                        Masuk Sekarang
                        <i class="bi bi-arrow-right ms-2"></i>

                    </button>

                </form>

            </div>

        </div>

        <!-- Divider -->
        <div class="d-flex align-items-center my-7">

            <div class="flex-grow-1 login-divider"></div>

            <span class="mx-4 text-muted fs-8 text-nowrap">
                atau masuk dengan
            </span>

            <div class="flex-grow-1 login-divider"></div>

        </div>

        <!-- Google Company -->
        <a class="login-google-link"
           href="{{ route('google.login', [
                'role' => 'company',
                'action' => 'login'
           ]) }}">

            <button
                type="button"
                class="btn w-100 py-3 login-google-button">

                <img
                    src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                    width="18"
                    height="18"
                    class="me-3"
                    alt="Google">

                <span class="fw-bold fs-6">
                    Masuk dengan Google
                </span>

            </button>

        </a>

        <!-- Register Company -->
        <div class="text-center mt-7">

            <span class="text-muted fs-8">
                Belum punya akun?
            </span>

            <a href="#"
               id="showRegisterCompany"
               class="fw-bold text-decoration-none login-link ms-1">

                Daftar Sekarang

            </a>

        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- LIGHT THEME CSS -->
<!-- ========================================= -->

<style>
    .login-page-light {
        color: #263247;
    }

    .login-page-light .login-label {
        color: #34445d !important;
    }

    .login-page-light .login-input-group {
        border: 1px solid #dce4ef;
        border-radius: 10px;
        overflow: hidden;
        background: #ffffff;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .login-page-light .login-input-group:focus-within {
        border-color: #e5a000;
        box-shadow: 0 0 0 3px rgba(229, 160, 0, .10);
    }

    .login-page-light .login-input-group .input-group-text {
        border: 0;
        background: #ffffff;
        color: #8492a6;
        padding-left: 15px;
        padding-right: 12px;
    }

    .login-page-light .login-input-group .form-control {
        background: #ffffff !important;
        color: #263247 !important;
        border: 0 !important;
        min-width: 0;
        height: 52px;
        box-shadow: none !important;
        font-size: 14px;
    }

    .login-page-light .login-input-group .form-control::placeholder {
        color: #a1adbd !important;
        opacity: 1;
    }

    .login-page-light .login-password-toggle {
        cursor: pointer;
        padding-left: 13px;
        padding-right: 15px;
    }

    .login-page-light .login-password-toggle:hover {
        color: #263f63;
    }

    .login-page-light .login-link {
        color: #c58a00 !important;
    }

    .login-page-light .login-link:hover {
        color: #9e6c00 !important;
    }

    .login-page-light .login-divider {
        height: 1px;
        background: #e1e7f0;
    }

    .login-page-light .login-google-link {
        display: block;
        text-decoration: none;
    }

    .login-page-light .login-google-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff !important;
        border: 1px solid #dce4ef !important;
        border-radius: 10px;
        color: #34445d !important;
        transition: all .2s ease;
    }

    .login-page-light .login-google-button:hover {
        background: #f8fafc !important;
        border-color: #c4cfdf !important;
        box-shadow: 0 4px 12px rgba(35, 55, 90, .06);
    }

    .login-page-light .login-submit {
        color: #263247 !important;
        background: #f5b82e !important;
        border-color: #f5b82e !important;
        border-radius: 10px;
        box-shadow: 0 5px 12px rgba(229, 160, 0, .13);
        transition: all .2s ease;
    }

    .login-page-light .login-submit:hover {
        background: #e9a916 !important;
        border-color: #e9a916 !important;
        transform: translateY(-1px);
    }

    .login-page-light .role-btn {
        font-size: 12px;
        padding: 10px 8px;
        transition: all .2s ease;
    }

    .login-page-light .role-btn:not(.active) {
        background: transparent !important;
        border-color: transparent !important;
        color: #718096 !important;
    }

    .login-page-light .role-btn.active {
        box-shadow: 0 2px 6px rgba(35, 55, 90, .08);
    }

    .login-page-light .custom-tabs .nav-link {
        color: #8492a6;
    }

    .login-page-light .custom-tabs .nav-link.active {
        color: #263f63;
        border-bottom: 2px solid #e5a000;
    }

    @media (max-width: 575px) {
        .login-page-light .role-btn {
            font-size: 11px;
            padding: 9px 5px;
        }
    }
</style>
