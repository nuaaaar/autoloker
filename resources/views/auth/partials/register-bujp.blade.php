<div id="registerBUJPPage" class="validate-form" style="display: none;">

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
        id="backToRegisterFromBUPJ"
        class="text-muted text-decoration-none">

        <i class="bi bi-arrow-left"></i>
        Kembali

    </a>

    <h2 class="text-white fw-bold mt-5">
        Registrasi BUJP
    </h2>

    <p class="text-muted mb-8 fs-7">
        Lengkapi data BUJP dan lampirkan Surat Izin Operasional (SIO) dari Polri untuk verifikasi.
    </p>

    <form id="formRegisterBUJP"
      action="{{ route('register.bujp') }}"
      method="POST"
      enctype="multipart/form-data">

        @csrf

        <!-- Nama BUJP -->

        <div class="mb-5">

            <label class="form-label text-white fs-6">
                Nama BUJP <i class="text-danger">*</i>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-building"></i>

                </span>

                <input 

                    type="text"

                    name="name"
                
                    class="form-control border-0 required-field"
                    
                    style="background:#1b2547;color:white;height:50%;"

                    placeholder="PT Nama BUJP Anda">

            </div>

        </div>

        <!-- Email -->

        <div class="mb-5">

            <label class="form-label text-white fs-6">

                Email Resmi BUJP <i class="text-danger">*</i>

            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">

                    <i class="bi bi-globe"></i>

                </span>

                <input 
                    type="email"

                    name="email"
                
                    class="form-control border-0 required-field"

                    style="background:#1b2547;color:white;height:50%;"

                    placeholder="operasional@bujp.com">

            </div>

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
                    id="registerPasswordBUJP"
                    name="password"
                    class="form-control border-0 required-field"
                    style="background:#1b2547;color:white;height:50%;"
                    placeholder="Minimal 8 karakter">

                <button
                    type="button"
                    class="input-group-text border-0 toggle-password"
                    data-target="#registerPasswordBUJP"
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
                    id="registerPasswordConfirmationBUJP"
                    name="password_confirmation"
                    class="form-control border-0 required-field"
                    style="background:#1b2547;color:white;height:50%;"
                    placeholder="Ulangi password">

                <button
                    type="button"
                    class="input-group-text border-0 toggle-password"
                    data-target="#registerPasswordConfirmationBUJP"
                    style="background:#1b2547;cursor:pointer;">

                    <i class="bi bi-eye"></i>

                </button>

            </div>

        </div>

        <!-- Row -->

        <div class="row">

            <div class="col-12">

                <label class="form-label text-white fs-6">

                    NIB <span class="text-muted text-small">(opsional)</span>

                </label>

                <input 

                    type="text"

                    name="nib"
                
                    class="form-control"

                    style="background:#1b2547;border:0;color:white;height:50%;"
                    placeholder="01234567890123"
                    >

            </div>

        </div>

        <!-- Divider -->

        <div class="d-flex align-items-center my-8">

            <div class="flex-grow-1 border-bottom border-secondary opacity-25"></div>

            <span class="mx-4 fw-bold text-warning text-uppercase fs-7">
                SURAT IZIN OPERASIONAL (SIO)
            </span>

            <div class="flex-grow-1 border-bottom border-secondary opacity-25"></div>

        </div>

        <!-- Alert -->

        <div class="alert d-flex align-items-start"
            style="background:#1b1a17; border:1px solid #705000; color:#ffc107;">

            <i class="bi bi-exclamation-triangle-fill fs-3 me-3 flex-shrink-0 mt-1"></i>

            <div class="fs-7">
                <strong>Informasi:</strong><br>
                SIO adalah dokumen wajib yang diterbitkan oleh Polri/Kapolda sebagai izin resmi
                operasional BUJP. Tanpa SIO, pendaftaran tidak dapat diproses.
            </div>

        </div>

        <!-- Nomor -->

        <div class="row">

            <div class="col-6">

                <label class="form-label text-white fs-6">

                    Nomor SIO <i class="text-danger">*</i>

                </label>

                <input 

                    type="text"

                    name="sio_number"
                
                    class="form-control required-field"
                    placeholder="B/1234/V/2024/SIO"
                    style="background:#1b2547;border:0;color:white;height:50%;">

            </div>

            <div class="col-6">

                <label class="form-label text-white fs-6">

                    Masa Berlaku <i class="text-danger">*</i>

                </label>

                <input 
                    type="date"

                    name="sio_expired_date"

                    class="form-control required-field"

                    style="background:#1b2547;border:0;color:white;height:50%;">

            </div>

        </div>

        <!-- Upload -->

        <div class="d-flex gap-3 mt-6">

            <!-- Upload File -->
            <button
                type="button"
                id="btnUploadFile"
                class="btn btn-warning d-flex align-items-center">

                <i class="bi bi-upload me-2"></i>
                File SIO

            </button>

        </div>

        <!-- Input Link -->
        <div id="linkContainer" class="mt-5 " style="display: none;">

            <label class="form-label text-white fs-6">
                Link Dokumen <i class="text-danger">*</i>
            </label>

            <div class="input-group">

                <span class="input-group-text border-0"
                    style="background:#1b2547;">
                    <i class="bi bi-link-45deg text-muted"></i>
                </span>

                <input
                    type="url"
                    name="sio_url"
                    class="form-control border-0 text-white"
                    placeholder="https://drive.google.com/..."
                    style="background:#1b2547;height: 50%;">

            </div>

        </div>

        <!-- Upload Area -->

        <div class="mt-5 dropzone" id="uploadContainer">

            <div class="dz-message" id="dropzoneMessage">

                <i class="bi bi-cloud-arrow-up-fill text-warning"
                    style="font-size:48px;"></i>

                <h5 class="text-white mt-3 mb-2">
                    Seret file di sini
                </h5>

                <p class="text-muted mb-0">
                    atau klik untuk memilih file
                </p>

                <small class="text-muted">
                    PDF, JPG, PNG (Maks. 5 MB)
                </small>

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
        'role'=>'bujp',
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