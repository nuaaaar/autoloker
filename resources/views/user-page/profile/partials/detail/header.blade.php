<style>
    /* ===========================================
    PROFILE HEADER
    =========================================== */

    .profile-header-card{
        background:#121c33;
        border:1px solid #29344b;
        border-radius:22px;
        overflow:hidden;
        box-shadow:none;
    }

    /* Cover */

    .profile-cover{

        height: 120px;

        background:
            repeating-linear-gradient(
                45deg,
                #203766,
                #203766 2px,
                #22355d 2px,
                #22355d 20px
            );

    }

    /* Body */

    .profile-header-card .card-body{
        padding:0 20px 15px;
    }

    /* ===========================================
    AVATAR
    =========================================== */

    .profile-avatar-wrapper{

        position:relative;
        display:inline-block;

        margin-top:-85px;

    }

    .profile-avatar{

        width: 85px;
        height: 85px;

        border-radius:50%;

        border:6px solid #121c33;

        object-fit:cover;

        background:#fff;

    }

    .profile-verified{

        position:absolute;

        bottom:8px;
        right:5px;

        width: 26px;
        height: 26px;

        border-radius:50%;

        background:#f6b000;

        border:3px solid #121c33;

        display:flex;
        align-items:center;
        justify-content:center;

        color:#000;

    }

    /* ===========================================
    TEXT
    =========================================== */

    .profile-name{

        color:#fff;

        font-size: 18px;

        font-weight:700;

        line-height:1.2;

        margin:8px 0 6px;

    }

    .profile-position{

        color:#95a2bf;

        font-size: 11px;

        font-weight:500;

    }

    /* ===========================================
    META
    =========================================== */

    .profile-meta{

        display:flex;

        align-items:center;

        flex-wrap:wrap;

        gap: 15px;

        color:#95a2bf;

        font-size: 11px;

    }

    .profile-meta i{

        color:#f6b000;

        margin-right:4px;

    }

    /* ===========================================
    BADGE
    =========================================== */

    .badge-license{

        display:inline-flex;

        align-items:center;

        gap: 2px;

        padding: 2px 8px;

        border-radius:8px;

        border:1px solid rgba(246,176,0,.35);

        background:rgba(246,176,0,.08);

        color:#f6b000;

        font-size: 10px;

        font-weight:600;

    }

    /* ===========================================
    STAT
    =========================================== */

    .profile-stat{

        display:flex;

        align-items:center;

        flex-wrap:wrap;

        color:#98a5bf;

        font-size: 11px;

    }

    .profile-stat strong{

        color:#fff;

    }

    /* ===========================================
    BUTTON EDIT
    =========================================== */

    .btn-edit-profile{

        border: 2px solid #f6b000 !important;

        color:#f6b000;

        background:transparent;

        border-radius:40px;

        padding: 4px 12px !important;

        font-size: 11px;

        font-weight:700;

        transition:.25s;

        margin-top: 20px;

    }

    .btn-edit-profile:hover{

        background:#f6b000;

        color:#111;

    }

    /* ===========================================
    ACTION BUTTON
    =========================================== */

    .btn-profile-primary,
    .btn-profile-secondary{

        display:flex;
        align-items:center;
        justify-content:center;

        width:100%;
        height:30px;

        border-radius:14px;

        font-size:11px;
        font-weight:700;

        padding:0;

        line-height:1;

    }

    /* Primary */
    .btn-profile-primary{

        background:#f6b000;
        color:#111;
        border:none;
        transition:.2s;

    }

    .btn-profile-primary:hover{

        background:#ffc21a;
        color:#111;

    }

    /* Secondary */
    .btn-profile-secondary{

        background:transparent;
        border:1px solid #2d3952 !important;
        color:#9ba7bf;
        transition:.2s;

    }

    .btn-profile-secondary:hover{

        border-color:#f6b000 !important;
        color:#f6b000;

    }
    /* ===========================================
    TAB
    =========================================== */

    .profile-tab{

        display:flex;
        align-items:center;

        gap:15px;

        padding:15px 25px;

        border-top:1px solid #283550;

        overflow-x:auto;

    }

    .profile-tab::-webkit-scrollbar{
        display:none;
    }

    .profile-tab a{

        position:relative;

        display:inline-flex;
        align-items:center;

        color:#95a2bf;

        text-decoration:none;

        font-size:11px;
        font-weight:600;

        white-space:nowrap;

        padding-bottom: 8px;

        transition:.2s;

    }

    .profile-tab a:hover{

        color:#f6b000;

    }

    .profile-tab a.active{

        color:#f6b000;

    }

    .profile-tab a.active::after{

        content:"";

        position:absolute;

        left:0;
        bottom:0;

        width:100%;
        height:3px;

        background:#f6b000;

        border-radius:20px 20px 0 0;

    }

    /* ===========================================
    CONTENT CARD
    =========================================== */

    .profile-section-card{

        background:#121c33;

        border:1px solid #29344b;

        border-radius:22px;

        overflow:hidden;

    }

    .profile-section-card .card-body{

        padding:32px;

    }

    .section-title{

        color:#fff;

        font-size: 18px;

        font-weight:700;

        margin-bottom:18px;

    }

    .section-text{

        color:#96a3bc;

        font-size: 12px;

        line-height:1.9;

    }

    /* ===========================================
    RESPONSIVE
    =========================================== */

    @media(max-width:991px){

        .profile-cover{

            height: 120px;

        }

        .profile-header-card .card-body{

            padding:0 22px 25px;

        }

        .profile-avatar-wrapper{

            margin-top: -55px;

        }

        .profile-avatar{

            width:95px;
            height:95px;

            border-width:5px;

        }

        .profile-verified{

            width:26px;
            height:26px;

            border-width:2px;

        }

        .profile-name{

            font-size:26px;

        }

        .profile-position{

            font-size: 11px !important;

        }

        .profile-meta{

            font-size:13px;

            gap:10px;

        }

        .badge-license{

            font-size:11px;

            padding:4px 10px;

        }

        .profile-stat{

            font-size:13px;

            gap:8px;

        }

        .btn-edit-profile{

            width:100%;

            margin-top:20px;

        }

        .btn-profile-primary,
        .btn-profile-secondary{

            height: 36px;

            font-size: 12px;

        }

        .profile-tab{

            padding:15px 20px;

            gap: 24px;

        }

        .profile-tab a{

            font-size: 11px;

        }

        .section-title{

            font-size: 14px;

        }

        .section-text{

            font-size: 11px;

        }

    }

    .profile-tab{

        display:flex;
        align-items:center;
        gap:15px;

        padding:15px 25px;

        border-top:1px solid #283550;

        overflow-x:auto;

    }

    .profile-tab::-webkit-scrollbar{
        display:none;
    }

    .profile-menu{

        position:relative;

        color:#95a2bf;

        text-decoration:none;

        font-size:11px;

        font-weight:600;

        white-space:nowrap;

        transition:.25s;

        padding-bottom:14px;

    }

    .profile-menu:hover{

        color:#f6b000;

    }

    .profile-menu.active{

        color:#f6b000;

    }

    .profile-menu::after{

        content:"";

        position:absolute;

        left:0;
        bottom:0;

        width:0;

        height:3px;

        background:#f6b000;

        border-radius:20px;

        transition:.25s;

    }

    .profile-menu:hover::after{

        width:100%;

    }

    .profile-menu.active::after{

        width:100%;

    }

    .profile-page{

        animation:fadeProfile .25s ease;

    }

    @keyframes fadeProfile{

        from{

            opacity:0;
            transform:translateY(8px);

        }

        to{

            opacity:1;
            transform:translateY(0);

        }

    }
</style>

<div class="card profile-header-card mb-5">

    <!-- Cover -->
    <div class="profile-cover"></div>

    <div class="card-body position-relative">

        <div class="row align-items-start">

            <!-- =========================
                 PROFILE
            ========================== -->
            <div class="col-lg-8">

                <!-- Avatar -->
                <div class="profile-avatar-wrapper">

                    <img src="/assets/media/avatars/300-3.jpg"
                        class="profile-avatar">

                    <span class="profile-verified">
                        <i class="ki-duotone ki-check-circle fs-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>

                </div>

                <!-- Nama -->
                <h1 class="profile-name mt-4 mb-1">
                    Budi Santoso
                </h1>

                <!-- Jabatan -->
                <div class="profile-position">
                    Satpam Gada Pratama • PT Tekno Putra Perkasa
                </div>

                <!-- Info -->
                <div class="profile-meta mt-4">

                    <span>

                        <i class="ki-duotone ki-geolocation me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        Jakarta Selatan

                    </span>

                    <span class="badge-license">

                        <i class="ki-duotone ki-shield-tick me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        Gada Pratama

                    </span>

                </div>

                <!-- Statistik -->
                <div class="profile-stat mt-4 d-flex align-items-center flex-wrap">

                    <span class="text-warning fw-bold">

                        284 Koneksi

                    </span>

                    <span class="mx-4 text-muted">
                        •
                    </span>

                    <span>

                        NRP : <strong class="text-white">TPP-2019-00472</strong>

                    </span>

                </div>

            </div>

            <!-- =========================
                 BUTTON EDIT
            ========================== -->
            {{-- <div class="col-lg-4 text-lg-end mt-5 mt-lg-0">

                <button class="btn btn-edit-profile">

                    <i class="ki-duotone ki-pencil me-2 text-warning">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                    Edit Profil

                </button>

            </div> --}}

        </div>

        <!-- =========================
             BUTTON ACTION
        ========================== -->

        <div class="row mt-8">

            <div class="col-md-12 mb-3">
                <a href="{{ route('user-page.profile.edit-personal-data', Auth::user()->user_security->security->uuid) }}">
                    <button class="btn btn-profile-primary w-100">

                        Edit Data Diri

                    </button>
                </a>

            </div>

        </div>

    </div>

    <!-- =========================
         TAB MENU
    ========================== -->

    <div class="profile-tab">

        <a href="javascript:void(0)"
        class="profile-menu active"
        data-target="about">
            About
        </a>

        <a href="javascript:void(0)"
        class="profile-menu"
        data-target="sertifikat">
            Sertifikasi
        </a>

        <a href="javascript:void(0)"
        class="profile-menu"
        data-target="riwayat">
            Riwayat
        </a>

        <a href="javascript:void(0)"
        class="profile-menu"
        data-target="skills">
            Skills
        </a>

        <a href="javascript:void(0)"
        class="profile-menu"
        data-target="rekomendasi">
            Rekomendasi
        </a>

    </div>

</div>

<div class="profile-content">

    <div id="about" class="profile-page">

        @include('user-page.profile.partials.about')

    </div>

    <div id="sertifikat" class="profile-page d-none">

        @include('user-page.profile.partials.certificate')

    </div>

    <div id="riwayat" class="profile-page d-none">

        @include('user-page.profile.partials.history')

    </div>

    <div id="skills" class="profile-page d-none">

        @include('user-page.profile.partials.skills')

    </div>

    <div id="rekomendasi" class="profile-page d-none">

        @include('user-page.profile.partials.recommendation')

    </div>

</div>