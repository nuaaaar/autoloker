<style>

    .subscription-breadcrumb{
        display:flex;
        align-items:center;
        gap:2px;

        font-size:11px;
        font-weight:500;

        margin-bottom:28px;
    }

    .subscription-breadcrumb a{
        display:flex;
        align-items:center;
        gap:6px;

        color:#7d8aa5;

        text-decoration:none;

        transition:.25s;
    }

    .subscription-breadcrumb a:hover{
        color:#e8a401;
    }

    .subscription-breadcrumb a i{
        font-size:11px;
    }

    .subscription-breadcrumb .active{
        color:#f4f6fb;
        font-weight:600;
    }

    .subscription-breadcrumb .text-muted{
        color:#5b6985 !important;
    }


    /*==================================
    LIGHT MODE
    ==================================*/

    [data-bs-theme="light"] .subscription-breadcrumb a{
        color:#64748b;
    }

    [data-bs-theme="light"] .subscription-breadcrumb a:hover{
        color:#d18f00;
    }

    [data-bs-theme="light"] .subscription-breadcrumb .active{
        color:#1e293b;
    }

    [data-bs-theme="light"] .subscription-breadcrumb .text-muted{
        color:#94a3b8 !important;
    }

</style>


<div class="subscription-breadcrumb mb-4">

    <a href="javascript:;">

        <i class="ki-duotone ki-home-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>

        <span>Beranda</span>

    </a>


    <span class="mx-2 text-muted">
        ›
    </span>


    <span class="active">
        Paket Berlangganan
    </span>

</div>