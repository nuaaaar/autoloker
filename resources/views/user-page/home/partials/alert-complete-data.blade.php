<style>

    .profile-alert-card{

        position:relative;

        background:#2a151c;

        border:1px solid rgba(255,75,90,.55);

        border-radius:14px;

        padding:14px;

    }


    .profile-alert-close{

        position:absolute;

        right:10px;
        top:10px;

        background:none;
        border:none;

        color:#d85d67;

        transition:.2s;

    }


    .profile-alert-close:hover{

        color:#ff6d78;

    }


    .profile-alert-icon{

        width:68px;
        height:68px;

        min-width:68px;

        border-radius:22px;

        background:rgba(255,70,85,.08);

        border:1px solid rgba(255,70,85,.35);

        display:flex;

        align-items:center;
        justify-content:center;

        color:#ff6672;

    }


    .profile-alert-title{

        color:#ff737c;

        font-size:14px;

        font-weight:700;

    }


    .profile-alert-badge{

        padding:3px 8px;

        border-radius:999px;

        border:1px solid rgba(255,70,85,.4);

        background:rgba(255,70,85,.08);

        color:#ff7c84;

        font-weight:700;

        font-size:10px;

    }


    .profile-alert-desc{

        color:#f0a1a7;

        font-size:8px;

    }


    .profile-alert-progress{

        height:6px;

        background:#58242d;

        border-radius:30px;

    }


    .profile-alert-progress .progress-bar{

        background:#ff646d;

        border-radius:30px;

    }


    .profile-alert-detail{

        display:inline-flex;

        align-items:center;

        margin-top:10px;

        color:#ff727c;

        text-decoration:none;

        font-size:10px;

        font-weight:700;

    }


    .profile-alert-detail:hover{

        color:#ff8c94;

    }


    .profile-alert-list{

        display:none;

        margin-top:8px;

    }


    .profile-alert-item{

        color:#efb1b5;

        margin-bottom:8px;

        font-size:10px;

    }


    .btn-profile-complete{

        height:32px;

        border:none;

        border-radius:12px;

        background:#ff2f41;

        color:#fff;

        font-size:11px;

        font-weight:700;

        transition:.2s;

    }


    .btn-profile-complete:hover{

        background:#ff4455;

    }


    .btn-upload-cert{

        height:32px;

        border-radius:12px;

        background:transparent;

        border:1px solid rgba(255,70,85,.45);

        color:#ff6b76;

        font-size:11px;

        font-weight:700;

        transition:.2s;

    }


    .btn-upload-cert:hover{

        background:#ff2f41;

        color:#fff;

    }



    /* =====================================================
       LIGHT MODE
    ===================================================== */

    [data-bs-theme="light"] .profile-alert-card{

        background:
            linear-gradient(
                145deg,
                #fff7f8 0%,
                #fff1f3 100%
            );

        border-color:rgba(220,38,55,.25);

        box-shadow:
            0 10px 30px rgba(220,38,55,.06);

    }


    /* Close */

    [data-bs-theme="light"] .profile-alert-close{

        color:#c2414d;

    }


    [data-bs-theme="light"] .profile-alert-close:hover{

        color:#e11d2e;

    }


    /* Icon */

    [data-bs-theme="light"] .profile-alert-icon{

        background:rgba(255,70,85,.07);

        border-color:rgba(220,38,55,.22);

        color:#e54855;

    }


    /* Title */

    [data-bs-theme="light"] .profile-alert-title{

        color:#c92f3d;

    }


    /* Badge */

    [data-bs-theme="light"] .profile-alert-badge{

        border-color:rgba(220,38,55,.25);

        background:rgba(220,38,55,.06);

        color:#c92f3d;

    }


    /* Description */

    [data-bs-theme="light"] .profile-alert-desc{

        color:#8f4b53;

    }


    /* Progress */

    [data-bs-theme="light"] .profile-alert-progress{

        background:#f4d7da;

    }


    [data-bs-theme="light"] .profile-alert-progress .progress-bar{

        background:#ef4b58;

    }


    /* Detail */

    [data-bs-theme="light"] .profile-alert-detail{

        color:#d33b48;

    }


    [data-bs-theme="light"] .profile-alert-detail:hover{

        color:#e11d2e;

    }


    /* List */

    [data-bs-theme="light"] .profile-alert-item{

        color:#8f4b53;

    }


    /* Complete button */

    [data-bs-theme="light"] .btn-profile-complete{

        background:#e93647;

        color:#fff;

    }


    [data-bs-theme="light"] .btn-profile-complete:hover{

        background:#d92739;

    }


    /* Upload certificate */

    [data-bs-theme="light"] .btn-upload-cert{

        background:rgba(255,255,255,.5);

        border-color:rgba(220,38,55,.25);

        color:#d33b48;

    }


    [data-bs-theme="light"] .btn-upload-cert:hover{

        background:#e93647;

        border-color:#e93647;

        color:#fff;

    }



    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media(max-width:768px){

        .profile-alert-card{

            padding:20px;

        }


        .profile-alert-title{

            font-size:14px;

        }


        .profile-alert-desc{

            font-size:14px;

        }


        .btn-profile-complete,
        .btn-upload-cert{

            height:42px;

            font-size:11px;

        }


        .profile-alert-icon{

            width:56px;
            height:56px;

            min-width:56px;

        }

    }

</style>

<div class="profile-alert-card mb-5">

    <!-- Close -->
    <button class="profile-alert-close">

        <i class="ki-duotone ki-cross fs-2 text-danger">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>

    </button>

    <div class="d-flex">

        <!-- ICON -->

        <div class="profile-alert-icon">

            <i class="ki-duotone ki-information-4 fs-1 text-danger">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>

        </div>


        <!-- CONTENT -->

        <div class="flex-grow-1 ms-5">

            <div class="d-flex align-items-center flex-wrap gap-3">

                <h3 class="profile-alert-title mb-0">
                    Data Diri Belum Lengkap!
                </h3>

                <span class="profile-alert-badge">
                    {{ $profile_progress['progress'] }}% selesai
                </span>

            </div>

            <div class="profile-alert-desc mt-3">

                Anda belum dapat <b>melamar lowongan</b> atau
                <b>mendaftar pelatihan</b> sebelum melengkapi data diri.
                Segera lengkapi agar bisa terhubung dengan BUJP.

            </div>


            <!-- Progress -->

            <div class="progress profile-alert-progress mt-4">

                <div class="progress-bar"
                    style="width:{{ $profile_progress['progress'] }}%">
                </div>

            </div>


            <!-- Detail -->

            <a href="javascript:;" class="profile-alert-detail">

                <i class="ki-duotone ki-down fs-5 me-2 text-danger"></i>

                Lihat {{ $profile_progress['total'] - $profile_progress['completed'] }} data yang kurang

            </a>


            <!-- Hidden -->

            <div class="profile-alert-list">

                @foreach($profile_progress['missing'] as $item)
                    <div class="profile-alert-item">
                        <i class="ki-duotone ki-cross-circle text-danger me-2"></i>
                        {{ $item }}
                    </div>
                @endforeach

            </div>


            <!-- BUTTON -->

            <div class="row mt-5">

                <div class="col-lg-6 mb-3">
                    <a href="{{ route('user-page.profile.edit-personal-data', Auth::user()->user_security->security->uuid) }}">
                        <button class="btn-profile-complete w-100">

                            <i class="ki-duotone ki-user fs-5 me-1 text-white"></i>

                            Lengkapi Data Diri

                        </button>
                    </a>
                </div>

                <div class="col-lg-6">

                    {{-- <button class="btn-upload-cert w-100">

                        <i class="ki-duotone ki-award fs-5 me-1 text-white"></i>

                        Upload Sertifikat

                    </button> --}}

                </div>

            </div>

        </div>

    </div>

</div>