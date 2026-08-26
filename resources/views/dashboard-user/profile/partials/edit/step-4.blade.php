<div class="wizard-page" id="step4">

    <div class="profile-form-card">

        <!-- Header -->
        <div class="form-header mb-8">

            <div class="header-icon">
                <i class="ki-duotone ki-pad fs-2 text-warning"></i>
            </div>

            <div>

                <div class="step-label">
                    LANGKAH 4 DARI 4
                </div>

                <h2 class="step-title">
                    Media Sosial
                </h2>

                <div class="step-description">
                    Branding perusahaan.
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12 mb-5">

                <label class="form-label">

                    Link Instagram <span class="text-muted">(opsional)</span>

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-fasten"></i>

                    <input type="url" name="instagram" class="form-control auto-input"
                    placeholder="https://instagram.com"
                    value="{{ $data->instagram }}">

                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label">

                    Link Facebook <span class="text-muted">(opsional)</span>

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-fasten"></i>

                    <input type="url" name="facebook" class="form-control auto-input"
                    placeholder="https://facebook.com"
                    value="{{ $data->facebook }}">

                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label">

                    Link LinkedIn <span class="text-muted">(opsional)</span>

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-fasten"></i>

                    <input type="url" name="linkedin" class="form-control auto-input"
                    placeholder="https://linkedin.com"
                    value="{{ $data->linkedin }}">

                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label">

                    Link Youtube <span class="text-muted">(opsional)</span>

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-fasten"></i>

                    <input type="url" name="youtube" class="form-control auto-input"
                    placeholder="https://youtube.com"
                    value="{{ $data->youtube }}">

                </div>

            </div>

        </div>

    </div>

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-12 col-md-3">

                <button class="btn btn-profile-secondary w-100 btn-prev-step"
                data-prev="3" type="button">

                    <i class="ki-duotone ki-left me-2"></i>

                    Kembali

                </button>

            </div>

            <div class="col-12 col-md-9">

                <button class="btn-next-step" type="submit">

                    Simpan & Selesaikan Profil

                </button>

            </div>

        </div>

    </div>

</div>