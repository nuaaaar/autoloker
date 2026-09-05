<style>
    .profile-complete-card{

        background:#2a2322;

        border:1px solid rgba(246,176,0,.35);

        border-radius:22px;

        padding:12px 18px;

    }

    .profile-complete-icon{

        width:54px;
        height:54px;

        border-radius:18px;

        background:rgba(246,176,0,.08);

        border:1px solid rgba(246,176,0,.25);

        display:flex;
        align-items:center;
        justify-content:center;

        color:#f6b000;

        flex-shrink:0;

    }

    .profile-complete-title{

        color:#ffffff;

        font-size:14px;

        font-weight:700;

        /* line-height:1.2; */

    }

    .profile-complete-subtitle{

        margin-top:4px;

        color:#8d9bb7;

        font-size:11px;

        line-height:1.4;

    }

    .btn-profile-complete-now{

        display:flex;
        align-items:center;
        justify-content:center;

        gap:8px;

        height:32px;

        padding:0 22px;

        border:none;

        border-radius:16px;

        background:#f6b000;

        color:#111827;

        font-size:11px;

        font-weight:700;

        transition:.25s;

        white-space:nowrap;

    }

    .btn-profile-complete-now:hover{

        background:#ffc21a;

    }

    .btn-profile-complete-now i{

        color:#111827;

    }


    /*==================================
    LIGHT MODE
    ==================================*/

    [data-bs-theme="light"] .profile-complete-card{

        background:#fffbf2;

        border-color:rgba(246,176,0,.35);

    }

    [data-bs-theme="light"] .profile-complete-icon{

        background:rgba(246,176,0,.10);

        border-color:rgba(246,176,0,.30);

        color:#d18f00;

    }

    [data-bs-theme="light"] .profile-complete-title{

        color:#1e293b;

    }

    [data-bs-theme="light"] .profile-complete-subtitle{

        color:#64748b;

    }

    [data-bs-theme="light"] .btn-profile-complete-now{

        background:#f6b000;

        color:#111827;

    }

    [data-bs-theme="light"] .btn-profile-complete-now:hover{

        background:#ffc21a;

    }

    [data-bs-theme="light"] .btn-profile-complete-now i{

        color:#111827;

    }


    @media(max-width:768px){

        .profile-complete-card{

            padding:16px;

        }

        .profile-complete-icon{

            width:46px;
            height:46px;

            border-radius:14px;

        }

        .profile-complete-title{

            font-size:15px;

        }

        .profile-complete-subtitle{

            font-size:12px;

        }

        .btn-profile-complete-now{

            margin-top:15px;

            width:100%;

            height:42px;

            font-size:14px;

        }

        .profile-complete-card .d-flex{

            flex-direction:column;
            align-items:flex-start !important;

        }

        .profile-complete-card .flex-grow-1{

            margin:15px 0 0 0 !important;
            width:100%;

        }

    }
</style>

<div class="profile-complete-card mb-5">

    <div class="d-flex align-items-center">

        <!-- Icon -->

        <div class="profile-complete-icon">

            <i class="ki-duotone ki-user fs-2 text-warning">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>

        </div>

        <!-- Content -->

        <div class="flex-grow-1 ms-4">

            <div class="profile-complete-title">
                Data diri belum lengkap
            </div>

            <div class="profile-complete-subtitle">
                Lengkapi data untuk muncul di pencarian perekrut
            </div>

        </div>

    </div>

</div>