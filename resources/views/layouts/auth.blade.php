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
            .object-fit-cover{
                object-fit:cover;
            }

            .text-gray-300{
                color:#C6CBD5;
            }

            .text-gray-400{
                color:#8A94A6;
            }

            body{
                background:#090f20;
            }

            .form-control,
            .input-group-text{
                background:#1b2547 !important;
                border-color:#2b365d !important;
                color:#fff;
            }

            .form-control{
                height:62px;
            }

            .form-control::placeholder{
                color:#8b95b4;
            }

            .nav-line-tabs .nav-link{
                color:#8391b5;
                border:0;
                border-bottom:3px solid transparent;
            }

            .nav-line-tabs .nav-link.active{
                color:#e8a400;
                border-bottom:3px solid #e8a400;
                background:transparent;
            }

            .btn-warning{
                background:#e8a400;
                border-color:#e8a400;
                color:#1b1b1b;
            }

            .btn-dark{
                background:#111a34;
            }

            .rounded-pill{
                border-radius:18px !important;
            }

            .role-btn{
                height: 38px;
                padding: 0 16px;
                font-size: 13px;
                font-weight: 600;
            }

            .role-btn{
                transition:.25s;
                color:#8f96a3;
            }

            .role-btn:hover{
                color:#fff;
            }

            .role-btn.active{
                background:#f5b301;
                color:#000 !important;
            }

            /* Garis abu-abu full */
            .custom-tabs{
                border-bottom:1px solid #374151;
            }

            /* Hilangkan border bawaan bootstrap */
            .custom-tabs .nav-link{
                position:relative;
                color:#8d97b5;
                border:none !important;
                background:transparent !important;
                padding-bottom:12px;
                transition:.25s;
            }

            /* Hover */
            .custom-tabs .nav-link:hover{
                color:#ffffff;
            }

            /* Garis hanya selebar teks */
            .custom-tabs .nav-link::after{
                content:"";
                position:absolute;
                left:0;
                bottom:-1px;
                width:100%;
                height:2px;
                background:#ffffff;
                transform:scaleX(0);
                transform-origin:left;
                transition:.25s;
            }

            /* Hover */
            .custom-tabs .nav-link:hover::after{
                transform:scaleX(1);
            }

            /* Active */
            .custom-tabs .nav-link.active{
                color:#f5b301;
            }

            /* Active garis orange */
            .custom-tabs .nav-link.active::after{
                background:#f5b301;
                transform:scaleX(1);
            }

            #btnLogin:disabled{
                opacity: .5;
                cursor: not-allowed;
            }

            .country-code{
                width:90px;              /* sekitar 10-15% */
                justify-content:center;
                background:#1b2547;
                border:0;
                color:#fff;
                font-size:14px;
                font-weight:600;
            }

            #phone_number{
                background:#1b2547;
                border:0;
                color:#fff;
            }

            #phone_number::placeholder{
                color:#8d97b5;
            }

            #phone_number:focus{
                background:#1b2547;
                color:#fff;
                box-shadow:none;
            }

            .login-form-wrapper{
                max-width:70%;
            }

            @media (max-width: 991.98px){
                .login-form-wrapper{
                    max-width:100%;
                }
            }

            .register-card{
                display:block;
                background:#171822;
                border-radius: 28px;
                padding: 16px;
                margin-bottom: 16px;
                transition:.25s;
            }

            .card-yellow{
                border:3px solid #9d7400;
            }

            .card-blue{
                border:3px solid #2b5ea7;
            }

            .register-card:hover{
                transform:translateY(-3px);
                background:#1c1f2b;
            }

            .register-card i{
                transition:.25s;
            }

            .register-card:hover i{
                transform:translateX(5px);
                color:#fff !important;
            }

            .badge-warning{
                background:rgba(255,193,7,.12);
                border: 1px solid #ffc107;
                color:#ffc107;
                border-radius:50rem;
                font-size: 12px;
                padding: 4px 8px;
                font-weight: 600;
            }

            .custom-checkbox {
                width: 16px;
                height: 16px;
                margin-top: 0.2rem;
                cursor: pointer;
            }

            .custom-checkbox:checked {
                background-color: #f5b301; /* Orange Gold */
                border-color: #f5b301;
            }

            .custom-checkbox:focus {
                border-color: #f5b301;
                box-shadow: 0 0 0 .15rem rgba(245, 179, 1, .25);
            }

            #uploadContainer{
                border:2px dashed #555 !important;
                border-radius:18px;
                background:#111827;
                min-height:100px;
                transition:.25s;
            }

            #uploadContainer .dz-message{
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0;
                min-height: 220px;
                text-align: center;
            }

            #uploadContainer .dz-message i{
                font-size: 50px;
                margin-bottom: 15px;
            }

            #uploadContainer .dz-message h5{
                margin-bottom: 8px;
            }

            #uploadContainer .dz-message p,
            #uploadContainer .dz-message small{
                margin: 0;
            }

            #uploadContainer .dz-preview{
                margin-top:20px;
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

    <body id="kt_body" class="app-blank bg-dark" style="background-color: black !important;">
        <script>
            var defaultThemeMode = "dark";
            var themeMode;

            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if ( localStorage.getItem("data-bs-theme") !== null ) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }			
                }

                if (themeMode === "system") {
                    // themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                    themeMode = 'dark';
                }

                document.documentElement.setAttribute("data-bs-theme", 'dark');
            }            
        </script>
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">    
                <!--begin::Body-->
                <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-2" style="background-color: #080d1c; min-height:100vh;">
                        <div class="d-flex flex-column justify-content-center h-100 w-100">
                            <div class="mx-auto w-100 login-form-wrapper">

                                <!-- Halaman Login -->
                                @yield('right-panel')

                            </div>
                        </div>
                </div>
                <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-1">
                    <div class="d-lg-flex d-flex flex-lg-row-fluid w-lg-50 position-relative overflow-hidden" style="display: none;">
                        
                        @yield('left-panel')

                    </div>
                </div>
            </div>
        </div>
        
        <script> var hostUrl = "/assets/"; </script>
        <script src="/assets/plugins/global/plugins.bundle.js"></script>
        <script src="/assets/js/scripts.bundle.js"></script>
        <script src="/assets/js/custom/authentication/sign-in/general.js"></script>
        <script src="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone-min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
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

                    $('#btnLoginCompany').prop('disabled', !(email && password));

                }

                $('#emailCompany, #passwordCompany').on('keyup input change', function () {
                    checkLoginFormCompany();
                });

                checkLoginFormCompany();

            });

            $(function () {

                function checkPhoneNumber() {
                    let phone = $.trim($('#phone_number').val());

                    $('#btnOtp').prop('disabled', phone === '');
                }

                $('#phone_number').on('input keyup paste change', function () {
                    checkPhoneNumber();
                });

                checkPhoneNumber();

            });

            $('#showRegister').click(function(e){

                e.preventDefault();

                $('#loginPage').fadeOut(200,function(){

                    $('#registerPage').fadeIn(200).removeClass('d-none');

                });

            });

            $('#showRegisterCompany').click(function(e){

                e.preventDefault();

                $('#loginPage').fadeOut(200,function(){

                    $('#registerPage').fadeIn(200).removeClass('d-none');

                });

            });

            $('#showLogin').click(function(e){

                $('#registerPage').hide();

                $('#loginPage').removeClass('d-none').hide().fadeIn(200);

                // Cek role yang aktif
                if ($('.btnSatpam').hasClass('active')) {

                    // Tampilkan konten kiri Satpam
                    $('.leftSatpam').removeClass('d-none').hide().fadeIn(200);
                    $('.leftPerusahaan').hide();

                } else {

                    // Tampilkan konten kiri Perusahaan
                    $('.leftPerusahaan').removeClass('d-none').hide().fadeIn(200);
                    $('.leftSatpam').hide();

                }

            });

            $(document).on('click', '#btnRegisterBUJP', function(e){

                e.preventDefault();

                $('#registerPage').fadeOut(200, function(){

                    $(this).hide();

                    $('#registerBUJPPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                    $('.leftPerusahaan').fadeIn(200);
                    $('.leftSatpam').hide();

                });

            });

            $(document).on('click', '#btnRegisterSecurity', function(e){

                e.preventDefault();

                $('#registerPage').fadeOut(200, function(){

                    $(this).hide();

                    $('#registerSecurityPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                    $('.leftSatpam').fadeIn(200);
                    $('.leftPerusahaan').hide();

                });

            });

            $(document).on('click', '#btnRegisterCompany', function(e){

                e.preventDefault();

                $('#registerPage').fadeOut(200, function(){

                    $(this).hide();

                    $('#registerCompanyPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                    $('.leftPerusahaan').fadeIn(200);
                    $('.leftSatpam').hide();

                });

            });

            $(document).on('click', '#backToRegisterFromBUPJ', function(e){

                e.preventDefault();

                $('#registerBUJPPage').fadeOut(200, function(){

                    $(this).hide();

                    $('#registerPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                });

            });

            $(document).on('click', '#backToRegisterFromSecurity', function(e){

                e.preventDefault();

                $('#registerSecurityPage').fadeOut(200, function(){

                    $(this).hide();

                    $('#registerPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                });

            });

            $(document).on('click', '#backToRegisterFromCompany', function(e){

                e.preventDefault();

                $('#registerCompanyPage').fadeOut(200, function(){

                    $(this).hide();

                    $('#registerPage')
                        .removeClass('d-none')
                        .hide()
                        .fadeIn(200);

                });

            });

            $(document).on('click', '#btnBackLogin', function(e){

                e.preventDefault();

                // Sembunyikan semua halaman register
                $('#registerPage').hide();
                $('#registerBUJPPage').hide();
                $('#registerSecurityPage').hide();
                $('#registerCompanyPage').hide();

                // Tampilkan login
                $('#loginPage').removeClass('d-none').hide().fadeIn(200);

                // Cek role yang aktif
                if ($('.btnSatpam').hasClass('active')) {

                    // Tampilkan konten kiri Satpam
                    $('.leftSatpam').removeClass('d-none').hide().fadeIn(200);
                    $('.leftPerusahaan').hide();

                } else {

                    // Tampilkan konten kiri Perusahaan
                    $('.leftPerusahaan').removeClass('d-none').hide().fadeIn(200);
                    $('.leftSatpam').hide();

                }

            });

            Dropzone.autoDiscover = false;

            let uploadedFile = null;

            const defaultDropzone = `
                <div class="dz-message">

                    <i class="bi bi-cloud-arrow-up-fill text-warning"
                        style="font-size:48px;"></i>

                    <h5 class="text-white mt-3 mb-2">
                        Seret file di sini
                    </h5>

                    <p class="text-muted mb-0">
                        atau klik untuk memilih file
                    </p>

                    <small class="text-muted">
                        PDF, JPG, PNG (Maks. 5 MB)
                    </small>

                </div>
            `;

            const dz = new Dropzone("#uploadContainer", {

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
                            <div class="d-flex align-items-center justify-content-center h-100 p-4">

                                <div class="d-flex align-items-center w-100">

                                    <i class="bi ${icon} fs-1 me-3"></i>

                                    <div class="flex-grow-1">

                                        <div class="text-white fw-bold">
                                            ${file.name}
                                        </div>

                                        <small class="text-muted">
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

                }

            });

            $(document).on("click", ".remove-file", function () {

                uploadedFile = null;

                dz.removeAllFiles(true);

                $("#uploadContainer").html(defaultDropzone);

            });

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

            function changeRole(role){

                $('.role-btn')
                    .removeClass('active btn-warning text-dark')
                    .addClass('text-muted');

                if(role == 'satpam'){

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

            $('.btnSatpam').click(function(){

                changeRole('satpam');

            });

            $('.btnPerusahaan').click(function(){

                changeRole('perusahaan');

            });

            function validateForm(form){

                let valid = true;

                form.find('.required-field').each(function(){

                    if($(this).is(':checkbox')){

                        if(!$(this).is(':checked')){
                            valid = false;
                            return false;
                        }

                    }else{

                        if($.trim($(this).val()) == ''){
                            valid = false;
                            return false;
                        }

                    }

                });

                form.find('.submit-btn').prop('disabled', !valid);

            }

            $('.validate-form').each(function(){

                validateForm($(this));

            });

            $(document).on('keyup change', '.required-field', function(){

                let form = $(this).closest('.validate-form');

                validateForm(form);

            });

            $('#formLoginSatpam').submit(function(e){

                e.preventDefault();

                $.ajax({

                    url: '/signIn',
                    type: 'POST',
                    data: $(this).serialize(),

                    beforeSend:function(){

                        $('#btnLogin')
                            .prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

                    },

                    success:function(res){

                        Swal.fire({

                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: '#ffc107',
                            background: '#152040',
                            color: 'white',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        }).then(() => {

                            window.location.href = res.redirect;

                        });

                    },

                    error:function(xhr){

                        Swal.fire({

                            icon: 'error',
                            title: 'Login Gagal',
                            text: xhr.responseJSON.message,
                            confirmButtonColor: '#ffc107',
                            background: '#152040',
                            color: 'white',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        });

                    },

                    complete:function(){

                        $('#btnLogin')
                            .prop('disabled', false)
                            .html('Masuk Sekarang');

                    }

                });

            });

            $('#formLoginCompany').submit(function(e){

                e.preventDefault();

                $.ajax({

                    url: '/signIn',

                    type: 'POST',

                    data: $(this).serialize(),

                    beforeSend: function(){

                        $('#btnLoginCompany')
                            .prop('disabled', true)
                            .html(`
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Memproses...
                            `);

                    },

                    success: function(res){

                        Swal.fire({

                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: '#ffc107',
                            background: '#152040',
                            color: 'white',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        }).then(() => {

                            window.location.href = res.redirect;

                        });

                    },

                    error: function(xhr){

                        Swal.fire({

                            icon: 'error',
                            title: 'Login Gagal',
                            text: xhr.responseJSON.message ?? 'Terjadi kesalahan.',
                            confirmButtonColor: '#ffc107',
                            background: '#152040',
                            color: 'white',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        });

                    },

                    complete: function(){

                        $('#btnLoginCompany')
                            .prop('disabled', false)
                            .html('Masuk Sekarang');

                    }

                });

            });

            $('#formRegisterSecurity').submit(function(e){

                e.preventDefault();

                $.ajax({

                    url: '/register/security',

                    method: 'POST',

                    data: $(this).serialize(),

                    success: function(res){

                        Swal.fire({

                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: '#ffc107',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        }).then(() => {

                            window.location.href = res.redirect;

                        });

                    },

                    error: function(xhr){

                        if(xhr.status === 422){

                            let html = '';

                            $.each(xhr.responseJSON.errors, function(key, value){

                                html += '• ' + value[0] + '<br>';

                            });

                            Swal.fire({
                                icon: 'warning',
                                title: 'Validasi Gagal',
                                html: html,
                                confirmButtonColor: '#ffc107',
                                didOpen: () => {
                                    document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                    document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                                }
                            });

                            return;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message,
                            confirmButtonColor: '#ffc107',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }
                        });

                    }

                });

            });

            $('#formRegisterCompany').submit(function(e){

                e.preventDefault();

                let form = $(this);

                let btn = form.find('.submit-btn');

                btn.prop('disabled', true);

                $.ajax({

                    url: '/register/company',
                    type: 'POST',
                    data: form.serialize(),

                    success:function(res){

                        Swal.fire({

                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: '#ffc107',
                            background: '#152040',
                            color: 'white',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        }).then(() => {

                            window.location.href = res.redirect;

                        });

                    },

                    error:function(xhr){

                        btn.prop('disabled', false);

                        if(xhr.status === 422){

                            let html = '';

                            $.each(xhr.responseJSON.errors,function(key,value){

                                html += `
                                    <div class="text-start mb-2">
                                        • ${value[0]}
                                    </div>
                                `;

                            });

                            Swal.fire({

                                icon:'warning',
                                title:'Validasi Gagal',
                                html:html,
                                confirmButtonColor:'#ffc107',
                                background:'#152040',
                                color: 'white',
                                didOpen: () => {
                                    document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                    document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                                }

                            });

                            return;

                        }

                        Swal.fire({

                            icon:'error',
                            title:'Oops...',
                            text:xhr.responseJSON.message ?? 'Terjadi kesalahan.',
                            confirmButtonColor:'#ffc107',
                            background:'#152040',
                            color: 'white',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        });

                    },

                    complete:function(){

                        btn.prop('disabled', false);

                    }

                });

            });

            $(document).on('click', '.toggle-password', function () {

                const target = $($(this).data('target'));

                const icon = $(this).find('i');

                if (target.attr('type') === 'password') {

                    target.attr('type', 'text');

                    icon.removeClass('bi-eye').addClass('bi-eye-slash');

                } else {

                    target.attr('type', 'password');

                    icon.removeClass('bi-eye-slash').addClass('bi-eye');

                }

            });

            $('#formRegisterBUJP').submit(function (e) {

                e.preventDefault();

                let formData = new FormData(this);

                if (uploadedFile) {
                    formData.append("sio_file", uploadedFile);
                }

                $.ajax({

                    url: $(this).attr('action'),

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

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: res.message,

                            confirmButtonColor: '#ffc107',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

                        }).then(() => {

                            window.location.href = res.redirect;

                        });

                    },

                    error: function (xhr) {

                        let message = "Terjadi kesalahan.";

                        if (xhr.status === 422) {

                            if (xhr.responseJSON.errors) {

                                const errors = xhr.responseJSON.errors;

                                message = Object.values(errors)[0][0];

                            } else if (xhr.responseJSON.message) {

                                message = xhr.responseJSON.message;

                            }

                        } else if (xhr.responseJSON?.message) {

                            message = xhr.responseJSON.message;

                        }

                        Swal.fire({

                            icon: 'error',

                            title: 'Oops...',

                            text: message,

                            confirmButtonColor: '#ffc107',
                            didOpen: () => {
                                document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                                document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                            }

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
                Swal.fire({
                    icon: "{{ session('swal.icon') }}",
                    title: "{{ session('swal.title') }}",
                    text: "{{ session('swal.text') }}",
                    confirmButtonColor: '#ffc107',
                    background: '#152040',
                    color: 'white',
                    didOpen: () => {
                        document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                        document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                    }
                });
            </script>
        @endif
    </body>
</html>