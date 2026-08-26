<div id="registerCompanyPage" class="validate-form" style="display: none;">

    <!-- Progress -->
    <div class="d-flex gap-2 mb-8">

        <div class="flex-grow-1 rounded-pill bg-warning"
            style="height:4px;"></div>

        <div class="flex-grow-1 rounded-pill bg-warning"
            style="height:4px;"></div>

        <div class="flex-grow-1 rounded-pill"
            style="height:4px;background:#26304d;"></div>

    </div>

    <a href="#"
        id="backToRegisterFromCompany"
        class="text-muted text-decoration-none">

        <i class="bi bi-arrow-left"></i>
        Kembali

    </a>

    <h2 class="text-white fw-bold mt-5">
        Data Perusahaan
    </h2>

    <p class="text-muted mb-8 fs-7">
        Daftarkan perusahaan Anda dan temukan personil satpam tersertifikasi dengan cepat.
    </p>

    <!-- Nama BUJP -->

    <form id="formRegisterCompany">

        <div class="mb-5">

            <label class="form-label text-white fs-6">
                Nama Perusahaan / Instansi <i class="text-danger">*</i>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-building"></i>

                </span>

                <input class="form-control border-0 required-field"
                    name="name"

                    style="background:#1b2547;color:white;height:50%;"

                    placeholder="PT Nama Perusahaan Anda">

            </div>

        </div>

        <div class="mb-5">

            <label class="form-label text-white fs-6">
                Email Resmi Perusahaan <i class="text-danger">*</i>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-globe"></i>

                </span>

                <input class="form-control border-0 required-field"
                    name="email"

                    style="background:#1b2547;color:white;height:50%;"

                    placeholder="hrd@perusahaan.com">

            </div>

            <span class="text-muted text-small">Gunakan email domain perusahaan untuk verifikasi lebih cepat.</span>

        </div>
        
        <div class="mb-5">

            <label class="form-label text-white fs-6">
                Password <i class="text-danger">*</i>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-lock"></i>

                </span>

                <input
                    type="password"
                    id="registerPasswordCompany"
                    name="password"
                    class="form-control border-0 required-field"
                    style="background:#1b2547;color:white;height:50%;"
                    placeholder="Minimal 8 karakter">

                <button
                    type="button"
                    class="input-group-text border-0 toggle-password"
                    data-target="#registerPasswordCompany"
                    style="background:#1b2547;cursor:pointer;">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

            <small class="text-muted">
                Minimal 8 karakter, huruf besar, huruf kecil dan angka.
            </small>

        </div>

        <div class="mb-5">

            <label class="form-label text-white fs-6">
                Konfirmasi Password <i class="text-danger">*</i>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-shield-lock"></i>

                </span>

                <input
                    type="password"
                    id="registerPasswordConfirmationCompany"
                    name="password_confirmation"
                    class="form-control border-0 required-field"
                    style="background:#1b2547;color:white;height:50%;"
                    placeholder="Ulangi password">

                <button
                    type="button"
                    class="input-group-text border-0 toggle-password"
                    data-target="#registerPasswordConfirmationCompany"
                    style="background:#1b2547;cursor:pointer;">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

        </div>

        <div class="mb-5">

            <label class="form-label text-white fs-6">
                NIB / Nomor Induk Berusaha <span class="text-muted text-small">(opsional)</span>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-file-earmark"></i>

                </span>

                <input class="form-control border-0"
                    name="nib"

                    style="background:#1b2547;color:white;height:50%;"

                    placeholder="12345678901234">

            </div>

        </div>

        <!-- Checkbox -->

        <div class="form-check mt-7">

            <input
            name="agree"
            class="form-check-input custom-checkbox required-field"
            type="checkbox"
            id="agree">

            <label class="form-check-label text-muted fs-7">

                Saya menyetujui <span style="color: #ffc107;">Syarat & Ketentuan</span> serta <span style="color: #ffc107;">Kebijakan Privasi</span> AutoLoker.

            </label>

        </div>

        <button class="btn btn-warning w-100 mt-6 py-3 fw-bold submit-btn">

            Daftar Sekarang

        </button>
        
    </form>

    <!-- Divider -->
    <div class="d-flex align-items-center my-10">

        <div class="flex-grow-1 border-bottom border-gray-700"></div>

        <span class="mx-5 text-muted fs-8">
            atau
        </span>

        <div class="flex-grow-1 border-bottom border-gray-700"></div>

    </div>

    <!-- Google -->
    <a href="{{ route('google.login',[
        'role'=>'company',
        'action'=>'register'
    ]) }}">
        <button class="btn btn-sm btn-dark w-100 py-3" style="background-color: #080d1c; border: 1px solid gray; border-radius: 10px;">

            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                width="16"
                class="me-3">

            <span class="fw-bold fs-6">
                Daftar dengan Google
            </span>

        </button>
    </a>

    <!-- Register -->
    <div class="text-center mt-10">

        <span class="text-muted fs-8">
            Sudah punya akun?
        </span>

        <a href="#" 
            id="btnBackLogin"
            class="fw-bold text-warning text-decoration-none">
            Masuk di sini
        </a>

    </div>

</div>