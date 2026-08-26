<!-- Profile Card -->
<div class="card profile-card mb-5">

    <div class="profile-cover"></div>

    <div class="card-body">

        <div class="text-start">

            <div class="profile-avatar">

                <img src="{{ $security->formal_photo ? Storage::url($security->formal_photo) : asset('assets/media/avatars/300-3.jpg') }}" alt="">

                <span class="online-badge">
                    <i class="ki-duotone ki-check-circle fs-7 text-white"></i>
                </span>

            </div>

            <h5 class="profile-name">
                {{ $security->name ?? 'Nama Belum diisi' }}
            </h5>

            <div class="profile-job">
                {{ $security->position }}
            </div>

            <div class="profile-company">
                {{ $security->company_name }}
            </div>

            @if($security->badgeCertificate)
                <span class="badge-gada">
                    <i class="ki-duotone ki-shield-tick fs-8 me-1 text-warning"></i>
                    {{ $security->badgeCertificate->title }}
                </span>
            @endif

        </div>

        <div class="separator my-5"></div>

        <div class="profile-stat">

            <div>
                <span>Koneksi</span>
                <strong>0</strong>
            </div>

            <div>
                <span>Dilihat profil</span>
                <strong>0</strong>
            </div>

        </div>

    </div>

</div>

<!-- Quick Menu -->

<div class="card quick-menu">

    <div class="card-body">

        <div class="menu-title">

            MENU CEPAT

        </div>

        <a href="{{ route('user-page.job-vacancy.my') }}" class="quick-item">

            <i class="ki-duotone ki-briefcase fs-2"></i>

            <span>Hasil Lamaran Saya</span>

        </a>

        <a href="{{ route('user-page.job-vacancy.bookmark') }}" class="quick-item">

            <i class="ki-duotone ki-bookmark fs-2"></i>

            <span>Bookmark Lowongan</span>

        </a>


        <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-medal-star fs-2"></i>

            <span>Sertifikasi Saya</span>

        </a>

        <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-book-open fs-2"></i>

            <span>Pelatihan</span>

        </a>

        <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-document fs-2"></i>

            <span>SOP & Incident Hub</span>

        </a>

        <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-security-user fs-2"></i>

            <span>Halaman TPP Security</span>

        </a>

    </div>

</div>