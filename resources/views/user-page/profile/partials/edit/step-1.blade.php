<style>
    .upload-photo{

        height:200px;

        border:2px dashed #33415c;

        border-radius:18px;

        overflow:hidden;

        cursor:pointer;

        position:relative;

        background:#10182b;

        transition:.3s;

    }

    .upload-photo:hover{

        border-color:#f6b000;

    }

    .upload-placeholder{

        height:100%;

        display:flex;

        flex-direction:column;

        justify-content:center;

        align-items:center;

        color:#8fa0bc;

    }

    .upload-preview{

        width:100%;

        height:100%;

        position:relative;

    }

    .upload-preview img{

        width:100%;

        height:100%;

        object-fit:cover;

    }

    .preview-overlay{

        position:absolute;

        inset:0;

        background:rgba(0,0,0,.45);

        opacity:0;

        display:flex;

        flex-direction:column;

        justify-content:center;

        align-items:center;

        color:#fff;

        transition:.3s;

    }

    .upload-preview:hover .preview-overlay{

        opacity:1;

    }

    .upload-file-info{

        padding:10px 14px;

        background:#1b2440;

        border-radius:12px;

        border:1px solid #2c3b57;

    }
</style>

<div class="wizard-page active" id="step1">

    <div class="profile-form-card">

        <!-- Header -->

        <div class="form-header mb-8">

            <div class="header-icon">

                <i class="ki-duotone ki-profile-circle fs-2 text-warning"></i>

            </div>

            <div>

                <div class="step-label">

                    LANGKAH 1 DARI 4

                </div>

                <h2 class="step-title">

                    Data Pribadi

                </h2>

                <div class="step-description">

                    Isi data sesuai KTP. Data digunakan untuk proses verifikasi identitas.

                </div>

            </div>

        </div>

        <!-- Upload -->

        <div class="upload-card mb-8">

            <div class="row align-items-center">

                <div class="col-lg-3">

                    <label class="upload-photo">

                    <input
                        type="file"
                        id="photoInput"
                        name="formal_photo"
                        accept=".jpg,.jpeg,.png"
                        hidden>

                    @if($data->formal_photo)

                        <div class="upload-preview">

                            <img
                                id="previewImage"
                                src="{{ asset('storage/'.$data->formal_photo) }}">

                            <div class="preview-overlay">

                                <i class="ki-duotone ki-camera fs-2"></i>

                                <span>Ganti Foto</span>

                            </div>

                        </div>

                    @else

                        <div class="upload-placeholder">

                            <i class="ki-duotone ki-camera fs-1 mb-3"></i>

                            <div>Foto Formal</div>

                            <small>3x4 / 4x6</small>

                        </div>

                        <div class="upload-preview d-none">

                            <img id="previewImage">

                            <div class="preview-overlay">

                                <i class="ki-duotone ki-camera fs-2"></i>

                                <span>Ganti Foto</span>

                            </div>

                        </div>

                    @endif

                </label>

                </div>

                <div class="col-lg-9">

                    <h5 class="text-white mb-3">
                        Foto Formal
                    </h5>

                    <p class="text-gray-500 mb-3">
                        Gunakan foto terbaru dengan pakaian rapi.
                    </p>

                    <ul class="upload-info mb-3">

                        <li>JPG / PNG</li>

                        <li>Maksimal 5 MB</li>

                        <li>Wajah terlihat jelas</li>

                    </ul>

                    <div class="upload-file-info d-none">

                        <div class="fw-semibold text-warning" id="fileName"></div>

                        <small class="text-muted" id="fileSize"></small>

                    </div>

                </div>

            </div>

        </div>

        <!-- Form -->

        <div class="row">

            <div class="col-12 mb-5">

                <label class="form-label required">

                    Nama Lengkap

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-profile-circle"></i>

                    <input type="text" name="name" value="{{ $data->name }}" class="form-control auto-input"

                           placeholder="Nama lengkap">
                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Tempat Lahir

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-geolocation"></i>

                    <input type="text" name="birth_place" value="{{ $data->birth_place }}" class="form-control auto-input"
                        placeholder="Balikpapan">

                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Tanggal Lahir

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-calendar"></i>

                    <input type="date" name="birth_date" value="{{ $data->birth_date }}"
                           class="form-control auto-input">

                </div>

            </div>

            <div class="col-12 mb-5">

                <label class="form-label required">

                    Jenis Kelamin

                </label>

                <input type="hidden" name="gender" id="gender" value="{{ $data->gender }}">

                <div class="gender-group">

                    <button type="button"
                            class="gender-btn {{ $data->gender == 'laki-laki' ? 'active' : '' }}" value="Laki-laki">

                        Laki-laki

                    </button>

                    <button type="button"
                            class="gender-btn {{ $data->gender == 'perempuan' ? 'active' : '' }}"  value="Perempuan">

                        Perempuan

                    </button>

                </div>

            </div>

            <div class="col-12 mb-5">

                <label class="form-label required">

                    Alamat Domisili

                </label>

                <textarea name="address" class="form-control auto-input"
                placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"          
                rows="3">{{ $data->address }}</textarea>

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

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Nomor HP

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-phone"></i>

                    <input type="text" name="phone_number" class="form-control auto-input"
                    value="{{ $data->phone_number }}">

                </div>

            </div>

            <div class="col-md-6 mb-5">

                <label class="form-label required">

                    Email Aktif

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-sms"></i>

                    <input type="text" name="email" class="form-control auto-input"
                    value="{{ $data->email }}">

                </div>

            </div>

            <div class="col-12">

                <label class="form-label required">

                    Nomor KTP

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-lock"></i>

                    <input type="text" name="ktp_number" class="form-control auto-input"
                           maxlength="16"
                    placeholder="16 Digit Nomor NIK"   
                    value="{{ $data->ktp_number }}"    
                    >

                </div>

                <small class="text-gray-600">

                    Data ini tidak akan ditampilkan ke publik.

                </small>

            </div>

        </div>

    </div>

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-3">

                <a href="{{ route('user-page.profile') }}">

                    <button class="btn btn-profile-secondary w-100 btn-prev-step" type="button">

                        <i class="ki-duotone ki-left me-2"></i>

                        Kembali

                    </button>

                </a>

            </div>

            <div class="col-9">

                <button class="btn-next-step" data-next="2" type="button">

                    Lanjut : Profil Satpam

                    <i class="ki-duotone ki-right ms-2"></i>

                </button>

            </div>

        </div>

    </div>

</div>