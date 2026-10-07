<style>
    /* =========================================================
       WIZARD
       ========================================================= */

    :root,
    [data-bs-theme="light"] {
        --autoloker-stepper-bg: #ffffff;
        --autoloker-stepper-border: #e2e8f0;

        --autoloker-step-border: #d7dee8;
        --autoloker-step-bg: transparent;
        --autoloker-step-text: #71809a;
        --autoloker-step-icon: #71809a;

        --autoloker-gold: #e8a801;
        --autoloker-gold-hover: #d99b00;
        --autoloker-gold-text: #111827;

        --autoloker-done-bg: rgba(232, 168, 1, .10);
        --autoloker-done-border: #e2c979;

        --autoloker-progress-bg: #e2e8f0;
        --autoloker-shadow: 0 4px 14px rgba(20, 34, 55, .05);
    }

    [data-bs-theme="dark"] {
        --autoloker-stepper-bg: #121a2d;
        --autoloker-stepper-border: #27344d;

        --autoloker-step-border: #2b3852;
        --autoloker-step-bg: transparent;
        --autoloker-step-text: #8291af;
        --autoloker-step-icon: #8291af;

        --autoloker-gold: #f6b000;
        --autoloker-gold-hover: #f7bd28;
        --autoloker-gold-text: #111111;

        --autoloker-done-bg: rgba(246, 176, 0, .15);
        --autoloker-done-border: #6e5520;

        --autoloker-progress-bg: #27344d;
        --autoloker-shadow: none;
    }


    /* =========================================================
       WIZARD PAGE
       ========================================================= */

    .wizard-page {
        display: none;
    }

    .wizard-page.active {
        display: block;
        animation: fadeStep .25s ease;
    }

    @keyframes fadeStep {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }


    /* =========================================================
       STEPPER
       ========================================================= */

    .autoloker-stepper {
        background: var(--autoloker-stepper-bg);
        border-bottom: 1px solid var(--autoloker-stepper-border);
        position: sticky;
        top: 0;
        z-index: 1;
        border-radius: 12px;
        box-shadow: var(--autoloker-shadow);
    }

    .autoloker-stepper .container-fluid {
        max-width: 1200px;
        padding: 12px 20px;
    }


    /* =========================================================
       STEP WRAPPER
       ========================================================= */

    .stepper-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
    }


    /* =========================================================
       STEP
       ========================================================= */

    .step-item {
        transition: .25s;
    }

    .step-pill {
        height: 32px;
        padding: 0 18px;
        border-radius: 50px;
        border: 1px solid var(--autoloker-step-border);
        background: var(--autoloker-step-bg);
        display: flex;
        align-items: center;
        color: var(--autoloker-step-text);
        font-size: 11px;
        font-weight: 600;
        transition: .25s;
    }

    .step-pill i {
        color: var(--autoloker-step-icon);
    }


    /* =========================================================
       ACTIVE
       ========================================================= */

    .step-item.active .step-pill {
        background: var(--autoloker-gold);
        color: var(--autoloker-gold-text);
        border-color: var(--autoloker-gold);
    }

    .step-item.active i {
        color: var(--autoloker-gold-text);
    }


    /* =========================================================
       DONE
       ========================================================= */

    .step-item.done .step-pill {
        background: var(--autoloker-done-bg);
        color: var(--autoloker-gold);
        border-color: var(--autoloker-done-border);
    }

    .step-item.done i {
        color: var(--autoloker-gold);
    }


    /* =========================================================
       PERCENT
       ========================================================= */

    .step-percent {
        color: var(--autoloker-gold);
        font-size: 12px;
        font-weight: 700;
    }


    /* =========================================================
       PROGRESS
       ========================================================= */

    .stepper-progress {
        width: 100%;
        height: 3px;
        background: var(--autoloker-progress-bg);
    }

    .stepper-progress-bar {
        height: 100%;
        width: 25%;
        background: var(--autoloker-gold);
        transition: .35s;
    }


    /* =========================================================
       MOBILE
       ========================================================= */

    @media (max-width: 768px) {

        .autoloker-stepper {
            border-radius: 0;
        }

        .autoloker-stepper .container-fluid {
            padding: 12px 15px;
        }

        .autoloker-stepper .d-flex {
            flex-wrap: nowrap !important;
            align-items: center;
            gap: 12px;
        }

        .stepper-wrapper {
            flex: 1;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            flex-wrap: nowrap;
            gap: 10px;
            padding-bottom: 2px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .stepper-wrapper::-webkit-scrollbar {
            display: none;
        }

        .step-item {
            flex-shrink: 0;
        }

        .step-pill {
            height: 34px;
            padding: 0 14px;
            font-size: 10px;
        }

        .step-pill i {
            font-size: 14px !important;
            margin-right: 6px !important;
        }

        .step-percent {
            flex-shrink: 0;
            font-size: 11px;
            min-width: 40px;
            text-align: right;
        }

        .stepper-progress {
            height: 2px;
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