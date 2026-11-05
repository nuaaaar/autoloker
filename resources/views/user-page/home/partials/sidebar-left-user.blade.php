<style>
    
    /* =========================================
    PROFILE ROLE
    ========================================= */

    .profile-role-wrapper {
        margin: 10px 0 12px;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
        line-height: 1;
        border: 1px solid transparent;
    }

    .profile-role i {
        font-size: 14px;
    }

    /* SATPAM */

    .profile-role.role-satpam {
        color: #2563a8;
        background: #edf5ff;
        border-color: #d6e8ff;
    }

    /* CLEANING SERVICE */

    .profile-role.role-cleaning {
        color: #287b68;
        background: #eaf7f3;
        border-color: #ccece2;
    }

    /* DARK MODE */

    [data-bs-theme="dark"] .profile-role.role-satpam,
    .dark-layout .profile-role.role-satpam,
    .dark-mode .profile-role.role-satpam {
        color: #8fc4ff;
        background: rgba(59, 130, 246, .13);
        border-color: rgba(59, 130, 246, .25);
    }

    [data-bs-theme="dark"] .profile-role.role-cleaning,
    .dark-layout .profile-role.role-cleaning,
    .dark-mode .profile-role.role-cleaning {
        color: #80d6bd;
        background: rgba(45, 160, 130, .13);
        border-color: rgba(45, 160, 130, .25);
    }

</style>

<!-- Profile Card -->

<div class="card profile-card mb-5">

    <div class="profile-cover"></div>

    
    <div class="card-body">

        <div class="text-start">

            {{-- PROFILE AVATAR --}}
            <div class="profile-avatar">

                <img
                    src="{{ $profile?->formal_photo
                        ? Storage::url($profile->formal_photo)
                        : asset('assets/media/avatars/300-3.jpg') }}"
                    alt="Profile"
                >

                <span class="online-badge">
                    <i class="ki-duotone ki-check-circle fs-7 text-white"></i>
                </span>

            </div>


            {{-- PROFILE NAME --}}
            <h5 class="profile-name">
                {{ $profile?->name ?? 'Nama Belum diisi' }}
            </h5>

            {{-- POSITION --}}
            <div class="profile-job">
                {{ $profile?->position ?? 'Jabatan Belum diisi' }}
            </div>


            {{-- COMPANY --}}
            <div class="profile-company">
                {{ $profile?->company_name ?? 'Perusahaan Belum diisi' }}
            </div>

            {{-- CERTIFICATE --}}
            @if($profile?->badgeCertificate)

                <span class="badge-gada">

                    <i class="ki-duotone ki-shield-tick fs-8 me-1 text-warning"></i>

                    {{ $profile->badgeCertificate->title }}

                </span>

            @endif

        </div>


        {{-- SEPARATOR --}}
        <div class="separator my-5"></div>


        {{-- PROFILE STATISTICS --}}
        <div class="profile-stat">

            {{-- <div>
                <span>Koneksi</span>
                <strong>0</strong>
            </div>

            <div>
                <span>Dilihat profil</span>
                <strong>0</strong>
            </div> --}}

             {{-- USER ROLE --}}
            @php
                $userRole = Auth::user()->role;

                $roleConfig = [
                    'satpam' => [
                        'label' => 'Satpam',
                        'icon' => 'ki-shield-tick',
                        'class' => 'role-satpam',
                    ],
                    'cs' => [
                        'label' => 'Cleaning Service',
                        'icon' => 'ki-brush',
                        'class' => 'role-cleaning',
                    ],
                ];

                $currentRole = $roleConfig[$userRole] ?? null;
            @endphp

            @if($currentRole)

                <div class="profile-role-wrapper">

                    <span class="profile-role {{ $currentRole['class'] }}">

                        <i class="ki-duotone {{ $currentRole['icon'] }}">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        {{ $currentRole['label'] }}

                    </span>

                </div>

            @endif

        </div>

    </div>


</div>

<!-- Quick Menu -->

<div class="card quick-menu">

    <div class="card-body">

        <div class="menu-title">

            MENU CEPAT

        </div>

        <a href="{{ route('user-page.subscription.index') }}" class="quick-item">

            <i class="ki-duotone ki-star fs-2"></i>

            <span>Paket Berlangganan</span>

        </a>

        <a href="{{ route('user-page.user-subscription.index') }}" class="quick-item">

            <i class="ki-duotone ki-cheque fs-2"></i>

            <span>Riwayat Pembayaran</span>

        </a>

        <a href="{{ route('user-page.job-vacancy.my') }}" class="quick-item">

            <i class="ki-duotone ki-briefcase fs-2"></i>

            <span>Hasil Lamaran Saya</span>

        </a>

        <a href="{{ route('user-page.job-vacancy.bookmark') }}" class="quick-item">

            <i class="ki-duotone ki-bookmark fs-2"></i>

            <span>Bookmark Lowongan</span>

        </a>


        {{-- <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-medal-star fs-2"></i>

            <span>Sertifikasi Saya</span>

        </a> --}}

        <a href="{{ route('user-page.training.my') }}" class="quick-item">

            <i class="ki-duotone ki-book-open fs-2"></i>

            <span>Pelatihan Saya</span>

        </a>

        {{-- <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-document fs-2"></i>

            <span>SOP & Incident Hub</span>

        </a>

        <a href="javascript:;" class="quick-item">

            <i class="ki-duotone ki-security-user fs-2"></i>

            <span>Halaman TPP Security</span>

        </a> --}}

    </div>

</div>