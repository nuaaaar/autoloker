
<style>
    .about-wrapper{

        background:#11192d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:22px;

        overflow: visible;

    }


    .about-header{

        padding:12px 24px;

        display:flex;

        justify-content:space-between;

        align-items:center;

        border-bottom:1px solid rgba(255,255,255,.05);

    }


    .about-heading{

        color:#fff;

        font-size: 14px;

        font-weight:700;

        margin:0;

    }


    .about-subtitle{

        margin-top:4px;

        color:#90a0be;

        font-size:11px;

    }

    .about-body{

        padding:0;

    }


    .about-card{

        display:flex;

        gap:18px;

        padding: 12px 24px;

        border-bottom:1px solid rgba(255,255,255,.05);

        transition:.25s;

    }

    .about-empty{

        width:100%;

        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;

        text-align:center;

        padding:24px 16px;

    }

    .about-empty-title{

        color:#fff;

        font-size:14px;

        font-weight:700;

        margin-top:8px;

    }

    .about-empty-text{

        max-width:500px;

        margin-top:8px;

        color:#8fa0bc;

        font-size:12px;

        line-height:1.8;

    }


    /* ===============================
       LIGHT MODE
    =================================*/

    [data-bs-theme="light"] .about-wrapper{

        background:#ffffff;

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .about-header{

        border-bottom-color:#e2e8f0;

    }

    [data-bs-theme="light"] .about-heading{

        color:#1e293b;

    }

    [data-bs-theme="light"] .about-subtitle{

        color:#64748b;

    }

    [data-bs-theme="light"] .about-card{

        border-bottom-color:#e2e8f0;

    }

    [data-bs-theme="light"] .about-empty-title{

        color:#1e293b;

    }

    [data-bs-theme="light"] .about-empty-text{

        color:#64748b;

    }

</style>
<!-- =========================
     ABOUT
========================== -->

<div class="about-wrapper">

    <!-- Header -->
    <div class="about-header">

        <div>

            <h4 class="about-heading">
                Tentang
            </h4>

            <div class="about-subtitle">
                Deskripsi Singkat Profil
            </div>

        </div>

    </div>

    <!-- Body -->
    <div class="about-body">

        <div class="about-card">

            @if($security->self_description)

                {{ $security->self_description }}

            @else

                <div class="about-empty">

                    <i class="ki-duotone ki-information-2 fs-2 text-warning mb-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                    <div class="about-empty-title">
                        Belum Ada Deskripsi Profil
                    </div>

                    <div class="about-empty-text">
                        Tambahkan deskripsi singkat mengenai pengalaman,
                        kemampuan, serta keunggulan Anda agar perusahaan
                        lebih mudah mengenal profil Anda.
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>