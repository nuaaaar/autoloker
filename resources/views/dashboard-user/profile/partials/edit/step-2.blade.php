<div class="wizard-page" id="step2">

    <div class="profile-form-card">

        <!-- Header -->
        <div class="form-header mb-8">

            <div class="header-icon">
                <i class="ki-duotone ki-geolocation fs-2 text-warning"></i>
            </div>

            <div>

                <div class="step-label">
                    LANGKAH 2 DARI 4
                </div>

                <h2 class="step-title">
                    Kontak & Alamat
                </h2>

                <div class="step-description">
                    Informasi lokasi dan kontak perusahaan.
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Nomor HP

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-phone"></i>

                    <input type="text" name="phone" class="form-control auto-input"
                    placeholder="08123456789"
                    value="{{ $data->phone }}">

                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Email Aktif

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-sms"></i>

                    <input type="text" name="email" class="form-control auto-input"
                    placeholder="email@domain.com"
                    value="{{ $data->email }}">

                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label">

                    Link Website <span class="text-muted">(opsional)</span>

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-fasten"></i>

                    <input type="url" name="website" class="form-control auto-input"
                    placeholder="https://domain.com"
                    value="{{ $data->website }}">

                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">
                    Provinsi
                </label>

                <select
                    class="form-select auto-input"
                    id="province"
                    name="province">

                    <option value="">
                        Pilih Provinsi..
                    </option>

                    @foreach(\Laravolt\Indonesia\Models\Province::orderBy('name')->get() as $data_province)

                        <option
                            value="{{ $data_province->code }}"
                            {{ old('province',$province->code ?? '')==$data_province->code?'selected':'' }}>

                            {{ $data_province->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Kota / Kabupaten

                </label>

                <select
                    class="form-select auto-input"
                    id="city"
                    name="city"
                    disabled>

                    <option value="">
                        Pilih Provinsi terlebih dahulu
                    </option>

                </select>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Kecamatan

                </label>

                <select
                    class="form-select auto-input"
                    id="district"
                    name="district"
                    disabled>

                    <option value="">
                        Pilih Kota/Kabupaten terlebih dahulu
                    </option>

                </select>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Kelurahan

                </label>

                <select
                    class="form-select auto-input"
                    id="village"
                    name="village"
                    disabled>

                    <option value="">
                        Pilih Kecamatan terlebih dahulu
                    </option>

                </select>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label required">

                    Kode Pos

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-map"></i>

                    <input type="text" name="postal_code" class="form-control auto-input"
                    placeholder="712345"
                    value="{{ $data->postal_code }}">

                </div>

            </div>

            <div class="col-12 mb-5">

                <label class="form-label required">

                    Alamat Lengkap Perusahaan

                </label>

                <textarea name="address" class="form-control auto-input"
                placeholder="Alamat lengkap perusahaan"          
                rows="3">{{ $data->address }}</textarea>

            </div>

        </div>

    </div>

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-12 col-md-3">

                <button class="btn btn-profile-secondary w-100 btn-prev-step"
                data-prev="1" type="button">

                    <i class="ki-duotone ki-left me-2"></i>

                    Kembali

                </button>

            </div>

            <div class="col-12 col-md-9">

                <button class="btn-next-step" data-next="3" type="button">

                    Lanjut : Legalitas

                    <i class="ki-duotone ki-right ms-2"></i>

                </button>

            </div>

        </div>

    </div>

</div>