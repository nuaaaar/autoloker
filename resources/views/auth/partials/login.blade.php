<div id="loginPage" class="validate-form">

    <!-- Title -->
    <h1 class="text-2xl font-bold text-foreground mb-1 text-white">
        Masuk ke Akun Anda
    </h1>
    <p class="text-xs text-muted mb-3">
        Pilih peran Anda untuk melanjutkan
    </p>

    <!-- Role -->
    <div class="rounded-pill p-1 d-flex mb-3 mt-3" style="background:#152040;">

        <button
            id=""
            class="btn btn-warning rounded-pill fw-bold flex-fill text-dark role-btn btnSatpam active">
            🛡️ Satpam / Anggota
        </button>

        <button
            id=""
            class="btn rounded-pill fw-bold flex-fill role-btn text-muted btnPerusahaan">
            🏢 Perusahaan / BUJP
        </button>

    </div>
    
    <div id="" class="loginSatpam">

        <!-- Tabs -->
        <ul class="nav custom-tabs mb-7">
            <li class="nav-item">
                <a class="nav-link active fw-bold fs-8 px-0 me-3"
                data-bs-toggle="tab"
                href="#login-password">
                    Email / Password
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fw-bold fs-8 px-0"
                data-bs-toggle="tab"
                href="#login-otp">
                    WhatsApp OTP
                </a>
            </li>
        </ul>

        <div class="tab-content">

            <!-- PASSWORD -->
            <div class="tab-pane fade show active" id="login-password">
                <form id="formLoginSatpam">

                    <input type="hidden" name="role" value="satpam">

                    <!-- Email -->
                    <div class="mb-7">
                        <label class="form-label text-white fw-semibold fs-6">
                            Email / No. WhatsApp
                        </label>

                        <div class="input-group input-group-lg">
                            <span class="input-group-text border-0"
                                style="background:#1b2547;">
                                <i class="bi bi-chat-left text-muted"></i>
                            </span>

                            <input type="text"
                                name="email"
                                class="form-control border-0 text-white required-field"
                                id="email"
                                placeholder="08xxxxxxxxxx atau email@anda.com"
                                style="background:#1b2547; height: 50%;">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">

                        <div class="d-flex justify-content-between mb-2">

                            <label class="form-label text-white fw-semibold fs-6 mb-0">
                                Kata Sandi
                            </label>

                            <a href="#"
                                class="text-warning fw-bold text-decoration-none">
                                Lupa kata sandi?
                            </a>

                        </div>

                        <div class="input-group input-group-lg">

                            <span class="input-group-text border-0" style="background:#1b2547;">
                                <i class="bi bi-lock text-muted"></i>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control border-0 text-white required-field"
                                placeholder="Masukkan kata sandi"
                                style="background:#1b2547;
                                height: 50%;">

                            <button
                                type="button"
                                id="togglePassword"
                                class="input-group-text border-0"
                                style="background:#1b2547; cursor:pointer;">

                                <i class="bi bi-eye text-muted"></i>

                            </button>

                        </div>

                    </div>

                    <!-- Login -->
                    <button class="btn btn-warning w-100 py-3 fw-bold fs-6 mt-8" id="btnLogin" style="height: 50%;">
                        Masuk Sekarang
                    </button>

                </form>

            </div>

            <!-- OTP -->
            <div class="tab-pane fade" id="login-otp">

                <label class="form-label text-white fw-semibold fs-6 mb-1">
                    No. WhatsApp
                </label>

                <div class="input-group input-group-lg mb-6">

                    <span class="input-group-text border-0"
                        style="background:#1b2547; color:#fff; ">
                        🇮🇩
                        <span class="ms-2 fw-semibold">+62</span>
                    </span>

                    <input
                        type="text"
                        id="phone_number"
                        class="form-control border-0 text-white required-field"
                        placeholder="81234567890"
                        style="background:#1b2547;">

                </div>

                <button class="btn btn-success w-100 py-3 fw-bold fs-6"
                    id="btnOtp"
                    style="height: 50%;"
                    disabled
                >
                    Kirim OTP
                </button>

            </div>

        </div>

        <!-- Divider -->
        <div class="d-flex align-items-center my-10">

            <div class="flex-grow-1 border-bottom border-gray-700"></div>

            <span class="mx-5 text-muted fs-8">
                atau masuk dengan
            </span>

            <div class="flex-grow-1 border-bottom border-gray-700"></div>

        </div>

        <!-- Google -->
        <a href="{{ route('google.login',[
                'role'=>'satpam',
                'action'=>'login'
            ]) }}">
            <button class="btn btn-sm btn-dark w-100 py-3" style="background-color: #080d1c; border: 1px solid gray; border-radius: 10px;">

                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                    width="16"
                    class="me-3">

                <span class="fw-bold fs-6">
                    Masuk dengan Google
                </span>

            </button>
        </a>

        <!-- Register -->
        <div class="text-center mt-10">

            <span class="text-muted fs-8">
                Belum punya akun?
            </span>

            <a href="#" id="showRegister"
                class="fw-bold text-warning text-decoration-none">
                Daftar Sekarang
            </a>

        </div>

    </div>

    <div id="" class="loginPerusahaan" style="display: none;">
        <div class="tab-content">

            <!-- PASSWORD -->
            <div class="tab-pane fade show active" id="login-password">
                <form id="formLoginCompany">

                    <input type="hidden" name="role" value="company">
                    <!-- Email -->
                    <div class="mb-7">
                        <label class="form-label text-white fw-semibold fs-6">
                            Email Perusahaan
                        </label>

                        <div class="input-group input-group-lg">
                            <span class="input-group-text border-0"
                                style="background:#1b2547;">
                                <i class="bi bi-globe text-muted"></i>
                            </span>

                            <input type="text"
                                name="email"
                                class="form-control border-0 text-white required-field"
                                id="emailCompany"
                                placeholder="hrd@perusahaan.com"
                                style="background:#1b2547; height: 50%;">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">

                        <div class="d-flex justify-content-between mb-2">

                            <label class="form-label text-white fw-semibold fs-6 mb-0">
                                Kata Sandi
                            </label>

                            <a href="#"
                                class="text-warning fw-bold text-decoration-none">
                                Lupa kata sandi?
                            </a>

                        </div>

                        <div class="input-group input-group-lg">

                            <span class="input-group-text border-0" style="background:#1b2547;">
                                <i class="bi bi-lock text-muted"></i>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="passwordCompany"
                                class="form-control border-0 text-white required-field"
                                placeholder="Masukkan kata sandi"
                                style="background:#1b2547;
                                height: 50%;">

                            <button
                                type="button"
                                id="togglePasswordCompany"
                                class="input-group-text border-0"
                                style="background:#1b2547; cursor:pointer;">

                                <i class="bi bi-eye text-muted"></i>

                            </button>

                        </div>

                    </div>

                    <!-- Login -->
                    <button class="btn btn-warning w-100 py-3 fw-bold fs-6 mt-8" id="btnLoginCompany" style="height: 50%;">
                        Masuk Sekarang
                    </button>

                </form>

            </div>

        </div>

        <!-- Divider -->
        <div class="d-flex align-items-center my-10">

            <div class="flex-grow-1 border-bottom border-gray-700"></div>

            <span class="mx-5 text-muted fs-8">
                atau masuk dengan
            </span>

            <div class="flex-grow-1 border-bottom border-gray-700"></div>

        </div>

        <!-- Google -->
        <a href="{{ route('google.login',[
                'role'=>'company',
                'action'=>'login'
            ]) }}">
            <button class="btn btn-sm btn-dark w-100 py-3" style="background-color: #080d1c; border: 1px solid gray; border-radius: 10px;">

                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                    width="16"
                    class="me-3">

                <span class="fw-bold fs-6">
                    Masuk dengan Google
                </span>

            </button>
        </a>

        <!-- Register -->
        <div class="text-center mt-10">

            <span class="text-muted fs-8">
                Belum punya akun?
            </span>

            <a href="#" id="showRegisterCompany"
                class="fw-bold text-warning text-decoration-none">
                Daftar Sekarang
            </a>

        </div>
    </div>

</div>