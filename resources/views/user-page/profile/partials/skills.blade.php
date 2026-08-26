<style>
    /* ===========================
       PROFILE SKILLS
    =========================== */

    .skills-wrapper{

        background:#11192d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:22px;

        overflow:visible;

    }

    .skills-header{

        padding:12px 24px;

        display:flex;

        justify-content:space-between;

        align-items:center;

        border-bottom:1px solid rgba(255,255,255,.05);

    }

    .skills-heading{

        color:#fff;

        font-size:14px;

        font-weight:700;

        margin:0;

    }

    .skills-subtitle{

        margin-top:4px;

        color:#90a0be;

        font-size:11px;

    }

    .skills-body{

        padding:12px 24px;

    }

    .skills-list{

        display:flex;

        flex-wrap:wrap;

        gap:10px;

    }

    .skill-badge{

        display:inline-flex;

        align-items:center;

        justify-content:center;

        padding:6px 12px;

        border-radius:999px;

        background:#1d2948;

        border:1px solid #304061;

        color:#91a0bc;

        font-size:10px;

        font-weight:600;

        transition:.25s;

        cursor:default;

    }

    .skill-badge:hover{

        background:#26365d;

        border-color:#f6b00055;

        color:#f6b000;

        transform:translateY(-2px);

    }

    .skills-empty{

        width:100%;

        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;

        text-align:center;

        padding:30px 20px;

    }

    .skills-empty-icon{

        width:32px;
        height:32px;

        display:flex;
        align-items:center;
        justify-content:center;

        border-radius:50%;

        background:rgba(246,176,0,.08);

        border:1px solid rgba(246,176,0,.18);

        margin-bottom:18px;

    }

    .skills-empty-title{

        color:#fff;

        font-size:15px;

        font-weight:700;

    }

    .skills-empty-text{

        max-width:520px;

        margin-top:10px;

        color:#8fa0bc;

        font-size:12px;

        line-height:1.8;

    }

    .skills-empty-list{

        margin-top:22px;

        display:flex;
        flex-wrap:wrap;
        justify-content:center;

        gap:10px;

    }

    .skills-empty-list span{

        padding:6px 12px;

        border-radius:999px;

        background:#1d2948;

        border:1px solid #304061;

        color:#91a0bc;

        font-size:11px;

    }
</style>

@php
    $abilities = $security->ability
        ? explode(',', $security->ability)
        : [];
@endphp

<div class="skills-wrapper">

    <!-- Header -->

    <div class="skills-header">

        <div>

            <h4 class="skills-heading">
                Keahlian
            </h4>

            <div class="skills-subtitle">
                Kemampuan dan kompetensi yang dimiliki
            </div>

        </div>

    </div>

    <!-- Body -->

    <div class="skills-body">

        <div class="skills-list">

            <div class="skills-wrapper">

                @forelse($abilities as $ability)

                    <span class="skill-badge">
                        {{ trim($ability) }}
                    </span>

                @empty

                    <div class="skills-empty">

                        <div class="skills-empty-icon">

                            <i class="ki-duotone ki-medal-star fs-6 text-warning">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                        </div>

                        <div class="skills-empty-title">

                            Belum Ada Keahlian

                        </div>

                        <div class="skills-empty-text">

                            Tambahkan keahlian yang Anda kuasai, seperti pengamanan,
                            pelayanan, komunikasi, penggunaan alat keamanan, maupun
                            kemampuan lainnya agar profil Anda lebih menarik bagi perusahaan.

                        </div>

                        <div class="skills-empty-list">

                            <span>✔ Pengamanan Area</span>

                            <span>✔ CCTV Monitoring</span>

                            <span>✔ Penanganan Keadaan Darurat</span>

                            <span>✔ Pelayanan Pengunjung</span>

                            <span>✔ Patroli</span>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>