<div class="wizard-page" id="step3">

    <div class="profile-form-card">

        <!-- Header -->
        <div class="form-header mb-8">

            <div class="header-icon">
                <i class="ki-duotone ki-files fs-2 text-warning"></i>
            </div>

            <div>

                <div class="step-label">
                    LANGKAH 3 DARI 4
                </div>

                <h2 class="step-title">
                    Legalitas
                </h2>

                <div class="step-description">
                    Data legal perusahaan.
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12 mb-5">

                <label class="form-label required">

                    NIB

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-files"></i>

                    <input type="text" name="nib" class="form-control auto-input"
                    placeholder="NIB"
                    value="{{ $data->nib }}">

                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label required">

                    NPWP

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-files"></i>

                    <input type="text" name="npwp" class="form-control auto-input"
                    placeholder="NPWP"
                    value="{{ $data->npwp }}">

                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label required">

                    Nomor Izin Usaha / SIUP

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-files"></i>

                    <input type="text" name="business_license" class="form-control auto-input"
                    placeholder="Nomor Izin Usaha / SIUP"
                    value="{{ $data->business_license }}">

                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Nomor Surat Izin Operasional (SIO)

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-files"></i>

                    <input type="text" name="sio_number" class="form-control auto-input"
                    placeholder="Nomor Surat Izin Operasional (SIO)"
                    value="{{ $data->sio_number }}">

                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Masa Berlaku Surat Izin Operasional (SIO)

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-calendar"></i>

                    <input type="date" name="sio_expired_date" class="form-control auto-input"
                    value="{{ $data->sio_expired_date }}">

                </div>

            </div>

            <div class="upload-card mb-8">

                <div class="row align-items-center">

                    <!-- LEFT -->
                    <div class="col-lg-4">

                        <label class="upload-photo">

                            <input
                                type="file"
                                id="sioFileInput"
                                name="sio_file"
                                accept=".pdf,.jpg,.jpeg,.png"
                                hidden>

                            @if($data->sio_file)

                                <div class="upload-placeholder">

                                    <i class="ki-duotone ki-document fs-1 mb-3 text-warning">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    <div class="fw-bold text-white">
                                        Dokumen SIO
                                    </div>

                                    <small class="text-success">
                                        Sudah Diunggah
                                    </small>

                                </div>

                            @else

                                <div class="upload-placeholder">

                                    <i class="ki-duotone ki-document-upload fs-1 mb-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    <div>
                                        Upload Dokumen SIO
                                    </div>

                                    <small>PDF / JPG / PNG</small>

                                </div>

                            @endif

                        </label>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-lg-8">

                        <h5 class="text-white mb-3">
                            Dokumen Surat Izin Operasional (SIO)
                        </h5>

                        <p class="text-gray-500 mb-3">
                            Unggah dokumen Surat Izin Operasional (SIO) yang masih berlaku.
                            Dokumen ini digunakan sebagai salah satu syarat verifikasi akun BUJP.
                        </p>

                        <ul class="upload-info mb-3">

                            <li>Format PDF, JPG atau PNG</li>

                            <li>Ukuran maksimal 5 MB</li>

                            <li>Pastikan seluruh isi dokumen terbaca dengan jelas</li>

                            <li>Dokumen masih dalam masa berlaku</li>

                        </ul>

                        @if($data->sio_file)

                            <div class="mb-3">

                                <a href="{{ Storage::url($data->sio_file) }}"
                                target="_blank"
                                class="btn btn-warning btn-sm">

                                    <i class="ki-duotone ki-eye fs-6 me-1"></i>

                                    Lihat Dokumen

                                </a>

                            </div>

                        @endif

                        <div class="upload-file-info d-none" id="sioFileInfo">

                            <div class="fw-semibold text-warning" id="sioFileName"></div>

                            <small class="text-muted" id="sioFileSize"></small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Footer -->

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-12 col-md-3">

                <button class="btn btn-profile-secondary w-100 btn-prev-step"
                data-prev="2" type="button">

                    <i class="ki-duotone ki-left me-2"></i>

                    Kembali

                </button>

            </div>

            <div class="col-12 col-md-9">

                <button class="btn-next-step" data-next="4" type="button">

                    Lanjut : Media Sosial

                    <i class="ki-duotone ki-right ms-2"></i>

                </button>

            </div>

        </div>

    </div>

</div>