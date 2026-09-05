<style>
    /* ===============================
    REKOMENDASI
    =================================*/

    .recommend-card{

        background:#1d2848;

        border:1px solid #304060;

        border-radius:18px;

        padding: 12px;

        transition:.25s;

    }

    .recommend-card:hover{

        border-color:#f6b000;

        transform:translateY(-2px);

    }

    .recommend-avatar{

        width: 32px;

        height: 32px;

        border-radius:50%;

        object-fit:cover;

        border:2px solid #2f3c58;

        flex-shrink:0;

    }

    .recommend-name{

        color:#ecf1ff;

        font-size: 12px;

        font-weight:700;

        /* line-height:1.3; */

    }

    .recommend-position{

        color:#8796b5;

        font-size: 10px;

        margin-top:3px;

    }

    .recommend-text{

        color:#95a2bf;

        font-size: 10px;

        /* line-height:1.9; */

        font-style:italic;

    }


    /* ===============================
    LIGHT MODE
    =================================*/

    [data-bs-theme="light"] .recommend-card{

        background:#ffffff;

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .recommend-card:hover{

        border-color:#f6b000;

    }

    [data-bs-theme="light"] .recommend-avatar{

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .recommend-name{

        color:#1e293b;

    }

    [data-bs-theme="light"] .recommend-position{

        color:#64748b;

    }

    [data-bs-theme="light"] .recommend-text{

        color:#64748b;

    }

</style>

<div id="tab-rekomendasi" class="profile-content">

    <div class="profile-section-card p-4">

        <h4 class="profile-section-title mb-4">
            Rekomendasi
        </h4>

        <!-- Card -->
        <div class="recommend-card">

            <div class="d-flex align-items-start">

                <img src="/assets/media/avatars/300-2.jpg"
                    class="recommend-avatar">

                <div class="ms-3 flex-grow-1">

                    <div class="recommend-name">
                        Irwan Prasetyo
                    </div>

                    <div class="recommend-position">
                        Danru Shift A • Mal Grand Indonesia
                    </div>

                </div>

            </div>

            <div class="recommend-text mt-4">

                "Budi adalah anggota yang sangat disiplin dan sigap.
                Kemampuan observasinya sangat baik, dan ia selalu tepat
                waktu dalam pelaporan kejadian."

            </div>

        </div>

        <!-- Card -->
        <div class="recommend-card mt-4">

            <div class="d-flex align-items-start">

                <img src="/assets/media/avatars/300-4.jpg"
                    class="recommend-avatar">

                <div class="ms-3 flex-grow-1">

                    <div class="recommend-name">
                        Hendra Gunawan
                    </div>

                    <div class="recommend-position">
                        Security Manager • Bank BNI
                    </div>

                </div>

            </div>

            <div class="recommend-text mt-4">

                "Selama bertugas di bawah pengawasan saya,
                Budi menunjukkan dedikasi tinggi dan kemampuan
                komunikasi yang efektif dengan pengunjung."

            </div>

        </div>

    </div>

</div>