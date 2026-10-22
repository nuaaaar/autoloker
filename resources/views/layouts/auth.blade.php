<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign In - Autoloker</title>
        <meta charset="utf-8"/>
        <meta name="description" content="
            Platform Satpam #1 Indonesia
        "/>
        <meta name="keywords" content="
            Platform Satpam #1 Indonesia
        "/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="" />
        <meta property="og:url" content="https://keenthemes.com/metronic"/>
        <meta property="og:site_name" content="" />
        <link rel="canonical" href="http://preview.keenthemes.com/?page=authentication/layouts/corporate/sign-in"/>
        <link rel="shortcut icon" href="/assets/media/logos/autoloker-logo-small.png"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/> 
        <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone.css">

        
        <style>
            .object-fit-cover {
                object-fit: cover;
            }

            /* =====================================================
            GLOBAL LIGHT THEME
            ===================================================== */

            body {
                background: #f5f7fb;
                color: #263247;
            }

            .text-gray-300 {
                color: #64748b !important;
            }

            .text-gray-400 {
                color: #7b879b !important;
            }

            /* =====================================================
            FORM CONTROL
            ===================================================== */

            .form-control,
            .input-group-text {
                background: #ffffff !important;
                border-color: #dce2ec !important;
                color: #263247 !important;
            }

            .form-control {
                height: 62px;
            }

            .form-control::placeholder {
                color: #9aa5b7;
            }

            .form-control:focus {
                background: #ffffff !important;
                border-color: #e8a400 !important;
                color: #263247 !important;
                box-shadow: 0 0 0 0.2rem rgba(232, 164, 0, 0.12);
            }

            .input-group-text {
                color: #64748b !important;
            }

            /* =====================================================
            NAVIGATION TABS
            ===================================================== */

            .nav-line-tabs .nav-link {
                color: #64748b;
                border: 0;
                border-bottom: 3px solid transparent;
            }

            .nav-line-tabs .nav-link.active {
                color: #b98200;
                border-bottom: 3px solid #e8a400;
                background: transparent;
            }

            /* =====================================================
            BUTTONS
            ===================================================== */

            .btn-warning {
                background: #e8a400;
                border-color: #e8a400;
                color: #1b1b1b;
            }

            .btn-warning:hover,
            .btn-warning:focus {
                background: #d99a00;
                border-color: #d99a00;
                color: #1b1b1b;
            }

            .btn-dark {
                background: #334155;
                border-color: #334155;
                color: #ffffff;
            }

            .btn-dark:hover {
                background: #1e293b;
                border-color: #1e293b;
                color: #ffffff;
            }

            .rounded-pill {
                border-radius: 18px !important;
            }

            /* =====================================================
            ROLE BUTTONS
            ===================================================== */

            .role-btn {
                height: 38px;
                padding: 0 16px;
                font-size: 13px;
                font-weight: 600;
                transition: 0.25s;
                color: #64748b;
            }

            .role-btn:hover {
                color: #263247;
            }

            .role-btn.active {
                background: #f5b301;
                border-color: #f5b301;
                color: #000000 !important;
            }

            /* =====================================================
            CUSTOM TABS
            ===================================================== */

            .custom-tabs {
                border-bottom: 1px solid #dce2ec;
            }

            .custom-tabs .nav-link {
                position: relative;
                color: #64748b;
                border: none !important;
                background: transparent !important;
                padding-bottom: 12px;
                transition: 0.25s;
            }

            .custom-tabs .nav-link:hover {
                color: #263247;
            }

            .custom-tabs .nav-link::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: -1px;
                width: 100%;
                height: 2px;
                background: #263247;
                transform: scaleX(0);
                transform-origin: left;
                transition: 0.25s;
            }

            .custom-tabs .nav-link:hover::after {
                transform: scaleX(1);
            }

            .custom-tabs .nav-link.active {
                color: #b98200;
            }

            .custom-tabs .nav-link.active::after {
                background: #f5b301;
                transform: scaleX(1);
            }

            /* =====================================================
            LOGIN BUTTON
            ===================================================== */

            #btnLogin:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* =====================================================
            PHONE NUMBER
            ===================================================== */

            .country-code {
                width: 90px;
                justify-content: center;
                background: #ffffff;
                border: 1px solid #dce2ec;
                color: #263247;
                font-size: 14px;
                font-weight: 600;
            }

            #phone_number {
                background: #ffffff !important;
                border: 0;
                color: #263247 !important;
            }

            #phone_number::placeholder {
                color: #9aa5b7;
            }

            #phone_number:focus {
                background: #ffffff !important;
                color: #263247 !important;
                box-shadow: none;
                outline: none;
            }

            /* =====================================================
            LOGIN FORM WRAPPER
            ===================================================== */

            .login-form-wrapper {
                max-width: 70%;
            }

            @media (max-width: 991.98px) {
                .login-form-wrapper {
                    max-width: 100%;
                }
            }

            /* =====================================================
            REGISTRATION CARDS
            ===================================================== */

            .register-card {
                display: block;
                background: #ffffff;
                border: 1px solid #e5eaf2;
                border-radius: 28px;
                padding: 16px;
                margin-bottom: 16px;
                transition: 0.25s;
                box-shadow: 0 4px 16px rgba(31, 45, 61, 0.04);
            }

            .card-yellow {
                border: 3px solid #e8c65c;
            }

            .card-blue {
                border: 3px solid #8bb8f0;
            }

            .register-card:hover {
                transform: translateY(-3px);
                background: #fffdf7;
                box-shadow: 0 10px 24px rgba(31, 45, 61, 0.08);
            }

            .register-card i {
                transition: 0.25s;
            }

            .register-card:hover i {
                transform: translateX(5px);
                color: #b98200 !important;
            }

            /* =====================================================
            WARNING BADGE
            ===================================================== */

            .badge-warning {
                background: #fff8df;
                border: 1px solid #e8c65c;
                color: #936800;
                border-radius: 50rem;
                font-size: 12px;
                padding: 4px 8px;
                font-weight: 600;
            }

            /* =====================================================
            CUSTOM CHECKBOX
            ===================================================== */

            .custom-checkbox {
                width: 16px;
                height: 16px;
                margin-top: 0.2rem;
                cursor: pointer;
                border-color: #cbd5e1;
            }

            .custom-checkbox:checked {
                background-color: #f5b301;
                border-color: #f5b301;
            }

            .custom-checkbox:focus {
                border-color: #f5b301;
                box-shadow: 0 0 0 0.15rem rgba(245, 179, 1, 0.25);
            }

            /* =====================================================
            UPLOAD CONTAINER / DROPZONE
            ===================================================== */

            #uploadContainer {
                border: 2px dashed #cbd5e1 !important;
                border-radius: 18px;
                background: #f8fafc;
                min-height: 100px;
                transition: 0.25s;
            }

            #uploadContainer:hover {
                border-color: #e8a400 !important;
                background: #fffdf5;
            }

            #uploadContainer .dz-message {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0;
                min-height: 220px;
                text-align: center;
                color: #64748b;
            }

            #uploadContainer .dz-message i {
                font-size: 50px;
                margin-bottom: 15px;
                color: #e8a400;
            }

            #uploadContainer .dz-message h5 {
                margin-bottom: 8px;
                color: #263247;
            }

            #uploadContainer .dz-message p,
            #uploadContainer .dz-message small {
                margin: 0;
                color: #7b879b;
            }

            #uploadContainer .dz-preview {
                margin-top: 20px;
            }

            /* =====================================================
            DROPZONE FILE PREVIEW
            ===================================================== */

            #uploadContainer .dz-preview .dz-details {
                background: #ffffff;
                color: #263247;
            }

            #uploadContainer .dz-preview .dz-filename {
                color: #263247;
            }

            #uploadContainer .dz-preview .dz-size {
                color: #64748b;
            }

            /* =====================================================
            RESPONSIVE
            ===================================================== */

            @media (max-width: 767.98px) {
                .form-control {
                    height: 54px;
                }

                .register-card {
                    border-radius: 20px;
                    padding: 14px;
                }

                #uploadContainer .dz-message {
                    min-height: 180px;
                    padding: 16px;
                }

                #uploadContainer .dz-message i {
                    font-size: 40px;
                }
            }

            /* Pastikan banner memenuhi kolomnya */
            /* Perbaikan banner tanpa menghilangkan background image */
            .leftPerusahaan {
                position: relative;
                width: 100%;
                min-height: 100vh;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
                background: #fff;
                border-radius: 0 !important;
                isolation: isolate;
            }

            /* Layer gambar */
            .leftPerusahaan > .position-absolute:first-child {
                position: absolute !important;
                inset: 0 !important;
                width: 100% !important;
                height: 100% !important;
                z-index: 0;
            }

            .leftPerusahaan > .position-absolute:first-child img {
                display: block !important;
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
                opacity: 0.16;
            }

            /* Overlay tetap berada di atas gambar */
            .leftPerusahaan > .position-absolute:nth-child(2) {
                z-index: 1;
            }

            /* Aksen dekoratif */
            .leftPerusahaan > .position-absolute:nth-child(3) {
                z-index: 2;
            }

            /* Konten berada paling depan */
            .leftPerusahaan > .position-relative {
                position: relative;
                z-index: 3;
                min-height: 100vh;
                width: 100%;
                box-sizing: border-box;
            }

            /* Hilangkan jarak antar kolom Bootstrap */
            .row:has(.leftPerusahaan) {
                --bs-gutter-x: 0;
                --bs-gutter-y: 0;
            }

            .row:has(.leftPerusahaan) > [class*="col-"] {
                padding-left: 0 !important;
                padding-right: 0 !important;
                min-width: 0;
            }

            @media (max-width: 991.98px) {
                .leftPerusahaan,
                .leftPerusahaan > .position-relative {
                    min-height: auto;
                }
            }

            
            /* =====================================================
            LEFT SATPAM - FULL BANNER
            ===================================================== */

            .leftSatpam {
                position: relative !important;
                display: block;
                width: 100% !important;
                min-width: 0;
                min-height: 100vh !important;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
                isolation: isolate;
                background: #f5f7fb;
                border-radius: 0 !important;
                box-sizing: border-box;
            }

            .leftSatpam *,
            .leftSatpam *::before,
            .leftSatpam *::after {
                box-sizing: border-box;
            }

            /* Background image */
            .leftSatpam .satpam-background {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                overflow: hidden;
            }

            .leftSatpam .satpam-background img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 1;
            }

            /* Light overlay */
            .leftSatpam .satpam-overlay {
                position: absolute;
                inset: 0;
                z-index: 1;
                background: linear-gradient(
                    90deg,
                    rgba(255, 255, 255, .98) 0%,
                    rgba(255, 255, 255, .94) 45%,
                    rgba(255, 255, 255, .76) 100%
                );
                pointer-events: none;
            }

            /* Decorative circles */
            .leftSatpam .satpam-circle-top {
                position: absolute;
                z-index: 2;
                width: 250px;
                height: 250px;
                top: -125px;
                right: -80px;
                background: rgba(245, 183, 45, .12);
                pointer-events: none;
            }

            .leftSatpam .satpam-circle-bottom {
                position: absolute;
                z-index: 2;
                width: 220px;
                height: 220px;
                bottom: -140px;
                left: -100px;
                background: rgba(245, 183, 45, .10);
                pointer-events: none;
            }

            /* Main content */
            .leftSatpam .satpam-content {
                position: relative;
                z-index: 3;
                width: 100%;
                min-height: 100vh;
                margin: 0;
                padding: 40px;
                color: #263247;
            }

            /* Logo */
            .leftSatpam .satpam-logo-wrapper {
                background: rgba(255, 255, 255, .90);
                border: 1px solid #e8edf5;
                box-shadow: 0 8px 25px rgba(35, 55, 90, .06);
            }

            /* Badge */
            .leftSatpam .satpam-badge {
                max-width: 100%;
                background: #fffaf0;
                border: 1px solid #f4cc66;
                color: #b77900;
                font-size: 13px;
                letter-spacing: .4px;
                line-height: 1.5;
            }

            .leftSatpam .satpam-badge-dot {
                display: inline-block;
                flex: 0 0 9px;
                width: 9px;
                height: 9px;
                border-radius: 50%;
                background: #e5a000;
            }

            /* Title */
            .leftSatpam .satpam-title {
                color: #263f63;
                font-size: clamp(2.2rem, 3.2vw, 3.5rem);
                letter-spacing: -1.2px;
            }

            .leftSatpam .satpam-title-highlight {
                color: #e5a000;
            }

            /* Description */
            .leftSatpam .satpam-description {
                max-width: 550px;
                color: #647895;
                font-size: 1.15rem;
                line-height: 1.9;
            }

            /* Divider */
            .leftSatpam .satpam-divider {
                height: 1px;
                border: 0;
                background: #d5deeb;
                opacity: 1;
            }

            /* Statistics */
            .leftSatpam .satpam-stat {
                background: rgba(255, 255, 255, .90);
                border: 1px solid #e5ebf4;
                box-shadow: 0 6px 22px rgba(35, 55, 90, .04);
            }

            .leftSatpam .satpam-stat-number {
                color: #e5a000;
                font-size: clamp(1.4rem, 2.2vw, 2.5rem);
                letter-spacing: -1px;
                overflow-wrap: anywhere;
            }

            .leftSatpam .satpam-stat-label {
                color: #647895;
                font-size: clamp(.7rem, 1vw, 1rem);
                line-height: 1.5;
                overflow-wrap: break-word;
            }

            /* Footer */
            .leftSatpam .satpam-footer {
                color: #94a3b8;
                font-size: 12px;
                line-height: 1.7;
            }

            /* =====================================================
            REMOVE BOOTSTRAP GAP BETWEEN BANNER AND LOGIN FORM
            ===================================================== */

            /*
            Beri class "auth-layout" pada row pembungkus
            banner dan form login.
            */

            .auth-layout {
                --bs-gutter-x: 0 !important;
                --bs-gutter-y: 0 !important;
                margin: 0 !important;
                min-height: 100vh;
            }

            .auth-layout > [class*="col-"] {
                min-width: 0;
                margin: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            /* Jangan biarkan banner memiliki jarak sendiri */
            .auth-layout .leftSatpam,
            .auth-layout .leftPerusahaan {
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }

            /* Form login tidak menambahkan jarak di sisi banner */
            .auth-layout .login-form-column {
                min-width: 0;
                margin: 0 !important;
            }

            /* =====================================================
            RESPONSIVE
            ===================================================== */

            @media (min-width: 1200px) {
                .leftSatpam .satpam-content {
                    padding: 40px;
                }
            }

            @media (max-width: 1199.98px) {
                .leftSatpam .satpam-content {
                    padding: 32px;
                }

                .leftSatpam .satpam-description {
                    font-size: 1rem;
                }
            }

            @media (max-width: 991.98px) {
                .leftSatpam {
                    min-height: auto !important;
                    height: auto;
                }

                .leftSatpam .satpam-content {
                    min-height: auto;
                    padding: 32px 24px;
                }
            }

            @media (max-width: 575.98px) {
                .leftSatpam .satpam-content {
                    padding: 28px 20px;
                }

                .leftSatpam .satpam-title {
                    font-size: 2rem;
                    letter-spacing: -.5px;
                }

                .leftSatpam .satpam-description {
                    font-size: .95rem;
                    line-height: 1.8;
                }

                .leftSatpam .satpam-badge {
                    padding: 9px 12px !important;
                    font-size: 10px;
                    letter-spacing: 0;
                }

                .leftSatpam .satpam-stat {
                    padding: 12px 8px !important;
                }

                .leftSatpam .satpam-stat-number {
                    font-size: 1.2rem;
                }

                .leftSatpam .satpam-stat-label {
                    font-size: 11px;
                }
            }

        </style>

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-52YZ3XGZJ6');
        </script>        
        <script>
            if (window.top != window.self) {
                window.top.location.replace(window.self.location.href);
            }
        </script>
    </head>

    <body id="kt_body" class="app-blank bg-light"
        style="background-color: #f5f7fb !important;">

        <script>
            var defaultThemeMode = "light";
            var themeMode = "light";

            document.documentElement.setAttribute("data-bs-theme", "light");
            document.documentElement.setAttribute("data-bs-theme-mode", "light");

            try {
                localStorage.setItem("data-bs-theme", "light");
            } catch (e) {}
        </script>

        <style>
            /* =====================================================
            GLOBAL LIGHT THEME
            ===================================================== */

            html,
            body,
            #kt_body,
            #kt_app_root {
                background-color: #f5f7fb !important;
                color: #263247;
            }

            body {
                min-height: 100vh;
            }

            .text-gray-300 {
                color: #64748b !important;
            }

            .text-gray-400 {
                color: #7b879b !important;
            }

            .text-white {
                color: #263247 !important;
            }

            .text-muted {
                color: #7b879b !important;
            }

            .text-secondary {
                color: #64748b !important;
            }

            /* Panel utama */
            .login-panel {
                background-color: #f5f7fb !important;
                min-height: 100vh;
            }

            .left-panel {
                background-color: #ffffff !important;
            }

            /* =====================================================
            FORM CONTROL
            ===================================================== */

            .form-control,
            .form-select,
            .input-group-text {
                background-color: #ffffff !important;
                border-color: #dce2ec !important;
                color: #263247 !important;
            }

            .form-control {
                height: 62px;
            }

            .form-control::placeholder {
                color: #9aa5b7 !important;
            }

            .form-control:focus,
            .form-select:focus {
                background-color: #ffffff !important;
                border-color: #e8a400 !important;
                color: #263247 !important;
                box-shadow: 0 0 0 0.2rem rgba(232, 164, 0, 0.12);
            }

            /* =====================================================
            NAVIGATION TABS
            ===================================================== */

            .nav-line-tabs .nav-link {
                color: #64748b;
                border: 0;
                border-bottom: 3px solid transparent;
            }

            .nav-line-tabs .nav-link.active {
                color: #b98200;
                border-bottom: 3px solid #e8a400;
                background: transparent;
            }

            .custom-tabs {
                border-bottom: 1px solid #dce2ec;
            }

            .custom-tabs .nav-link {
                position: relative;
                color: #64748b;
                border: none !important;
                background: transparent !important;
                padding-bottom: 12px;
                transition: 0.25s;
            }

            .custom-tabs .nav-link:hover {
                color: #263247;
            }

            .custom-tabs .nav-link::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: -1px;
                width: 100%;
                height: 2px;
                background: #263247;
                transform: scaleX(0);
                transform-origin: left;
                transition: 0.25s;
            }

            .custom-tabs .nav-link:hover::after {
                transform: scaleX(1);
            }

            .custom-tabs .nav-link.active {
                color: #b98200;
            }

            .custom-tabs .nav-link.active::after {
                background: #f5b301;
                transform: scaleX(1);
            }

            /* =====================================================
            BUTTONS
            ===================================================== */

            .btn-warning {
                background: #e8a400;
                border-color: #e8a400;
                color: #1b1b1b !important;
            }

            .btn-warning:hover,
            .btn-warning:focus {
                background: #d99a00;
                border-color: #d99a00;
                color: #1b1b1b !important;
            }

            .btn-dark {
                background: #e9edf4 !important;
                border-color: #dce2ec !important;
                color: #334155 !important;
            }

            .btn-dark:hover,
            .btn-dark:focus {
                background: #dce3ed !important;
                border-color: #cbd5e1 !important;
                color: #1e293b !important;
            }

            .rounded-pill {
                border-radius: 18px !important;
            }

            .role-btn {
                height: 38px;
                padding: 0 16px;
                font-size: 13px;
                font-weight: 600;
                transition: 0.25s;
                color: #64748b;
            }

            .role-btn:hover {
                color: #263247;
            }

            .role-btn.active {
                background: #f5b301 !important;
                border-color: #f5b301 !important;
                color: #000000 !important;
            }

            #btnLogin:disabled,
            #btnLoginCompany:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* =====================================================
            PHONE NUMBER
            ===================================================== */

            .country-code {
                width: 90px;
                justify-content: center;
                background: #ffffff !important;
                border: 1px solid #dce2ec !important;
                color: #263247 !important;
                font-size: 14px;
                font-weight: 600;
            }

            #phone_number {
                background: #ffffff !important;
                border: 0;
                color: #263247 !important;
            }

            #phone_number::placeholder {
                color: #9aa5b7 !important;
            }

            #phone_number:focus {
                background: #ffffff !important;
                color: #263247 !important;
                box-shadow: none;
            }

            /* =====================================================
            LOGIN FORM
            ===================================================== */

            .login-form-wrapper {
                max-width: 70%;
            }

            @media (max-width: 991.98px) {
                .login-form-wrapper {
                    max-width: 100%;
                }
            }

            /* =====================================================
            REGISTRATION CARDS
            ===================================================== */

            .register-card {
                display: block;
                background: #ffffff !important;
                border: 1px solid #e5eaf2;
                border-radius: 28px;
                padding: 16px;
                margin-bottom: 16px;
                transition: 0.25s;
                box-shadow: 0 4px 16px rgba(31, 45, 61, 0.05);
            }

            .card-yellow {
                border: 3px solid #e8c65c;
            }

            .card-blue {
                border: 3px solid #8bb8f0;
            }

            .register-card:hover {
                transform: translateY(-3px);
                background: #fffdf7 !important;
                box-shadow: 0 10px 24px rgba(31, 45, 61, 0.08);
            }

            .register-card i {
                transition: 0.25s;
            }

            .register-card:hover i {
                transform: translateX(5px);
                color: #b98200 !important;
            }

            .badge-warning {
                background: #fff8df;
                border: 1px solid #e8c65c;
                color: #936800;
                border-radius: 50rem;
                font-size: 12px;
                padding: 4px 8px;
                font-weight: 600;
            }

            /* =====================================================
            CHECKBOX
            ===================================================== */

            .custom-checkbox {
                width: 16px;
                height: 16px;
                margin-top: 0.2rem;
                cursor: pointer;
                border-color: #cbd5e1;
            }

            .custom-checkbox:checked {
                background-color: #f5b301;
                border-color: #f5b301;
            }

            .custom-checkbox:focus {
                border-color: #f5b301;
                box-shadow: 0 0 0 0.15rem rgba(245, 179, 1, 0.25);
            }

            /* =====================================================
            DROPZONE
            ===================================================== */

            #uploadContainer {
                border: 2px dashed #cbd5e1 !important;
                border-radius: 18px;
                background: #f8fafc !important;
                min-height: 100px;
                transition: 0.25s;
            }

            #uploadContainer:hover {
                border-color: #e8a400 !important;
                background: #fffdf5 !important;
            }

            #uploadContainer .dz-message {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0;
                min-height: 220px;
                text-align: center;
                color: #64748b;
            }

            #uploadContainer .dz-message i {
                font-size: 50px;
                margin-bottom: 15px;
                color: #e8a400;
            }

            #uploadContainer .dz-message h5 {
                margin-bottom: 8px;
                color: #263247 !important;
            }

            #uploadContainer .dz-message p,
            #uploadContainer .dz-message small {
                margin: 0;
                color: #7b879b !important;
            }

            #uploadContainer .dz-preview {
                margin-top: 20px;
            }

            #uploadContainer .dz-preview .dz-details {
                background: #ffffff;
                color: #263247;
            }

            #uploadContainer .dz-preview .dz-filename {
                color: #263247;
            }

            #uploadContainer .dz-preview .dz-size {
                color: #64748b;
            }

            /* =====================================================
            SWEETALERT2
            ===================================================== */

            .swal2-popup {
                background: #ffffff !important;
                color: #263247 !important;
                border-radius: 18px !important;
            }

            .swal2-title {
                color: #263247 !important;
            }

            .swal2-html-container {
                color: #64748b !important;
            }

            .swal2-confirm {
                color: #1b1b1b !important;
            }

            /* =====================================================
            RESPONSIVE
            ===================================================== */

            @media (max-width: 767.98px) {
                .form-control {
                    height: 54px;
                }

                .register-card {
                    border-radius: 20px;
                    padding: 14px;
                }

                #uploadContainer .dz-message {
                    min-height: 180px;
                    padding: 16px;
                }

                #uploadContainer .dz-message i {
                    font-size: 40px;
                }
            }
        </style>

        <div class="d-flex flex-column flex-root" id="kt_app_root">

            <div class="d-flex flex-column flex-lg-row flex-column-fluid">

                <!-- Panel Form Login -->
                <div class="d-flex flex-column flex-lg-row-fluid
                            w-lg-50 p-10 order-2 order-lg-2 login-panel">

                    <div class="d-flex flex-column justify-content-center h-100 w-100">

                        <div class="mx-auto w-100 login-form-wrapper">

                            @yield('right-panel')

                        </div>

                    </div>

                </div>

                <!-- Panel Kiri -->
                <div class="d-flex flex-lg-row-fluid w-lg-50
                            bgi-size-cover bgi-position-center order-1 order-lg-1 left-panel">

                    <div class="d-lg-flex d-flex flex-lg-row-fluid
                                w-lg-50 position-relative overflow-hidden"
                        style="display: none;">

                        @yield('left-panel')

                    </div>

                </div>

            </div>

        </div>

        <script>
            var hostUrl = "/assets/";
        </script>

        <script src="/assets/plugins/global/plugins.bundle.js"></script>
        <script src="/assets/js/scripts.bundle.js"></script>
        <script src="/assets/js/custom/authentication/sign-in/general.js"></script>
        <script src="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone-min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            /* =====================================================
            SWEETALERT HELPER - LIGHT THEME
            ===================================================== */

            function showLightAlert(options) {
                return Swal.fire({
                    background: '#ffffff',
                    color: '#263247',
                    confirmButtonColor: '#e8a400',
                    ...options
                });
            }

            /* =====================================================
            TOGGLE PASSWORD
            ===================================================== */

            $('#togglePassword').on('click', function () {
                let password = $('#password');

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

            $('#togglePasswordCompany').on('click', function () {
                let password = $('#passwordCompany');

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

            $(document).on('click', '.toggle-password', function () {
                const target = $($(this).data('target'));
                const icon = $(this).find('i');

                if (target.attr('type') === 'password') {
                    target.attr('type', 'text');

                    icon.removeClass('bi-eye')
                        .addClass('bi-eye-slash');
                } else {
                    target.attr('type', 'password');

                    icon.removeClass('bi-eye-slash')
                        .addClass('bi-eye');
                }
            });

            /* =====================================================
            VALIDASI LOGIN
            ===================================================== */

            $(function () {
                function checkLoginForm() {
                    let email = $.trim($('#email').val());
                    let password = $.trim($('#password').val());

                    $('#btnLogin').prop('disabled', !(email && password));
                }

                $('#email, #password').on('keyup input change', function () {
                    checkLoginForm();
                });

                checkLoginForm();
            });

            $(function () {
                function checkLoginFormCompany() {
                    let email = $.trim($('#emailCompany').val());
                    let password = $.trim($('#passwordCompany').val());

                    $('#btnLoginCompany').prop(
                        'disabled',
                        !(email && password)
                    );
                }

                $('#emailCompany, #passwordCompany').on(
                    'keyup input change',
                    function () {
                        checkLoginFormCompany();
                    }
                );

                checkLoginFormCompany();
            });

            $(function () {
                function checkPhoneNumber() {
                    let phone = $.trim($('#phone_number').val());

                    $('#btnOtp').prop('disabled', phone === '');
                }

                $('#phone_number').on(
                    'input keyup paste change',
                    function () {
                        checkPhoneNumber();
                    }
                );

                checkPhoneNumber();
            });

            /* =====================================================
            NAVIGASI LOGIN DAN REGISTER
            ===================================================== */

            $('#showRegister, #showRegisterCompany').on('click', function (e) {
                e.preventDefault();

                $('#loginPage').fadeOut(200, function () {
                    $('#registerPage')
                        .fadeIn(200)
                        .removeClass('d-none');
                });
            });

            $('#showLogin').on('click', function (e) {
                e.preventDefault();

                $('#registerPage').hide();

                $('#loginPage')
                    .removeClass('d-none')
                    .hide()
                    .fadeIn(200);

                if ($('.btnSatpam').hasClass('active')) {
                    $('.leftSatpam').removeClass('d-none').hide().fadeIn(200);
                    $('.leftPerusahaan').hide();
                } else {
                    $('.leftPerusahaan').removeClass('d-none').hide().fadeIn(200);
                    $('.leftSatpam').hide();
                }
            });

            $(document).on('click', '#btnRegisterSecurity', function (e) {
                e.preventDefault();

                $('#registerPage').fadeOut(200, function () {
                    $(this).hide();

                    $('#registerSecurityPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                    $('.leftSatpam').fadeIn(200);
                    $('.leftPerusahaan').hide();
                });
            });

            $(document).on('click', '#btnRegisterCompany', function (e) {
                e.preventDefault();

                $('#registerPage').fadeOut(200, function () {
                    $(this).hide();

                    $('#registerCompanyPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                    $('.leftPerusahaan').fadeIn(200);
                    $('.leftSatpam').hide();
                });
            });

            $(document).on('click', '#backToRegisterFromSecurity', function (e) {
                e.preventDefault();

                $('#registerSecurityPage').fadeOut(200, function () {
                    $(this).hide();

                    $('#registerPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);
                });
            });

            $(document).on('click', '#backToRegisterFromCompany', function (e) {
                e.preventDefault();

                $('#registerCompanyPage').fadeOut(200, function () {
                    $(this).hide();

                    $('#registerPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);
                });
            });

            $(document).on('click', '#btnBackLogin', function (e) {
                e.preventDefault();

                $('#registerPage').hide();
                $('#registerSecurityPage').hide();
                $('#registerCompanyPage').hide();

                $('#loginPage')
                    .removeClass('d-none')
                    .hide()
                    .fadeIn(200);

                if ($('.btnSatpam').hasClass('active')) {
                    $('.leftSatpam').removeClass('d-none').hide().fadeIn(200);
                    $('.leftPerusahaan').hide();
                } else {
                    $('.leftPerusahaan').removeClass('d-none').hide().fadeIn(200);
                    $('.leftSatpam').hide();
                }
            });

            /* =====================================================
            DROPZONE UPLOAD
            ===================================================== */

            Dropzone.autoDiscover = false;

            let uploadedFile = null;

            const defaultDropzone = `
                <div class="dz-message">

                    <i class="bi bi-cloud-arrow-up-fill text-warning"
                    style="font-size:48px;"></i>

                    <h5 class="mt-3 mb-2" style="color:#263247;">
                        Seret file di sini
                    </h5>

                    <p class="mb-0" style="color:#64748b;">
                        atau klik untuk memilih file
                    </p>

                    <small style="color:#7b879b;">
                        PDF, JPG, PNG (Maks. 5 MB)
                    </small>

                </div>
            `;

            const dz = document.querySelector("#uploadContainer")
                ? new Dropzone("#uploadContainer", {
                    url: "#",
                    autoProcessQueue: false,
                    clickable: true,
                    maxFiles: 1,
                    maxFilesize: 5,
                    acceptedFiles: ".pdf,.jpg,.jpeg,.png",
                    previewTemplate: "<div></div>",

                    init: function () {
                        this.on("addedfile", function (file) {
                            if (this.files.length > 1) {
                                this.removeFile(this.files[0]);
                            }

                            uploadedFile = file;

                            let icon = "bi-file-earmark-fill text-secondary";

                            if (file.type.includes("pdf")) {
                                icon = "bi-file-earmark-pdf-fill text-danger";
                            }

                            if (file.type.includes("image")) {
                                icon = "bi-file-earmark-image-fill text-success";
                            }

                            $("#uploadContainer").html(`
                                <div class="d-flex align-items-center
                                            justify-content-center h-100 p-4">

                                    <div class="d-flex align-items-center w-100">

                                        <i class="bi ${icon} fs-1 me-3"></i>

                                        <div class="flex-grow-1">

                                            <div class="fw-bold"
                                                style="color:#263247;">
                                                ${$('<div>').text(file.name).html()}
                                            </div>

                                            <small style="color:#64748b;">
                                                ${(file.size / 1024 / 1024).toFixed(2)} MB
                                            </small>

                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger remove-file">

                                            <i class="bi bi-x-lg"></i>

                                        </button>

                                    </div>

                                </div>
                            `);
                        });

                        this.on("error", function (file, message) {
                            uploadedFile = null;

                            let errorMessage = typeof message === 'string'
                                ? message
                                : 'File gagal diproses.';

                            showLightAlert({
                                icon: 'error',
                                title: 'Upload Gagal',
                                text: errorMessage
                            });

                            this.removeFile(file);
                        });
                    }
                })
                : null;

            $(document).on("click", ".remove-file", function () {
                if (!dz) return;

                uploadedFile = null;

                dz.removeAllFiles(true);

                $("#uploadContainer").html(defaultDropzone);
            });

            /* =====================================================
            PILIH LINK ATAU UPLOAD FILE
            ===================================================== */

            $(document).on('click', '#btnLink', function () {
                $('#uploadContainer').hide();
                $('#linkContainer').removeClass('d-none').show();

                $('#btnUploadFile')
                    .removeClass('btn-warning')
                    .addClass('btn-dark');

                $(this)
                    .removeClass('btn-dark')
                    .addClass('btn-warning');

                $('.remove-file').trigger('click');
            });

            $(document).on('click', '#btnUploadFile', function () {
                $('#linkContainer').hide();
                $('#uploadContainer').show();

                $('#btnLink')
                    .removeClass('btn-warning')
                    .addClass('btn-dark');

                $(this)
                    .removeClass('btn-dark')
                    .addClass('btn-warning');

                $('input[name=sio_url]').val('');
            });

            /* =====================================================
            GANTI ROLE LOGIN
            ===================================================== */

            function changeRole(role) {
                $('.role-btn')
                    .removeClass('active btn-warning text-dark')
                    .addClass('text-muted');

                if (role == 'satpam') {
                    $('.btnSatpam')
                        .addClass('active btn-warning text-dark')
                        .removeClass('text-muted');

                    $('.loginSatpam').show();
                    $('.loginPerusahaan').hide();

                    $('.leftSatpam').fadeIn(200);
                    $('.leftPerusahaan').hide();
                } else {
                    $('.btnPerusahaan')
                        .addClass('active btn-warning text-dark')
                        .removeClass('text-muted');

                    $('.loginPerusahaan').show();
                    $('.loginSatpam').hide();

                    $('.leftPerusahaan').fadeIn(200);
                    $('.leftSatpam').hide();
                }
            }

            $(document).on('click', '.btnSatpam', function (event) {
                event.preventDefault();
                changeRole('satpam');
            });

            $(document).on('click', '.btnPerusahaan', function (event) {
                event.preventDefault();
                changeRole('perusahaan');
            });

            /* =====================================================
            VALIDASI FORM
            ===================================================== */

            function validateForm(form) {
                let valid = true;

                form.find('.required-field').each(function () {
                    if ($(this).is(':checkbox')) {
                        if (!$(this).is(':checked')) {
                            valid = false;
                            return false;
                        }
                    } else {
                        if ($.trim($(this).val()) == '') {
                            valid = false;
                            return false;
                        }
                    }
                });

                form.find('.submit-btn').prop('disabled', !valid);
            }

            $('.validate-form').each(function () {
                validateForm($(this));
            });

            $(document).on('keyup change input', '.required-field', function () {
                let form = $(this).closest('.validate-form');
                validateForm(form);
            });

            /* =====================================================
            LOGIN SATPAM
            ===================================================== */

            $('#formLoginSatpam').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/signIn',
                    type: 'POST',
                    data: $(this).serialize(),

                    beforeSend: function () {
                        $('#btnLogin')
                            .prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...'
                            );
                    },

                    success: function (res) {
                        showLightAlert({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            window.location.href = res.redirect;
                        });
                    },

                    error: function (xhr) {
                        showLightAlert({
                            icon: 'error',
                            title: 'Login Gagal',
                            text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.'
                        });
                    },

                    complete: function () {
                        $('#btnLogin')
                            .prop('disabled', false)
                            .html('Masuk Sekarang');
                    }
                });
            });

            /* =====================================================
            LOGIN PERUSAHAAN
            ===================================================== */

            $('#formLoginCompany').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/signIn',
                    type: 'POST',
                    data: $(this).serialize(),

                    beforeSend: function () {
                        $('#btnLoginCompany')
                            .prop('disabled', true)
                            .html(`
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Memproses...
                            `);
                    },

                    success: function (res) {
                        showLightAlert({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            window.location.href = res.redirect;
                        });
                    },

                    error: function (xhr) {
                        showLightAlert({
                            icon: 'error',
                            title: 'Login Gagal',
                            text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.'
                        });
                    },

                    complete: function () {
                        $('#btnLoginCompany')
                            .prop('disabled', false)
                            .html('Masuk Sekarang');
                    }
                });
            });

            /* =====================================================
            REGISTRASI SATPAM
            ===================================================== */

            $('#formRegisterSecurity').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/register/security',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function (res) {
                        showLightAlert({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            window.location.href = res.redirect;
                        });
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let html = '';

                            $.each(xhr.responseJSON.errors, function (key, value) {
                                html += '<div class="text-start mb-2">• ' +
                                    $('<div>').text(value[0]).html() +
                                    '</div>';
                            });

                            showLightAlert({
                                icon: 'warning',
                                title: 'Validasi Gagal',
                                html: html
                            });

                            return;
                        }

                        showLightAlert({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.'
                        });
                    }
                });
            });

            /* =====================================================
            REGISTRASI PERUSAHAAN
            ===================================================== */

            $('#formRegisterCompany').submit(function (e) {
                e.preventDefault();

                let form = $(this);
                let btn = form.find('.submit-btn');

                btn.prop('disabled', true);

                $.ajax({
                    url: '/register/company',
                    type: 'POST',
                    data: form.serialize(),

                    success: function (res) {
                        showLightAlert({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            window.location.href = res.redirect;
                        });
                    },

                    error: function (xhr) {
                        btn.prop('disabled', false);

                        if (xhr.status === 422) {
                            let html = '';

                            $.each(xhr.responseJSON.errors, function (key, value) {
                                html += `
                                    <div class="text-start mb-2">
                                        • ${$('<div>').text(value[0]).html()}
                                    </div>
                                `;
                            });

                            showLightAlert({
                                icon: 'warning',
                                title: 'Validasi Gagal',
                                html: html
                            });

                            return;
                        }

                        showLightAlert({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.'
                        });
                    },

                    complete: function () {
                        btn.prop('disabled', false);
                    }
                });
            });

            /* =====================================================
            REGISTRASI BUJP
            ===================================================== */

            $('#formRegisterBUJP').submit(function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                if (uploadedFile) {
                    formData.append("sio_file", uploadedFile);
                }

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    beforeSend: function () {
                        $('.submit-btn')
                            .prop('disabled', true)
                            .html(`
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Memproses...
                            `);
                    },

                    success: function (res) {
                        showLightAlert({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            window.location.href = res.redirect;
                        });
                    },

                    error: function (xhr) {
                        let message = "Terjadi kesalahan.";

                        if (xhr.status === 422) {
                            if (xhr.responseJSON?.errors) {
                                const errors = xhr.responseJSON.errors;
                                message = Object.values(errors)[0][0];
                            } else if (xhr.responseJSON?.message) {
                                message = xhr.responseJSON.message;
                            }
                        } else if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }

                        showLightAlert({
                            icon: 'error',
                            title: 'Oops...',
                            text: message
                        });
                    },

                    complete: function () {
                        $('.submit-btn')
                            .prop('disabled', false)
                            .html('Daftar Sekarang');
                    }
                });
            });
        </script>

        @if(session('swal'))
            <script>
                showLightAlert({
                    icon: @json(session('swal.icon')),
                    title: @json(session('swal.title')),
                    text: @json(session('swal.text'))
                });
            </script>
        @endif

    </body>

</html>