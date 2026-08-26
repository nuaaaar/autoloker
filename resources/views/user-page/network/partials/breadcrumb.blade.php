<style>
    .network-breadcrumb{
        display:flex;
        align-items:center;
        gap:2px;
        font-size: 11px;
        font-weight:500;
        margin-bottom:28px;
    }

    .network-breadcrumb a{
        display:flex;
        align-items:center;
        gap:6px;
        color:#7d8aa5;
        text-decoration:none;
        transition:.25s;
    }

    .network-breadcrumb a:hover{
        color:#e8a401;
    }

    .network-breadcrumb a i{
        font-size: 11px;
    }

    .network-breadcrumb .active{
        color:#f4f6fb;
        font-weight:600;
    }

    .network-breadcrumb .text-muted{
        color:#5b6985 !important;
    }
</style>

<!-- Breadcrumb -->
<div class="network-breadcrumb mb-4">

    <a href="javascript:;">
        <i class="ki-duotone ki-home-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <span>Beranda</span>
    </a>

    <span class="mx-2 text-muted">›</span>

    <span class="active">
        Jejaring Saya
    </span>

</div>