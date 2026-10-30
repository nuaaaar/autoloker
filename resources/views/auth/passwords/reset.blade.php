
@extends('layouts.auth')

@section('title', 'Reset Password - Autoloker')

@section('left-panel')

<style>
    /* =====================================================
       RESET PASSWORD - LEFT PANEL
    ===================================================== */

    .reset-left {
        --reset-primary: #E8A400;
        --reset-primary-light: #F5B301;
        --reset-dark: #263247;
        --reset-muted: #64748B;

        position: relative;
        display: flex;
        width: 100%;
        min-height: 100vh;
        overflow: hidden;
        isolation: isolate;
        background:
            radial-gradient(
                circle at 15% 15%,
                rgba(245, 179, 1, .17),
                transparent 35%
            ),
            radial-gradient(
                circle at 85% 80%,
                rgba(232, 164, 0, .13),
                transparent 35%
            ),
            linear-gradient(145deg, #ffffff 0%, #fffdf6 55%, #fff8e7 100%);
    }

    /* Mengatasi wrapper display:none dari layouts.auth */
    .left-panel > div {
        display: flex !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .reset-left *,
    .reset-left *::before,
    .reset-left *::after {
        box-sizing: border-box;
    }

    /* Abstract background */
    .reset-left .abstract-circle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: -1;
    }

    .reset-left .circle-one {
        width: 430px;
        height: 430px;
        top: -190px;
        right: -150px;
        border: 1px solid rgba(232, 164, 0, .22);
        box-shadow:
            0 0 0 35px rgba(232, 164, 0, .035),
            0 0 0 75px rgba(232, 164, 0, .025);
    }

    .reset-left .circle-two {
        width: 300px;
        height: 300px;
        bottom: -130px;
        left: -120px;
        background: rgba(245, 179, 1, .08);
        border: 1px solid rgba(232, 164, 0, .15);
    }

    .reset-left .circle-three {
        width: 130px;
        height: 130px;
        top: 42%;
        right: -65px;
        background: rgba(245, 179, 1, .10);
        filter: blur(2px);
    }

    /* Decorative grid */
    .reset-left .reset-grid {
        position: absolute;
        inset: 0;
        z-index: -1;
        opacity: .28;
        background-image:
            linear-gradient(rgba(232, 164, 0, .08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(232, 164, 0, .08) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: linear-gradient(
            135deg,
            transparent 5%,
            black 50%,
            transparent 100%
        );
    }

    /* Main content */
    .reset-left .reset-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
        min-height: 100vh;
        padding: 48px 55px;
    }

    /* Logo */
    .reset-left .reset-logo {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        width: fit-content;
        padding: 12px 18px;
        background: rgba(255, 255, 255, .85);
        border: 1px solid rgba(232, 164, 0, .17);
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(35, 45, 60, .05);
    }

    .reset-left .reset-logo img {
        width: auto;
        max-width: 175px;
        max-height: 43px;
        object-fit: contain;
    }

    /* Main illustration */
    .reset-left .reset-visual {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 500px;
        height: 290px;
        margin: 0 auto 35px;
    }

    .reset-left .visual-glow {
        position: absolute;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(245, 179, 1, .18);
        filter: blur(55px);
    }

    .reset-left .visual-card {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 210px;
        height: 210px;
        border: 1px solid rgba(232, 164, 0, .25);
        border-radius: 48px;
        background: linear-gradient(145deg, #ffffff, #fff7df);
        box-shadow:
            0 25px 65px rgba(181, 130, 0, .12),
            inset 0 1px 0 #ffffff;
        transform: rotate(-8deg);
    }

    .reset-left .visual-card::before {
        content: "";
        position: absolute;
        inset: 13px;
        border: 1px dashed rgba(232, 164, 0, .25);
        border-radius: 38px;
    }

    .reset-left .visual-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 112px;
        height: 112px;
        border-radius: 35px;
        background: linear-gradient(
            145deg,
            #F5B301,
            #E8A400
        );
        color: #ffffff;
        font-size: 55px;
        box-shadow: 0 15px 35px rgba(232, 164, 0, .28);
        transform: rotate(8deg);
    }

    /* Floating elements */
    .reset-left .floating-item {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        border: 1px solid #f0e2bd;
        border-radius: 18px;
        background: rgba(255, 255, 255, .95);
        color: #D99A00;
        font-size: 23px;
        box-shadow: 0 12px 30px rgba(35, 45, 60, .08);
    }

    .reset-left .floating-one {
        top: 15px;
        left: 55px;
        transform: rotate(-12deg);
    }

    .reset-left .floating-two {
        right: 55px;
        bottom: 15px;
        transform: rotate(12deg);
    }

    .reset-left .floating-three {
        top: 35px;
        right: 85px;
        width: 43px;
        height: 43px;
        border-radius: 14px;
        font-size: 17px;
    }

    /* Text */
    .reset-left .reset-heading {
        max-width: 600px;
        margin: 0 auto;
        color: var(--reset-dark);
        font-size: clamp(30px, 3vw, 43px);
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -1.4px;
        text-align: center;
    }

    .reset-left .reset-heading span {
        color: var(--reset-primary);
    }

    .reset-left .reset-description {
        max-width: 500px;
        margin: 18px auto 0;
        color: var(--reset-muted);
        font-size: 15px;
        line-height: 1.9;
        text-align: center;
    }

    /* Security note */
    .reset-left .reset-security {
        display: flex;
        align-items: center;
        gap: 14px;
        max-width: 440px;
        margin: 32px auto 0;
        padding: 16px 20px;
        border: 1px solid rgba(232, 164, 0, .20);
        border-radius: 18px;
        background: rgba(255, 255, 255, .78);
        box-shadow: 0 8px 25px rgba(35, 45, 60, .035);
    }

    .reset-left .security-icon {
        display: flex;
        flex: 0 0 43px;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        border-radius: 14px;
        background: #fff3cd;
        color: #B98200;
        font-size: 20px;
    }

    .reset-left .security-text strong {
        display: block;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .reset-left .security-text span {
        display: block;
        margin-top: 3px;
        color: #8792A4;
        font-size: 12px;
        line-height: 1.6;
    }

    /* Footer */
    .reset-left .reset-footer {
        color: #94A3B8;
        font-size: 12px;
        text-align: center;
    }

    /* =====================================================
       RIGHT PANEL
    ===================================================== */

    .reset-right {
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
    }

    .reset-right .reset-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin-bottom: 25px;
        border: 1px solid #f2dfad;
        border-radius: 20px;
        background: #fff7df;
        color: #D99A00;
        font-size: 28px;
    }

    .reset-right .reset-title {
        color: #263247;
        font-size: 29px;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .reset-right .reset-subtitle {
        color: #7b879b;
        font-size: 14px;
        line-height: 1.8;
    }

    .reset-right .form-label {
        color: #475569;
        font-size: 13px;
        font-weight: 700;
    }

    .reset-right .form-control {
        height: 56px;
        border-radius: 12px;
        border-color: #dce2ec;
        font-size: 14px;
    }

    .reset-right .form-control:focus {
        border-color: #E8A400;
        box-shadow: 0 0 0 3px rgba(232, 164, 0, .12);
    }

    .reset-right .input-group .btn {
        border-color: #dce2ec;
        background: #ffffff;
        color: #8792A4;
    }

    .reset-right .btn-reset {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 55px;
        border: 0;
        border-radius: 13px;
        background: linear-gradient(135deg, #F5B301, #E8A400);
        color: #242424;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(232, 164, 0, .20);
        transition: .25s;
    }

    .reset-right .btn-reset:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #E8A400, #D99A00);
        box-shadow: 0 12px 25px rgba(232, 164, 0, .25);
    }

    .reset-right .reset-back {
        color: #8a94a6;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .reset-right .reset-back:hover {
        color: #B98200;
    }

    .reset-right .password-hint {
        color: #94a3b8;
        font-size: 11px;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 991.98px) {
        .reset-left {
            min-height: auto;
        }

        .reset-left .reset-content {
            min-height: auto;
            padding: 35px 25px;
        }

        .reset-left .reset-visual {
            height: 220px;
            margin: 30px auto 20px;
        }

        .reset-left .visual-card {
            width: 155px;
            height: 155px;
            border-radius: 35px;
        }

        .reset-left .visual-icon {
            width: 85px;
            height: 85px;
            font-size: 42px;
            border-radius: 27px;
        }

        .reset-left .reset-footer {
            margin-top: 35px;
        }
    }

    @media (max-width: 575.98px) {
        .reset-left .reset-content {
            padding: 25px 20px;
        }

        .reset-left .reset-logo img {
            max-width: 145px;
            max-height: 35px;
        }

        .reset-left .reset-visual {
            height: 180px;
        }

        .reset-left .visual-card {
            width: 130px;
            height: 130px;
        }

        .reset-left .visual-icon {
            width: 72px;
            height: 72px;
            font-size: 35px;
        }

        .reset-left .floating-item {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            font-size: 18px;
        }

        .reset-left .floating-one {
            left: 15px;
        }

        .reset-left .floating-two {
            right: 15px;
        }

        .reset-left .floating-three {
            right: 35px;
            width: 35px;
            height: 35px;
        }

        .reset-left .reset-heading {
            font-size: 27px;
        }

        .reset-left .reset-description {
            font-size: 13px;
        }

        .reset-left .reset-security {
            margin-top: 22px;
            padding: 13px;
        }

        .reset-right .reset-title {
            font-size: 25px;
        }
    }
</style>

<div class="reset-left">

    <div class="reset-grid"></div>

    <div class="abstract-circle circle-one"></div>
    <div class="abstract-circle circle-two"></div>
    <div class="abstract-circle circle-three"></div>

    <div class="reset-content">

        {{-- LOGO --}}
        <div>
            <div class="reset-logo">
                <img
                    src="{{ asset('assets/media/logos/autoloker-logo-small.png') }}"
                    alt="Autoloker"
                >
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="my-auto">

            {{-- ABSTRACT VISUAL --}}
            <div class="reset-visual">

                <div class="visual-glow"></div>

                <div class="floating-item floating-one">
                    <i class="bi bi-key"></i>
                </div>

                <div class="floating-item floating-two">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div class="floating-item floating-three">
                    <i class="bi bi-stars"></i>
                </div>

                <div class="visual-card">
                    <div class="visual-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                </div>

            </div>

            {{-- HEADING --}}
            <h1 class="reset-heading">
                Keamanan Akun
                <span>Dimulai dari Anda.</span>
            </h1>

            <p class="reset-description">
                Buat password baru yang kuat untuk menjaga keamanan
                akun Autoloker Anda. Pastikan hanya Anda yang
                mengetahui password tersebut.
            </p>

            {{-- SECURITY INFORMATION --}}
            <div class="reset-security">

                <div class="security-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div class="security-text">
                    <strong>Perlindungan Akun Autoloker</strong>
                    <span>
                        Gunakan password yang unik dan jangan
                        membagikannya kepada siapa pun.
                    </span>
                </div>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="reset-footer">
            &copy; {{ date('Y') }} Autoloker. All Rights Reserved.
        </div>

    </div>

</div>

@endsection


@section('right-panel')

<div class="reset-right">

    {{-- ICON --}}
    <div class="reset-icon">
        <i class="bi bi-shield-lock"></i>
    </div>

    {{-- HEADING --}}
    <div class="mb-8">

        <h1 class="reset-title mb-3">
            Buat Password Baru
        </h1>

        <p class="reset-subtitle mb-0">
            Silakan buat password baru untuk akun Anda.
            Pastikan password mudah Anda ingat dan sulit ditebak.
        </p>

    </div>

    {{-- STATUS ERROR --}}
    @if ($errors->any())

        <div class="alert alert-danger d-flex align-items-start mb-6">

            <i class="bi bi-exclamation-circle fs-4 me-3 mt-1"></i>

            <div>
                <strong>Password gagal diperbarui.</strong>

                <ul class="mb-0 mt-2 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    @endif

    {{-- RESET PASSWORD FORM --}}
    <form
        method="POST"
        action="{{ route('password.update') }}"
        id="resetPasswordForm"
    >

        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ $token }}"
        >

        {{-- EMAIL --}}
        <div class="mb-6">

            <label class="form-label mb-2">
                Alamat Email
            </label>

            <div class="position-relative">

                <i class="bi bi-envelope position-absolute top-50 translate-middle-y ms-4 text-muted"></i>

                <input
                    type="email"
                    name="email"
                    class="form-control ps-12"
                    value="{{ old('email', $email) }}"
                    placeholder="Masukkan alamat email"
                    required
                    readonly
                >

            </div>

        </div>


        {{-- PASSWORD BARU --}}
        <div class="mb-5">
            <label class="form-label mb-2">
                Password Baru
            </label>

            <div class="input-group input-group-lg login-input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    type="password"
                    name="password"
                    id="newPassword"
                    class="form-control required-field"
                    placeholder="Masukkan password baru"
                    autocomplete="new-password"
                    required>

                <button
                    type="button"
                    id="toggleNewPassword"
                    class="input-group-text login-password-toggle"
                    aria-label="Tampilkan atau sembunyikan password baru">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

            <div class="password-hint mt-2">
                Password minimal terdiri dari 8 karakter.
            </div>
        </div>


        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-8">
            <label class="form-label mb-2">
                Konfirmasi Password Baru
            </label>

            <div class="input-group input-group-lg login-input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    type="password"
                    name="password_confirmation"
                    id="confirmPassword"
                    class="form-control required-field"
                    placeholder="Konfirmasi password baru"
                    autocomplete="new-password"
                    required>

                <button
                    type="button"
                    id="toggleConfirmPassword"
                    class="input-group-text login-password-toggle"
                    aria-label="Tampilkan atau sembunyikan konfirmasi password">

                    <i class="bi bi-eye"></i>

                </button>

            </div>
        </div>


        {{-- SUBMIT --}}
        <button
            type="submit"
            class="btn-reset"
            id="btnResetPassword"
        >

            <span class="indicator-label">
                <i class="bi bi-check-circle me-2"></i>
                Simpan Password Baru
            </span>

        </button>

    </form>


    {{-- BACK TO LOGIN --}}
    <div class="text-center mt-8">

        <a href="{{ route('login') }}" class="reset-back">

            <i class="bi bi-arrow-left me-2"></i>

            Kembali ke halaman login

        </a>

    </div>

</div>

@endsection

@section('script')

<script>
   // Toggle Password Baru
    $('#toggleNewPassword').on('click', function () {
        let password = $('#newPassword');

        if (password.attr('type') === 'password') {
            password.attr('type', 'text');

            $(this).find('i')
                .removeClass('bi-eye')
                .addClass('bi-eye-slash');
        } else {
            password.attr('type', 'password');

            $(this).find('i')
                .removeClass('bi-eye-slash')
                .addClass('bi-eye');
        }
    });

    // Toggle Konfirmasi Password
    $('#toggleConfirmPassword').on('click', function () {
        let password = $('#confirmPassword');

        if (password.attr('type') === 'password') {
            password.attr('type', 'text');

            $(this).find('i')
                .removeClass('bi-eye')
                .addClass('bi-eye-slash');
        } else {
            password.attr('type', 'password');

            $(this).find('i')
                .removeClass('bi-eye-slash')
                .addClass('bi-eye');
        }
    });
</script>

@endsection
