
<div id="" class="leftSatpam position-relative overflow-hidden">

    <!-- Background Image -->
    <div class="satpam-background">
        <img
            src="https://images.unsplash.com/photo-1517913451214-e22ce660e086?w=1200&h=1400&fit=crop&auto=format"
            class="w-100 h-100 object-fit-cover"
            alt="Ilustrasi tenaga operasional profesional"
        >
    </div>

    <!-- Light Overlay -->
    <div class="satpam-overlay"></div>

    <!-- Decorative Gold Circle -->
    <div class="satpam-circle-top rounded-circle"></div>

    <!-- Decorative Bottom Circle -->
    <div class="satpam-circle-bottom rounded-circle"></div>

    <!-- Content -->
    <div class="satpam-content d-flex flex-column justify-content-end w-100">

        <!-- Logo -->
        <div class="mb-5">
            <div class="d-inline-flex align-items-center p-3 rounded-3 satpam-logo-wrapper">
                <img
                    src="{{ asset('/assets/media/logos/autoloker-logo.png') }}"
                    height="65"
                    alt="Autoloker"
                    style="max-width: 100%; object-fit: contain;"
                >
            </div>
        </div>

        <!-- Badge -->
        <div class="mb-5">
            <span class="d-inline-flex align-items-center gap-2 rounded-pill px-4 py-3 fw-semibold satpam-badge">
                <span class="satpam-badge-dot"></span>
                PLATFORM TENAGA OPERASIONAL INDONESIA
            </span>
        </div>

        <!-- Title -->
        <h1 class="fw-bolder lh-sm mb-4 satpam-title">
            <span class="d-block">Siap Melayani,</span>
            <span class="d-block satpam-title-highlight">Siap Bekerja.</span>
        </h1>

        <!-- Description -->
        <p class="mb-8 satpam-description">
            Selamat datang kembali, Rekan Profesional.
            Temukan peluang kerja terbaik sebagai tenaga keamanan
            dan cleaning service, serta kembangkan kariermu bersama kami.
        </p>

        <!-- Divider -->
        <hr class="mb-7 satpam-divider">

        <!-- Statistics -->
        <div class="row g-3">

            <!-- Statistic 1 -->
            <div class="col-4">
                <div class="h-100 p-3 p-xl-4 rounded-4 satpam-stat">
                    <h2 class="fw-bolder mb-2 satpam-stat-number">
                        10.800+
                    </h2>
                    <div class="satpam-stat-label">
                        Pelamar Aktif
                    </div>
                </div>
            </div>

            <!-- Statistic 2 -->
            <div class="col-4">
                <div class="h-100 p-3 p-xl-4 rounded-4 satpam-stat">
                    <h2 class="fw-bolder mb-2 satpam-stat-number">
                        384
                    </h2>
                    <div class="satpam-stat-label">
                        Lowongan Terbuka
                    </div>
                </div>
            </div>

            <!-- Statistic 3 -->
            <div class="col-4">
                <div class="h-100 p-3 p-xl-4 rounded-4 satpam-stat">
                    <h2 class="fw-bolder mb-2 satpam-stat-number">
                        47
                    </h2>
                    <div class="satpam-stat-label">
                        Perusahaan
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-7 satpam-footer">
            &copy; {{ date('Y') }} Autoloker. Platform Tenaga Operasional Indonesia.
        </div>

    </div>

</div>
