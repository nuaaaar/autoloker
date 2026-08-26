<style>
    .certificate-card{

        background:#121c33;
        border:1px solid #2d3952;
        border-radius:22px;

    }

    .certificate-title{

        color:#fff;
        font-size: 18px;
        font-weight:700;

        margin-bottom: 18px;

    }

    .certificate-item{

        display:flex;
        align-items:center;

        gap: 6px;

        background:#1b2748;

        border:1px solid #304061;

        border-radius:18px;

        padding: 12px 16px;

        margin-bottom: 12px;

        transition:.25s;

    }

    .certificate-item:hover{

        border-color:#f6b00033;

        transform:translateY(-2px);

    }

    .certificate-icon{

        width: 44px;
        height: 44px;

        border-radius: 12px;

        border:1px solid rgba(246,176,0,.35);

        display:flex;
        align-items:center;
        justify-content:center;

    }

    .certificate-content{

        flex:1;

    }

    .certificate-name{

        color:#fff;

        font-size: 12px;

        font-weight:700;

    }

    .certificate-info{

        color:#8fa0be;

        margin-top:2px;

        font-size:10px;

    }

    .certificate-date{

        color:#93a4c0;

        margin-top:2px;

        font-size:10px;

    }

    .certificate-date span{

        color:#f6b000;

        font-weight:700;

        font-family:monospace;

    }

    .certificate-status{

        padding: 4px 8px;

        border-radius:30px;

        font-size: 10px;

        font-weight:700;

    }

    .certificate-status.active{

        color:#10e7a6;

        background:rgba(16,231,166,.12);

        border:1px solid rgba(16,231,166,.35);

    }

    @media(max-width:991px){

        .certificate-title {
            font-size: 14px;
        }

        .certificate-card{ 
            margin-bottom: 80px;
        }

    }
</style>

<div class="card certificate-card">

    <div class="card-body p-5">

        <h5 class="certificate-title">

            Sertifikasi

        </h5>

        <!-- item -->

        <div class="certificate-item">

            <div class="certificate-icon">

                <i class="ki-duotone ki-award text-warning fs-2"></i>

            </div>

            <div class="certificate-content">

                <div class="certificate-name">

                    Satpam Gada Pratama

                </div>

                <div class="certificate-info">

                    BNSP / Polri • No:
                    BNSP-GP-2022-04711

                </div>

                <div class="certificate-date">

                    Berlaku s/d

                    <span>

                        15 Mar 2025

                    </span>

                </div>

            </div>

            <div class="certificate-status active">

                Aktif

            </div>

        </div>

        <!-- item -->

        <div class="certificate-item">

            <div class="certificate-icon">

                <i class="ki-duotone ki-award text-warning fs-2"></i>

            </div>

            <div class="certificate-content">

                <div class="certificate-name">

                    K3 Umum Dasar

                </div>

                <div class="certificate-info">

                    Kemenaker RI • No:
                    K3-2023-08821

                </div>

                <div class="certificate-date">

                    Berlaku s/d

                    <span>

                        20 Apr 2026

                    </span>

                </div>

            </div>

            <div class="certificate-status active">

                Aktif

            </div>

        </div>

    </div>

</div>