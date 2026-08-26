<div class="wizard-page" id="step2">

    <div class="profile-form-card">

        <!-- Header -->
        <div class="form-header mb-8">

            <div class="header-icon">
                <i class="ki-duotone ki-shield-search fs-2 text-warning"></i>
            </div>

            <div>

                <div class="step-label">
                    LANGKAH 2 DARI 4
                </div>

                <h2 class="step-title">
                    Profil Satpam
                </h2>

                <div class="step-description">
                    Lengkapi informasi profesi dan pengalaman kerja Anda.
                </div>

            </div>

        </div>

        <div class="row">

            <!-- Status -->
            <div class="col-md-6 mb-5">

                <label class="form-label required">
                    Status Satpam
                </label>

                <select class="form-select auto-input" name="work_status">

                    <option value="Aktif" {{ $data->work_status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option  value="Tidak Aktif" {{ $data->work_status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option  value="Mencari Kerja" {{ $data->work_status == 'Mencari Kerja' ? 'selected' : '' }}>Mencari Pekerjaan</option>

                </select>

            </div>

            <!-- Perusahaan -->
            <div class="col-md-6 mb-5">

                <label class="form-label">
                    Perusahaan / BUJP
                </label>

                <input class="form-control auto-input"
                       placeholder="PT Tekno Putra Perkasa" name="company_name" value="{{ $data->company_name }}">

            </div>

            <!-- NRP -->
            <div class="col-md-6 mb-5">

                <label class="form-label">
                    Nomor NRP
                </label>

                <input class="form-control auto-input" name="registration_number" value="{{ $data->registration_number }}"
                       placeholder="TPP-2024-0001">

            </div>

            <!-- Jabatan -->
            <div class="col-md-6 mb-5">

                <label class="form-label">
                    Jabatan
                </label>

                <select class="form-select auto-input" name="position">
                    @php
                        $master_positions = \App\Models\MasterPosition::orderBy('title')->get();
                    @endphp
                    @foreach($master_positions as $position)
                        <option value="{{ $position->title }}" {{ $data->position == $position->title ? 'selected' : '' }}>{{ $position->title }}</option>
                    @endforeach

                </select>

            </div>
            <!-- Pengalaman -->
            <div class="col-md-6 mb-5">

                <label class="form-label required">
                    Pengalaman Kerja
                </label>

                <select class="form-select auto-input" name="work_experience">

                    <option value="< 1 Tahun" {{ $data->work_experience == '< 1 Tahun' ? 'selected' : '' }}>< 1 Tahun</option>
                    <option value="1-3 Tahun" {{ $data->work_experience == '1-3 Tahun' ? 'selected' : '' }}>1-3 Tahun</option>
                    <option value="3-5 Tahun" {{ $data->work_experience == '3-5 Tahun' ? 'selected' : '' }}>3-5 Tahun</option>
                    <option value="> 5 Tahun" {{ $data->work_experience == '> 5 Tahun' ? 'selected' : '' }}>> 5 Tahun</option>

                </select>

            </div>

            <!-- Tinggi -->
            <div class="col-md-3 mb-5">

                <label class="form-label required">
                    Tinggi Badan
                </label>

                <input type="text" name="height" class="form-control auto-input" value="{{ $data->height }}"
                       placeholder="170">

            </div>

            <!-- Berat -->
            <div class="col-md-3 mb-5">

                <label class="form-label required">
                    Berat Badan
                </label>

                <input type="text" name="width" class="form-control auto-input" value="{{ $data->width }}"
                       placeholder="65">

            </div>

            <!-- Shift -->
            <div class="col-md-6 mb-5">

                <label class="form-label">
                    Bersedia Shift
                </label>

                <select class="form-select auto-input" name="is_shift_agree">

                    <option value="1" {{ $data->is_shift_agree == 1 ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ $data->is_shift_agree == 0 ? 'selected' : '' }}>Tidak</option>

                </select>

            </div>

            <!-- Penempatan -->
            <div class="col-md-6 mb-5">

                <label class="form-label">
                    Bersedia Penempatan Luar Kota
                </label>

                <select class="form-select auto-input" name="is_out_of_town_agree">

                    <option value="1" {{ $data->is_out_of_town_agree == 1 ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ $data->is_out_of_town_agree == 0 ? 'selected' : '' }}>Tidak</option>

                </select>

            </div>

            <!-- SIM -->
            <div class="col-md-6 mb-5">

                <label class="form-label">
                    Memiliki SIM
                </label>

                <select class="form-select auto-input" name="sim">

                    <option value="Tidak Ada" {{ $data->sim == 'Tidak Ada' ? '' : '' }}>Tidak Ada</option>
                    <option value="SIM A" {{ $data->sim == 'SIM A' ? '' : '' }}>SIM A</option>
                    <option value="SIM C" {{ $data->sim == 'SIM C' ? '' : '' }}>SIM C</option>
                    <option value="SIM A & C" {{ $data->sim == 'SIM A & C' ? '' : '' }}>SIM A & C</option>

                </select>

            </div>

            <!-- Deskripsi -->
            <div class="col-12">

                <label class="form-label">
                    Ringkasan Profil
                </label>

                <textarea
                    name="self_description"
                    class="form-control auto-input"
                    rows="5"
                    placeholder="Ceritakan pengalaman Anda sebagai anggota satpam...">{{ $data->self_description }}</textarea>

            </div>

        </div>

    </div>

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-3">

                <button class="btn btn-profile-secondary w-100 btn-prev-step"
                data-prev="1" type="button">

                    <i class="ki-duotone ki-left me-2"></i>

                    Kembali

                </button>

            </div>

            <div class="col-9">

                <button class="btn-next-step" data-next="3" type="button">

                    Lanjut : Kemampuan

                    <i class="ki-duotone ki-right ms-2"></i>

                </button>

            </div>

        </div>

    </div>

</div>