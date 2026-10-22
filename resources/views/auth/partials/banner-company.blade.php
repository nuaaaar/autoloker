
<div id="" class="leftPerusahaan position-relative overflow-hidden"
     style="display: none; background: #ffffff; min-height: 100vh;">

    <!-- Background Image -->
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <img
            src="https://images.unsplash.com/photo-1690357737706-b421b193048a?w=900&h=1100&fit=crop&auto=format"
            class="w-100 h-100 object-fit-cover"
            alt="Ilustrasi layanan operasional profesional"
            style="opacity: 0.16;"
        >
    </div>

    <!-- Light Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100"
         style="
            background: linear-gradient(
                180deg,
                rgba(255,255,255,0.78) 0%,
                rgba(255,255,255,0.91) 50%,
                rgba(255,255,255,0.98) 100%
            );
         ">
    </div>

    <!-- Decorative Accent -->
    <div class="position-absolute"
         style="
            width: 280px;
            height: 280px;
            top: -100px;
            right: -80px;
            border-radius: 50%;
            background: rgba(245,179,1,0.10);
            filter: blur(2px);
         ">
    </div>

    <!-- Content -->
    <div class="position-relative d-flex flex-column justify-content-end
                h-100 w-100 p-5 p-xl-10"
         style="min-height: 100vh; color: #263247;">

        <!-- Logo -->
        <div class="mb-5">
            <img
                src="{{ asset('/assets/media/logos/autoloker-logo.png') }}"
                alt="Autoloker"
                height="80"
                style="
                    background: #ffffff;
                    border: 1px solid #edf0f5;
                    border-radius: 12px;
                    padding: 8px 12px;
                    object-fit: contain;
                    box-shadow: 0 4px 16px rgba(31,45,61,0.06);
                "
            >
        </div>

        <!-- Badge -->
        <div class="mb-5">
            <span
                class="d-inline-flex align-items-center rounded-pill px-4 py-3 fw-semibold"
                style="
                    background: #fff8df;
                    border: 1px solid #f0d47a;
                    color: #936800;
                    font-size: 13px;
                    gap: 8px;
                "
            >
                <span
                    style="
                        width: 8px;
                        height: 8px;
                        display: inline-block;
                        border-radius: 50%;
                        background: #e8a400;
                    "
                ></span>

                Solusi Tenaga Operasional Profesional
            </span>
        </div>

        <!-- Title -->
        <h1 class="fw-bold mb-4"
            style="
                font-size: clamp(32px, 3.2vw, 48px);
                line-height: 1.2;
                letter-spacing: -1px;
                color: #263247;
            ">

            <span class="d-block">
                Temukan
            </span>

            <span class="d-block"
                  style="color: #d99a00;">
                Talenta Terbaik
            </span>

            <span class="d-block">
                untuk Bisnis Anda.
            </span>

        </h1>

        <!-- Description -->
        <p class="mb-5"
           style="
                font-size: 17px;
                line-height: 1.9;
                color: #64748b;
                max-width: 560px;
           ">
            Temukan tenaga profesional yang tepat untuk mendukung
            operasional bisnis Anda, mulai dari keamanan hingga
            kebersihan dan pelayanan fasilitas.
        </p>

        <!-- Divider -->
        <hr style="
            border-color: #dce2ec;
            opacity: 1;
            margin-bottom: 32px;
        ">

        <!-- Statistics -->
        <div class="row g-3">

            <div class="col-4">
                <div class="h-100 p-3 rounded-3"
                     style="
                        background: rgba(255,255,255,0.85);
                        border: 1px solid #e8edf4;
                        box-shadow: 0 4px 16px rgba(31,45,61,0.04);
                     ">

                    <h2 class="fw-bold mb-2"
                        style="
                            color: #d99a00;
                            font-size: clamp(20px, 2vw, 30px);
                        ">
                        1.247
                    </h2>

                    <div style="
                        color: #64748b;
                        font-size: 12px;
                        line-height: 1.6;
                    ">
                        Penempatan/Bulan
                    </div>

                </div>
            </div>

            <div class="col-4">
                <div class="h-100 p-3 rounded-3"
                     style="
                        background: rgba(255,255,255,0.85);
                        border: 1px solid #e8edf4;
                        box-shadow: 0 4px 16px rgba(31,45,61,0.04);
                     ">

                    <h2 class="fw-bold mb-2"
                        style="
                            color: #d99a00;
                            font-size: clamp(20px, 2vw, 30px);
                        ">
                        7.840
                    </h2>

                    <div style="
                        color: #64748b;
                        font-size: 12px;
                        line-height: 1.6;
                    ">
                        Tenaga Terverifikasi
                    </div>

                </div>
            </div>

            <div class="col-4">
                <div class="h-100 p-3 rounded-3"
                     style="
                        background: rgba(255,255,255,0.85);
                        border: 1px solid #e8edf4;
                        box-shadow: 0 4px 16px rgba(31,45,61,0.04);
                     ">

                    <h2 class="fw-bold mb-2"
                        style="
                            color: #d99a00;
                            font-size: clamp(20px, 2vw, 30px);
                        ">
                        91%
                    </h2>

                    <div style="
                        color: #64748b;
                        font-size: 12px;
                        line-height: 1.6;
                    ">
                        Tingkat Kepuasan
                    </div>

                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-5 pt-3"
             style="
                border-top: 1px solid #e5eaf2;
                color: #94a3b8;
                font-size: 12px;
            ">
            © {{ date('Y') }} Autoloker. Solusi tenaga kerja profesional.
        </div>

    </div>

</div>
