<style>
    .wizard-page{
        display:none;
    }

    .wizard-page.active{
        display:block;
        animation:fadeStep .25s ease;
    }

    @keyframes fadeStep{

        from{

            opacity:0;
            transform:translateX(20px);

        }

        to{

            opacity:1;
            transform:none;

        }

    }
    
    .autoloker-stepper{

        background:#121a2d;

        border-bottom:1px solid #27344d;

        position:sticky;

        top:0;

        z-index: 1;

        border-radius: 12px;

    }

    .autoloker-stepper .container-fluid{

        max-width: 1200px;

        padding: 12px 20px;

    }

    /* Step Wrapper */

    .stepper-wrapper{

        display:flex;

        align-items:center;

        gap:14px;

    }

    /* Step */

    .step-item{

        transition:.25s;

    }

    .step-pill{

        height: 32px;

        padding:0 18px;

        border-radius:50px;

        border:1px solid #2b3852;

        background:transparent;

        display:flex;

        align-items:center;

        color:#8291af;

        font-size: 11px;

        font-weight:600;

        transition:.25s;

    }

    .step-pill i{

        color:#8291af;

    }

    /* ACTIVE */

    .step-item.active .step-pill{

        background:#f6b000;

        color:#111;

        border-color:#f6b000;

    }

    .step-item.active i{

        color:#111;

    }

    /* DONE */

    .step-item.done .step-pill{

        background:rgba(246,176,0,.15);

        color:#f6b000;

        border-color:#6e5520;

    }

    .step-item.done i{

        color:#f6b000;

    }

    /* Percent */

    .step-percent{

        color:#f6b000;

        font-size: 12px;

        font-weight:700;

    }

    /* Progress */

    .stepper-progress{

        width:100%;

        height:3px;

        background:#27344d;

    }

    .stepper-progress-bar{

        height:100%;

        width:25%;

        background:#f6b000;

        transition:.35s;

    }

    @media (max-width: 768px){

        .autoloker-stepper{

            border-radius:0;

        }

        .autoloker-stepper .container-fluid{

            padding:12px 15px;

        }

        .autoloker-stepper .d-flex{

            flex-wrap:nowrap !important;

            align-items:center;

            gap:12px;

        }

        .stepper-wrapper{

            flex:1;

            overflow-x:auto;

            overflow-y:hidden;

            white-space:nowrap;

            flex-wrap:nowrap;

            gap:10px;

            padding-bottom:2px;

            -ms-overflow-style:none;

            scrollbar-width:none;

        }

        .stepper-wrapper::-webkit-scrollbar{

            display:none;

        }

        .step-item{

            flex-shrink:0;

        }

        .step-pill{

            height:34px;

            padding:0 14px;

            font-size:10px;

        }

        .step-pill i{

            font-size:14px !important;

            margin-right:6px !important;

        }

        .step-percent{

            flex-shrink:0;

            font-size:11px;

            min-width:40px;

            text-align:right;

        }

        .stepper-progress{

            height:2px;

        }

    }
</style>

<div class="autoloker-stepper">

    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between flex-wrap">

            <!-- Step -->
            <div class="stepper-wrapper">

                <div class="step-item active" data-step="1">

                    <div class="step-pill">

                        <i class="ki-duotone ki-home fs-6 me-2"></i>

                        Profil Perusahaan

                    </div>

                </div>

                <div class="step-item" data-step="2">

                    <div class="step-pill">

                        <i class="ki-duotone ki-geolocation fs-6 me-2"></i>

                        Kontak & Alamat

                    </div>

                </div>

                <div class="step-item" data-step="3">

                    <div class="step-pill">

                        <i class="ki-duotone ki-files fs-6 me-2"></i>

                        Legalitas

                    </div>

                </div>

                <div class="step-item" data-step="4">

                    <div class="step-pill">

                        <i class="ki-duotone ki-pad fs-6 me-2"></i>

                        Media Sosial

                    </div>

                </div>

            </div>

            <!-- Progress -->
            <div class="step-percent">

                25%

            </div>

        </div>

    </div>

    <!-- Progress Line -->

    <div class="stepper-progress">

        <div class="stepper-progress-bar" style="width:25%;"></div>

    </div>

</div>