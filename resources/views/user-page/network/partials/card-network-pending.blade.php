<style>
    /*==========================
    Invitation Card
    ===========================*/

    .network-user-card{

        background:#121c32;
        border:1px solid #26344c;
        border-radius:18px;

        padding:20px;

        transition:.25s;

    }

    .network-user-card:hover{

        border-color:#e8a401;
        transform:translateY(-2px);

    }

    .network-avatar{

        width:46px;
        height:46px;

        border-radius:50%;
        object-fit:cover;

    }

    .network-name{

        color:#F4F7FB;
        font-size:14px;
        font-weight:700;

        margin-bottom:2px;

    }

    .network-job{

        color:#a7b2cb;
        font-size:11px;
        line-height:1.2;

    }

    .network-company{

        color:#8b96b2;
        font-size:11px;

    }

    .network-mutual{

        color:#8894ad;
        font-size:11px;
        margin-left:5px;

    }

    /*==========================
    Badge
    ===========================*/

    .network-badge{

        display:inline-flex;
        align-items:center;

        padding:2px 6px;

        border-radius:6px;

        font-size:9px;
        font-weight:600;

        border:1px solid;

    }

    .badge-yellow{

        color:#e8a401;
        background:rgba(232,164,1,.10);
        border-color:rgba(232,164,1,.40);

    }

    .badge-blue{

        color:#58a8ff;
        background:rgba(42,134,255,.10);
        border-color:rgba(42,134,255,.40);

    }

    .badge-green{

        color:#10d48c;
        background:rgba(16,212,140,.10);
        border-color:rgba(16,212,140,.40);

    }

    /*==========================
    Button
    ===========================*/

    .btn-connect{

        height:32px;

        border-radius:30px;

        background:transparent;
        border:2px solid #e8a401;

        color:#e8a401;

        font-weight:700;
        font-size:11px;

        transition:.25s;

    }

    .btn-connect:hover{

        background:#e8a401;
        color:#111827;

    }

    .btn-ignore{

        width:95px;
        height:32px;

        border-radius:30px;

        border:1px solid #2b3953;

        background:transparent;

        color:#8b97b1;

        font-weight:600;
        font-size:11px;

    }

    .btn-ignore:hover{

        background:#202d44;
        color:#fff;

    }


    /*==========================
    Light Mode
    ===========================*/

    [data-bs-theme="light"] .network-user-card{

        background:#ffffff;
        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .network-user-card:hover{

        border-color:#e8a401;

    }

    [data-bs-theme="light"] .network-name{

        color:#1e293b;

    }

    [data-bs-theme="light"] .network-job{

        color:#64748b;

    }

    [data-bs-theme="light"] .network-company{

        color:#64748b;

    }

    [data-bs-theme="light"] .network-mutual{

        color:#94a3b8;

    }

    /* Badge tetap menggunakan warna identitas */
    [data-bs-theme="light"] .badge-yellow{

        color:#c98d00;
        background:rgba(232,164,1,.10);
        border-color:rgba(232,164,1,.35);

    }

    [data-bs-theme="light"] .badge-blue{

        color:#2878c7;
        background:rgba(42,134,255,.08);
        border-color:rgba(42,134,255,.30);

    }

    [data-bs-theme="light"] .badge-green{

        color:#0b9f6a;
        background:rgba(16,212,140,.08);
        border-color:rgba(16,212,140,.30);

    }

    [data-bs-theme="light"] .btn-connect{

        color:#d18f00;
        border-color:#e8a401;

    }

    [data-bs-theme="light"] .btn-connect:hover{

        background:#e8a401;
        color:#111827;

    }

    [data-bs-theme="light"] .btn-ignore{

        border-color:#dbe3ee;
        color:#64748b;

    }

    [data-bs-theme="light"] .btn-ignore:hover{

        background:#f1f5f9;
        color:#334155;

    }


    /*==========================
    Responsive
    ===========================*/

    @media(max-width:991px){

        .network-user-card{

            padding:16px;

        }

        .network-avatar{

            width:54px;
            height:54px;

        }

        .network-name{

            font-size:17px;

        }

        .network-job{

            font-size:13px;

        }

        .network-company{

            font-size:12px;

        }

        .network-mutual{

            font-size:11px;

        }

        .network-badge{

            font-size:10px;
            padding:3px 8px;

        }

        .btn-connect,
        .btn-ignore{

            height:38px;
            font-size:13px;

        }

    }
</style>

<div class="row g-4">

    <!-- Card -->
    <div class="col-lg-6">

        <div class="network-user-card">

            <div class="d-flex">

                <img src="/assets/media/avatars/300-3.jpg"
                     class="network-avatar">

                <div class="flex-grow-1 ms-3">

                    <h5 class="network-name">
                        Agus Priyatno
                    </h5>

                    <div class="network-job">
                        Satpam Gada Madya
                    </div>

                    <div class="network-company">
                        PT BRI Tbk
                    </div>

                    <div class="d-flex align-items-center mt-2">

                        <span class="network-badge badge-blue">
                            <i class="ki-duotone ki-shield-tick fs-7 me-1"></i>
                            Gada Madya
                        </span>

                        <span class="network-mutual">
                            12 koneksi bersama
                        </span>

                    </div>

                </div>

            </div>

            <div class="d-flex mt-4">

                <button class="btn-connect flex-grow-1">
                    Hubungkan
                </button>

                <button class="btn-ignore ms-2">
                    Abaikan
                </button>

            </div>

        </div>

    </div>

    <!-- Card -->
    <div class="col-lg-6">

        <div class="network-user-card">

            <div class="d-flex">

                <img src="/assets/media/avatars/300-4.jpg"
                     class="network-avatar">

                <div class="flex-grow-1 ms-3">

                    <h5 class="network-name">
                        Dewi Ratnasari
                    </h5>

                    <div class="network-job">
                        HR Manager Security
                    </div>

                    <div class="network-company">
                        PT G4S Indonesia
                    </div>

                    <div class="network-mutual mt-2">
                        8 koneksi bersama
                    </div>

                </div>

            </div>

            <div class="d-flex mt-4">

                <button class="btn-connect flex-grow-1">
                    Hubungkan
                </button>

                <button class="btn-ignore ms-2">
                    Abaikan
                </button>

            </div>

        </div>

    </div>

    <!-- Card -->
    <div class="col-lg-6">

        <div class="network-user-card">

            <div class="d-flex">

                <img src="/assets/media/avatars/300-5.jpg"
                     class="network-avatar">

                <div class="flex-grow-1 ms-3">

                    <h5 class="network-name">
                        Firmansyah Putra
                    </h5>

                    <div class="network-job">
                        Asesor BNSP
                    </div>

                    <div class="network-company">
                        LSP Sekuriti Indonesia
                    </div>

                    <div class="d-flex align-items-center mt-2">

                        <span class="network-badge badge-green">
                            <i class="ki-duotone ki-shield-tick fs-7 me-1"></i>
                            Asesor
                        </span>

                        <span class="network-mutual">
                            21 koneksi bersama
                        </span>

                    </div>

                </div>

            </div>

            <div class="d-flex mt-4">

                <button class="btn-connect flex-grow-1">
                    Hubungkan
                </button>

                <button class="btn-ignore ms-2">
                    Abaikan
                </button>

            </div>

        </div>

    </div>

    <!-- Card -->
    <div class="col-lg-6">

        <div class="network-user-card">

            <div class="d-flex">

                <img src="/assets/media/avatars/300-6.jpg"
                     class="network-avatar">

                <div class="flex-grow-1 ms-3">

                    <h5 class="network-name">
                        Rini Wulandari
                    </h5>

                    <div class="network-job">
                        Koordinator Security
                    </div>

                    <div class="network-company">
                        Lippo Mall Kemang
                    </div>

                    <div class="d-flex align-items-center mt-2">

                        <span class="network-badge badge-yellow">
                            <i class="ki-duotone ki-shield-tick fs-7 me-1"></i>
                            Gada Pratama
                        </span>

                        <span class="network-mutual">
                            5 koneksi bersama
                        </span>

                    </div>

                </div>

            </div>

            <div class="d-flex mt-4">

                <button class="btn-connect flex-grow-1">
                    Hubungkan
                </button>

                <button class="btn-ignore ms-2">
                    Abaikan
                </button>

            </div>

        </div>

    </div>

</div>