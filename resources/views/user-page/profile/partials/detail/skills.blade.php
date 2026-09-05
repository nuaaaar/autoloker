<style>
    /* ===========================
       PROFILE SKILLS
    =========================== */

    .skills-wrapper{

        display:flex;
        flex-wrap:wrap;
        gap: 10px;

    }

    .skill-badge{

        display:inline-flex;
        align-items:center;
        justify-content:center;

        padding: 6px 12px;

        border-radius:999px;

        background:#1d2948;

        border:1px solid #304061;

        color:#91a0bc;

        font-size: 10px;

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


    /* ===========================
       LIGHT MODE
    =========================== */

    [data-bs-theme="light"] .skill-badge{

        background:#f8fafc;

        border-color:#e2e8f0;

        color:#64748b;

    }

    [data-bs-theme="light"] .skill-badge:hover{

        background:#fffbf2;

        border-color:rgba(246,176,0,.35);

        color:#d18f00;

    }

    [data-bs-theme="light"] .profile-section-title{

        color:#1e293b;

    }

</style>

<div class="card profile-section-card">
    @php
        $abilities = $security->ability
            ? explode(',', $security->ability)
            : [];

    @endphp
    <div class="card-body p-4">

        <h5 class="profile-section-title mb-4">
            Keahlian
        </h5>

        <div class="skills-wrapper">
            @foreach($abilities as $ability)
                <span class="skill-badge">
                    {{ $ability }}
                </span>
            @endforeach
        </div>

    </div>

</div>