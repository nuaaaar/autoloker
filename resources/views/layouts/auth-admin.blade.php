<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="canonical" href="http://preview.keenthemes.com/?page=authentication/layouts/corporate/sign-in"/>
    <link rel="shortcut icon" href="/assets/media/logos/autoloker-logo-small.png"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/> 
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Login Admin</title>
    <style>
        body{
            background:#0e1628;
        }

        .admin-login-left{

            background:linear-gradient(135deg,#16284c,#0f172a);

            justify-content:center;

            align-items:center;

        }

        .login-brand{

            text-align:center;

        }

        .login-brand h1{

            color:#fff;

            font-size:55px;

            font-weight:700;

        }

        .login-brand p{

            color:#95a2bf;

            font-size:18px;

        }

        .login-card{

            width:100%;
            max-width:420px;

            background:#121c33;

            border:1px solid #2b3852;

            border-radius:20px;

            padding:40px;

        }

        .login-logo{

            width:75px;
            height:75px;

            margin:auto;

            border-radius:18px;

            background:#1a2645;

            display:flex;

            align-items:center;

            justify-content:center;

            margin-bottom:20px;

        }

        .login-title{

            color:white;

            font-size:28px;

            font-weight:700;

        }

        .login-subtitle{

            color:#8d9ab4;

            font-size:14px;

        }

        .form-label{

            color:#d7def0;

            font-weight:600;

        }

        .input-group-text{

            background:#1c2547;

            border:1px solid #2b3852;

            color:#8d9ab4;

        }

        .admin-input{

            background:#1c2547 !important;

            border:1px solid #2b3852 !important;

            color:white !important;

            height:48px;

        }

        .admin-input:focus{

            box-shadow:none;

            border-color:#f6b000 !important;

        }

        .btn-password{

            background:#1c2547;

            border:1px solid #2b3852;

            color:#95a2bf;

        }

        .btn-password:hover{

            background:#263253;

            color:#f6b000;

        }

        .btn-login-admin{

            height:50px;

            border:none;

            border-radius:12px;

            background:#f6b000;

            color:#111;

            font-size:15px;

            font-weight:700;

            transition:.2s;

        }

        .btn-login-admin:hover{

            background:#ffc526;

        }
    </style>
</head>
<body>
    <form action="{{ route('sign-in-admin') }}" method="POST">
        @csrf
        <div class="container-fluid vh-100">

            <div class="row h-100">

                <div class="col-lg-8 d-none d-lg-flex admin-login-left">

                    <div class="login-brand">

                        <h1>AUTOLOKER</h1>

                        <p>
                            Administration Panel
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-12 d-flex align-items-center justify-content-center">

                    <div class="login-card">

                        <div class="text-center mb-8">

                            <div class="login-logo">

                                <i class="ki-duotone ki-security-user fs-1 text-warning"></i>

                            </div>

                            <h2 class="login-title">
                                Login Admin
                            </h2>

                            <div class="login-subtitle">
                                Masuk menggunakan akun administrator.
                            </div>

                        </div>

                        <form method="POST" action="#">

                            @csrf

                            <div class="mb-5">

                                <label class="form-label">
                                    Email
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="ki-duotone ki-sms"></i>
                                    </span>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control admin-input"
                                        placeholder="admin@email.com">

                                </div>

                            </div>

                            <div class="mb-7">

                                <label class="form-label">
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="ki-duotone ki-lock-2"></i>
                                    </span>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control admin-input"
                                        placeholder="••••••••">

                                    <button
                                        class="btn btn-password"
                                        type="button"
                                        id="togglePassword">

                                        <i class="ki-duotone ki-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <button class="btn btn-login-admin w-100">

                                Login

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>
    </form>

    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/js/custom/authentication/sign-in/general.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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