<style>
    .notification-title{
        color:#fff;
        font-size:16px;
        font-weight:700;
    }

    .read-all{
        color:#e8a401;
        text-decoration:none;
        font-size:12px;
        font-weight:600;
    }

    .read-all:hover{
        color:#ffcb3f;
    }

    .notification-card{

        background:#11192d;
        border:1px solid #28334c;
        border-radius:18px;
        overflow:hidden;

    }

    .notification-item{

        display:block;
        padding:12px 16px;
        color:#fff;
        text-decoration:none;
        border-bottom:1px solid #29344c;
        transition:.25s;

    }

    .notification-item:last-child{
        border-bottom:none;
    }

    .notification-item:hover{

        background:#17233f;

    }

    .notification-avatar{

        width:32px;
        height:32px;
        border-radius:50%;
        object-fit:cover;

    }

    .notification-icon{

        width:32px;
        height:32px;
        border-radius:50%;

        display:flex;
        align-items:center;
        justify-content:center;

        background:#1b2950;
        color:#8aa5ff;

        flex-shrink:0;

    }

    .notification-icon.warning{

        color:#f3b012;

    }

    .notification-icon.danger{

        color:#ff5d73;

    }

    .notification-icon.purple{

        color:#a875ff;

    }

    .notification-text{

        color:#dfe5ef;
        font-size:12px;
        font-weight:500;
        line-height:1.45;

    }

    .notification-time{

        margin-top:1px;

        font-size:10px;

        color:#8b97b4;

        font-family:monospace;

    }

    .dot-unread{

        width:10px;
        height:10px;
        background:#e8a401;
        border-radius:50%;
        flex-shrink:0;

    }

    .unread{

        background:#171d2b;

    }


    /*==================================
    LIGHT MODE
    ==================================*/

    [data-bs-theme="light"] .notification-title{
        color:#1e293b;
    }

    [data-bs-theme="light"] .read-all{
        color:#d18f00;
    }

    [data-bs-theme="light"] .read-all:hover{
        color:#b77900;
    }

    [data-bs-theme="light"] .notification-card{

        background:#ffffff;
        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .notification-item{

        color:#334155;
        border-bottom-color:#e2e8f0;

    }

    [data-bs-theme="light"] .notification-item:hover{

        background:#f8fafc;

    }

    [data-bs-theme="light"] .notification-icon{

        background:#eef2ff;
        color:#5274d9;

    }

    [data-bs-theme="light"] .notification-icon.warning{

        color:#d18f00;

    }

    [data-bs-theme="light"] .notification-icon.danger{

        color:#e0445d;

    }

    [data-bs-theme="light"] .notification-icon.purple{

        color:#8b5bd6;

    }

    [data-bs-theme="light"] .notification-text{

        color:#475569;

    }

    [data-bs-theme="light"] .notification-time{

        color:#94a3b8;

    }

    [data-bs-theme="light"] .unread{

        background:#fffaf0;

    }


    /*==================================
    RESPONSIVE
    ==================================*/

    @media(max-width:991px){

        .notification-title{

            font-size:12px;

        }

        .notification-item{

            padding:18px;

        }

        .notification-text{

            font-size:10px;

        }

        .notification-time{

            font-size:10px;

        }

        .notification-avatar,
        .notification-icon{

            width:32px;
            height:32px;

        }

    }
</style>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="notification-title">
        Notifikasi
    </h4>

    <a href="#" class="read-all">
        Tandai semua dibaca
    </a>

</div>


<!-- Notification Card -->
<div class="card notification-card">

    <div class="list-group list-group-flush">

        <!-- ITEM -->
        <a href="#" class="notification-item unread">

            <div class="d-flex align-items-center">

                <img src="/assets/media/avatars/300-3.jpg"
                    class="notification-avatar">

                <div class="ms-4 flex-grow-1">

                    <div class="notification-text">
                        <strong>Agus Priyatno</strong>
                        ingin terhubung dengan Anda
                    </div>

                    <div class="notification-time">
                        5 menit lalu
                    </div>

                </div>

                <span class="dot-unread"></span>

            </div>

        </a>


        <!-- ITEM -->
        <a href="#" class="notification-item unread">

            <div class="d-flex align-items-center">

                <div class="notification-icon danger">

                    <i class="ki-duotone ki-information-5 fs-3"></i>

                </div>

                <div class="ms-4 flex-grow-1">

                    <div class="notification-text">

                        Sertifikat Gada Pratama Anda akan berakhir
                        dalam 30 hari. Segera perpanjang.

                    </div>

                    <div class="notification-time">
                        2 jam lalu
                    </div>

                </div>

                <span class="dot-unread"></span>

            </div>

        </a>


        <!-- ITEM -->
        <a href="#" class="notification-item unread">

            <div class="d-flex align-items-center">

                <div class="notification-icon warning">

                    <i class="ki-duotone ki-gift fs-3"></i>

                </div>

                <div class="ms-4 flex-grow-1">

                    <div class="notification-text">

                        PT BCA membuka lowongan Satpam cocok
                        dengan profil Anda

                    </div>

                    <div class="notification-time">
                        5 jam lalu
                    </div>

                </div>

                <span class="dot-unread"></span>

            </div>

        </a>


        <!-- ITEM -->
        <a href="#" class="notification-item">

            <div class="d-flex align-items-center">

                <img src="/assets/media/avatars/300-5.jpg"
                    class="notification-avatar">

                <div class="ms-4 flex-grow-1">

                    <div class="notification-text">

                        Irwan Prasetyo dan 14 orang lainnya
                        menyukai komentar Anda

                    </div>

                    <div class="notification-time">
                        1 hari lalu
                    </div>

                </div>

            </div>

        </a>


        <!-- ITEM -->
        <a href="#" class="notification-item">

            <div class="d-flex align-items-center">

                <div class="notification-icon purple">

                    <i class="ki-duotone ki-book-open fs-3"></i>

                </div>

                <div class="ms-4 flex-grow-1">

                    <div class="notification-text">

                        Pelatihan K3 Dasar - LSP Sekuriti
                        dimulai 3 hari lagi. Anda terdaftar.

                    </div>

                    <div class="notification-time">
                        1 hari lalu
                    </div>

                </div>

            </div>

        </a>


        <!-- ITEM -->
        <a href="#" class="notification-item">

            <div class="d-flex align-items-center">

                <img src="/assets/media/avatars/300-2.jpg"
                    class="notification-avatar">

                <div class="ms-4 flex-grow-1">

                    <div class="notification-text">

                        Drs. Soetrisno menerima permintaan
                        koneksi Anda

                    </div>

                    <div class="notification-time">
                        2 hari lalu
                    </div>

                </div>

            </div>

        </a>

    </div>

</div>
