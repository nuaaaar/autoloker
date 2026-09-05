<style>
    /*==================================
    HEADER
    ==================================*/

    .network-card-header{

        display:flex;

        justify-content:space-between;

        align-items:flex-start;

        margin-bottom:25px;

    }

    .network-card-header h5{

        color:#F5F7FC;

        font-size:14px;

        font-weight:700;

        margin-bottom:4px;

    }

    .network-card-header p{

        color:#8D98B3;

        font-size:10px;

        margin:0;

    }

    .network-card-header a{

        color:#E8A401;

        font-size:11px;

        text-decoration:none;

        font-weight:600;

    }


    /*==================================
    MEMBER
    ==================================*/

    .site-member{

        display:flex;

        align-items:center;

        gap:16px;

        padding:8px 0;

    }

    .site-avatar{

        width:36px;

        height:36px;

        border-radius:50%;

        object-fit:cover;

    }

    .site-member h6{

        color:#fff;

        font-size:11px;

        font-weight:700;

        margin-bottom:2px;

    }

    .site-desc{

        display:block;

        color:#B2BDD5;

        font-size:9px;

    }

    .site-mutual{

        margin-left:10px;

        color:#8794B0;

        font-size:9px;

    }


    /*==================================
    BUTTON
    ==================================*/

    .btn-connect-mini{

        width:95px;

        height:25px;

        border-radius:30px;

        background:transparent;

        border:1.5px solid #E8A401;

        color:#E8A401;

        font-size:10px;

        font-weight:700;

        transition:.25s;

    }

    .btn-connect-mini:hover{

        background:#E8A401;

        color:#111827;

    }


    /*==================================
    DIVIDER
    ==================================*/

    .site-divider{

        height:1px;

        background:#26344B;

        /* margin:18px 0; */

    }


    /*==================================
    LIGHT MODE
    ==================================*/

    [data-bs-theme="light"] .network-card-header h5{

        color:#1e293b;

    }

    [data-bs-theme="light"] .network-card-header p{

        color:#64748b;

    }

    [data-bs-theme="light"] .network-card-header a{

        color:#d18f00;

    }

    [data-bs-theme="light"] .site-member h6{

        color:#1e293b;

    }

    [data-bs-theme="light"] .site-desc{

        color:#64748b;

    }

    [data-bs-theme="light"] .site-mutual{

        color:#94a3b8;

    }

    [data-bs-theme="light"] .btn-connect-mini{

        border-color:#E8A401;

        color:#d18f00;

    }

    [data-bs-theme="light"] .btn-connect-mini:hover{

        background:#E8A401;

        color:#111827;

    }

    [data-bs-theme="light"] .site-divider{

        background:#e2e8f0;

    }


    /*==================================
    RESPONSIVE
    ==================================*/

    @media(max-width:991px){

        .network-card-header{

            flex-direction:column;

            gap:8px;

        }

        .site-member{

            align-items:flex-start;

        }

        .site-avatar{

            width:48px;

            height:48px;

        }

        .site-member h6{

            font-size:14px;

        }

        .site-job{

            font-size:12px;

        }

        .site-company{

            font-size:11px;

        }

        .site-mutual{

            font-size:11px;

        }

        .btn-connect-mini{

            width:95px;

            height:34px;

            font-size:12px;

        }

        .network-section-card-recommend{

            margin-bottom:80px !important;

        }

    }
</style>

<div class="network-section-card network-section-card-recommend mt-4">

    <div class="network-card-header">

        <div>

            <h5>Anggota dari Site yang Sama</h5>

            <p>Perluas jaringan dengan rekan kerja di lokasi yang sama.</p>

        </div>

        <a href="javascript:;">
            Lihat Semua
        </a>

    </div>

    <!-- Member -->

    <div class="site-member">

        <img src="/assets/media/avatars/300-1.jpg"
             class="site-avatar">

        <div class="flex-grow-1">

            <h6>Budi Santoso</h6>

            <span class="site-desc">
                Satpam Gada Pratama - TPK Kariangau
            </span>

        </div>

        <button class="btn-connect-mini">

            Hubungkan

        </button>

    </div>

    <div class="site-divider"></div>

    <div class="site-member">

        <img src="/assets/media/avatars/300-1.jpg"
             class="site-avatar">

        <div class="flex-grow-1">

            <h6>Budi Santoso</h6>

            <span class="site-desc">
                Satpam Gada Pratama - TPK Kariangau
            </span>

        </div>

        <button class="btn-connect-mini">

            Hubungkan

        </button>

    </div>

    <div class="site-divider"></div>

    <div class="site-member">

        <img src="/assets/media/avatars/300-1.jpg"
             class="site-avatar">

        <div class="flex-grow-1">

            <h6>Budi Santoso</h6>

            <span class="site-desc">
                Satpam Gada Pratama - TPK Kariangau
            </span>

        </div>

        <button class="btn-connect-mini">

            Hubungkan

        </button>

    </div>

    <div class="site-divider"></div>

</div>