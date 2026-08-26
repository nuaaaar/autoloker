<style>
    .assignment-timeline{

        position:relative;

    }

    .assignment-item{

        position:relative;

        display:flex;

        gap: 16px;

        padding-bottom: 38px;

    }

    .assignment-item:last-child{

        padding-bottom:0;

    }

    .assignment-item:not(:last-child)::before{

        content:"";

        position:absolute;

        left: 15px;

        top: 30px;

        width:2px;

        height:calc(100% - 30px);

        background:#2b3651;

    }

    .assignment-icon{

        width: 30px;
        height: 30px;

        min-width: 30px;

        border-radius: 50%;

        border: 2px solid rgba(246,176,0,.35);

        background:#20293d;

        display:flex;
        align-items:center;
        justify-content:center;

    }

    .assignment-content{

        flex:1;

    }

    .assignment-position{

        color:#ffffff;

        font-size: 12px;

        font-weight: 700;

        margin-bottom: 2px;

    }

    .assignment-company{

        color:#f6b000;

        font-size: 10px;

        font-weight:600;

        margin-bottom: 0px;

    }

    .assignment-meta{

        color:#8f9db8;

        font-size: 9.5px;

        margin-bottom: 2px;

        font-family:monospace;

    }

    .assignment-description{

        color:#98a5bf;

        font-size: 9.5px;

        /* line-height:1.8; */

    }

    .profile-section-title{

        color:#fff;
        font-size: 18px;
        font-weight:700;

        margin-bottom: 18px;

    }

    @media(max-width:991px){

        .profile-section-title {
            font-size: 14px;
        }

        .profile-section-card{ 
            margin-bottom: 80px;
        }

    }
</style>

<div class="card profile-section-card">

    <div class="card-body p-4">

        <h5 class="profile-section-title">
            Riwayat Penugasan
        </h5>

        <div class="assignment-timeline">

            <!-- Item -->
            <div class="assignment-item">

                <div class="assignment-icon">

                    <i class="ki-duotone ki-shield-tick fs-2 text-warning">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                </div>

                <div class="assignment-content">

                    <h5 class="assignment-position">
                        Satpam Gada Pratama
                    </h5>

                    <div class="assignment-company">
                        PT Tekno Putra Perkasa
                    </div>

                    <div class="assignment-meta">
                        Jan 2022 &nbsp;&ndash;&nbsp; Sekarang
                        <span class="mx-2">•</span>
                        Jakarta Selatan
                    </div>

                    <div class="assignment-description">

                        Penugasan di Gedung Sudirman Tower,
                        shift malam. Bertanggung jawab atas
                        keamanan 3 lantai dan area parkir basement.

                    </div>

                </div>

            </div>

            <!-- Item -->
            <div class="assignment-item">

                <div class="assignment-icon">

                    <i class="ki-duotone ki-shield-tick fs-2 text-warning">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                </div>

                <div class="assignment-content">

                    <h5 class="assignment-position">
                        Security Officer
                    </h5>

                    <div class="assignment-company">
                        PT Securitas Indonesia
                    </div>

                    <div class="assignment-meta">
                        Mar 2019 &nbsp;&ndash;&nbsp; Des 2021
                        <span class="mx-2">•</span>
                        Tangerang
                    </div>

                    <div class="assignment-description">

                        Penugasan di kawasan industri Bitung.
                        Bertanggung jawab melakukan pemeriksaan
                        akses kendaraan, tamu, dan barang masuk
                        maupun keluar area perusahaan.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>