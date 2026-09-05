@extends('layouts.user-page')

@section('title', 'Jejaring')

@section('content')

    <div class="container-xxl">

        @include('user-page.network.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>


            <!-- Content -->
            <div class="col-12 col-lg-8">

                <div class="coming-soon-card">

                    <!-- Decorative -->
                    <div class="coming-glow coming-glow-1"></div>
                    <div class="coming-glow coming-glow-2"></div>

                    <div class="coming-content">

                        <!-- Icon -->
                        <div class="coming-icon-wrapper">

                            <div class="coming-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                        </div>


                        <!-- Badge -->
                        <div class="coming-badge">
                            <span></span>
                            SEGERA HADIR
                        </div>


                        <!-- Title -->
                        <h1 class="coming-title">
                            Fitur Baru
                            <span>Segera Hadir</span>
                        </h1>


                        <!-- Description -->
                        <p class="coming-description">
                            Kami sedang mempersiapkan fitur baru untuk memberikan
                            pengalaman terbaik bagi kamu dalam menemukan dan melamar
                            pekerjaan security.
                        </p>


                        <!-- Feature Preview -->
                        <div class="feature-preview">

                            <div class="feature-item">

                                <div class="feature-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>

                                <div>
                                    <strong>
                                        Lebih Banyak Peluang
                                    </strong>

                                    <small>
                                        Temukan lowongan security terbaik
                                    </small>
                                </div>

                            </div>


                            <div class="feature-item">

                                <div class="feature-icon">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>

                                <div>
                                    <strong>
                                        Proses Lebih Cepat
                                    </strong>

                                    <small>
                                        Lamar pekerjaan dengan mudah
                                    </small>
                                </div>

                            </div>


                            <div class="feature-item">

                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div>
                                    <strong>
                                        Lebih Terpercaya
                                    </strong>

                                    <small>
                                        Akses peluang kerja terverifikasi
                                    </small>
                                </div>

                            </div>

                        </div>


                        <!-- Back Button -->
                        <a href="{{ url()->previous() }}"
                           class="btn btn-coming-back">

                            <i class="bi bi-arrow-left me-2"></i>

                            Kembali

                        </a>

                    </div>

                </div>

            </div>


            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>

    </div>


    <style>

        /* =====================================================
        COMING SOON
        ===================================================== */

        .coming-soon-card {

            position: relative;

            min-height: 620px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            border-radius: 24px;

            background:
                linear-gradient(
                    145deg,
                    #111a35 0%,
                    #0d142b 55%,
                    #0a1022 100%
                );

            border: 1px solid rgba(255,255,255,.07);

            box-shadow:
                0 20px 60px rgba(0,0,0,.15);

        }


        /* =====================================================
        GLOW
        ===================================================== */

        .coming-glow {

            position: absolute;

            border-radius: 50%;

            filter: blur(5px);

            pointer-events: none;

        }


        .coming-glow-1 {

            width: 320px;
            height: 320px;

            top: -170px;
            right: -100px;

            background: rgba(232,164,1,.13);

        }


        .coming-glow-2 {

            width: 280px;
            height: 280px;

            bottom: -160px;
            left: -100px;

            background: rgba(50,90,180,.12);

        }


        /* =====================================================
        CONTENT
        ===================================================== */

        .coming-content {

            position: relative;

            z-index: 2;

            width: 100%;

            max-width: 650px;

            padding: 60px 35px;

            text-align: center;

        }


        /* =====================================================
        ICON
        ===================================================== */

        .coming-icon-wrapper {

            display: flex;

            justify-content: center;

            margin-bottom: 25px;

        }


        .coming-icon {

            width: 82px;
            height: 82px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 22px;

            background:
                linear-gradient(
                    145deg,
                    rgba(232,164,1,.20),
                    rgba(232,164,1,.07)
                );

            border: 1px solid rgba(232,164,1,.25);

            box-shadow:
                0 15px 40px rgba(232,164,1,.12);

        }


        .coming-icon i {

            font-size: 38px;

            color: #e8a401;

        }


        /* =====================================================
        BADGE
        ===================================================== */

        .coming-badge {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 7px 14px;

            border-radius: 30px;

            background: rgba(232,164,1,.08);

            border: 1px solid rgba(232,164,1,.15);

            color: #e8a401;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.5px;

            margin-bottom: 18px;

        }


        .coming-badge span {

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: #e8a401;

            box-shadow:
                0 0 0 4px rgba(232,164,1,.10);

        }


        /* =====================================================
        TITLE
        ===================================================== */

        .coming-title {

            margin: 0;

            font-size: clamp(36px, 5vw, 54px);

            font-weight: 800;

            line-height: 1.12;

            letter-spacing: -1.5px;

            color: #ffffff;

        }


        .coming-title span {

            display: block;

            color: #e8a401;

        }


        /* =====================================================
        DESCRIPTION
        ===================================================== */

        .coming-description {

            max-width: 540px;

            margin: 22px auto 35px;

            color: #9da6bb;

            font-size: 14px;

            line-height: 1.8;

        }


        /* =====================================================
        FEATURE PREVIEW
        ===================================================== */

        .feature-preview {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 10px;

            margin-bottom: 35px;

        }


        .feature-item {

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 10px;

            padding: 18px 10px;

            background: rgba(255,255,255,.035);

            border: 1px solid rgba(255,255,255,.06);

            border-radius: 14px;

            transition: all .25s ease;

        }


        .feature-item:hover {

            transform: translateY(-3px);

            background: rgba(255,255,255,.055);

            border-color:
                rgba(232,164,1,.18);

        }


        .feature-icon {

            width: 38px;
            height: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: rgba(232,164,1,.09);

            color: #e8a401;

        }


        .feature-icon i {

            font-size: 17px;

        }


        .feature-item strong {

            display: block;

            color: #ffffff;

            font-size: 11px;

            font-weight: 700;

        }


        .feature-item small {

            display: block;

            margin-top: 3px;

            color: #737d94;

            font-size: 9px;

            line-height: 1.4;

        }


        /* =====================================================
        BUTTON
        ===================================================== */

        .btn-coming-back {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            height: 44px;

            padding: 0 22px;

            border-radius: 11px;

            background: rgba(255,255,255,.06);

            border: 1px solid rgba(255,255,255,.09);

            color: #c8cedb;

            font-size: 12px;

            font-weight: 700;

            transition: all .25s ease;

        }


        .btn-coming-back:hover {

            background: #e8a401;

            border-color: #e8a401;

            color: #111827;

            transform: translateY(-2px);

        }



        /* =====================================================
        LIGHT MODE
        HANYA OVERRIDE WARNA DARK
        ===================================================== */

        [data-bs-theme="light"] .coming-soon-card {

            background:
                linear-gradient(
                    145deg,
                    #ffffff 0%,
                    #f8fafc 55%,
                    #f1f5f9 100%
                );

            border-color: rgba(15,23,42,.08);

            box-shadow:
                0 20px 60px rgba(15,23,42,.08);

        }


        /* Glow light mode */

        [data-bs-theme="light"] .coming-glow-1 {

            background: rgba(232,164,1,.12);

        }


        [data-bs-theme="light"] .coming-glow-2 {

            background: rgba(50,90,180,.08);

        }


        /* Icon */

        [data-bs-theme="light"] .coming-icon {

            background:
                linear-gradient(
                    145deg,
                    rgba(232,164,1,.16),
                    rgba(232,164,1,.05)
                );

            border-color: rgba(232,164,1,.25);

            box-shadow:
                0 15px 40px rgba(232,164,1,.10);

        }


        /* Badge */

        [data-bs-theme="light"] .coming-badge {

            background: rgba(232,164,1,.08);

            border-color: rgba(232,164,1,.20);

            color: #b77900;

        }


        [data-bs-theme="light"] .coming-badge span {

            background: #e8a401;

        }


        /* Title */

        [data-bs-theme="light"] .coming-title {

            color: #111827;

        }


        [data-bs-theme="light"] .coming-title span {

            color: #d89500;

        }


        /* Description */

        [data-bs-theme="light"] .coming-description {

            color: #64748b;

        }


        /* Feature */

        [data-bs-theme="light"] .feature-item {

            background: rgba(15,23,42,.035);

            border-color: rgba(15,23,42,.07);

        }


        [data-bs-theme="light"] .feature-item:hover {

            background: rgba(232,164,1,.055);

            border-color: rgba(232,164,1,.20);

        }


        [data-bs-theme="light"] .feature-icon {

            background: rgba(232,164,1,.10);

            color: #d89500;

        }


        [data-bs-theme="light"] .feature-item strong {

            color: #1e293b;

        }


        [data-bs-theme="light"] .feature-item small {

            color: #64748b;

        }


        /* Button */

        [data-bs-theme="light"] .btn-coming-back {

            background: rgba(15,23,42,.045);

            border-color: rgba(15,23,42,.09);

            color: #475569;

        }


        [data-bs-theme="light"] .btn-coming-back:hover {

            background: #e8a401;

            border-color: #e8a401;

            color: #111827;

        }



        /* =====================================================
        RESPONSIVE
        ===================================================== */

        @media (max-width: 767px) {

            .coming-soon-card {

                min-height: 560px;

                border-radius: 18px;

            }


            .coming-content {

                padding: 45px 20px;

            }


            .coming-icon {

                width: 70px;
                height: 70px;

                border-radius: 18px;

            }


            .coming-icon i {

                font-size: 32px;

            }


            .coming-title {

                font-size: 36px;

            }


            .coming-description {

                font-size: 13px;

                line-height: 1.7;

            }


            .feature-preview {

                grid-template-columns: 1fr;

                gap: 8px;

            }


            .feature-item {

                flex-direction: row;

                text-align: left;

                padding: 13px;

            }


            .feature-icon {

                flex-shrink: 0;

            }

        }

    </style>

@endsection
