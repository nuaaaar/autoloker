<div class="wizard-page" id="step3">

    <div class="profile-form-card">

        <!-- Header -->
        <div class="form-header mb-8">

            <div class="header-icon">
                <i class="ki-duotone ki-award fs-2 text-warning"></i>
            </div>

            <div>
                <div class="step-label">
                    LANGKAH 3 DARI 4
                </div>

                <h2 class="step-title">
                    Kemampuan
                </h2>

                <div class="step-description">
                    Pilih semua kemampuan khusus yang Anda kuasai.
                </div>
            </div>

        </div>

        <!-- Counter -->

        <div class="skill-top">

            <div>
                Dipilih:
                <span id="skillCount">0</span>
                kemampuan
            </div>

            <a href="#" id="clearSkill">
                Hapus semua
            </a>

        </div>

        <!-- Skill List -->

        <div class="skill-list">

            @php
                $abilities = $data->ability
                    ? explode(',', $data->ability)
                    : [];

                $master_abilities = \App\Models\MasterAbility::orderBy('title')->get();
            @endphp

            <input type="hidden" name="ability" id="skills">
            @foreach($master_abilities as $ability)
                <button class="skill-chip {{ in_array($ability->title, $abilities) ? 'active' : '' }}" type="button" data-value="{{ $ability->title }}">{{ $ability->title }}</button>
            @endforeach

        </div>

        <!-- Selected -->

        <div class="selected-card mt-8">

            <h5>
                Kemampuan yang dipilih
            </h5>

            <div class="selected-skill" id="selectedSkill">

                <span class="text-muted">
                    Belum memilih kemampuan
                </span>

            </div>

        </div>

        <!-- Info -->

        <div class="skill-note mt-8">

            <h5>
                Kemampuan lain yang belum tercantum?
            </h5>

            <p>
                Tuliskan di kolom catatan pada langkah terakhir.
            </p>

        </div>

    </div>

    <!-- Footer -->

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-3">

                <button class="btn btn-profile-secondary w-100 btn-prev-step"
                data-prev="2" type="button">

                    <i class="ki-duotone ki-left me-2"></i>

                    Kembali

                </button>

            </div>

            <div class="col-9">

                <button class="btn-next-step" data-next="4" type="button">

                    Lanjut : Penempatan

                    <i class="ki-duotone ki-right ms-2"></i>

                </button>

            </div>

        </div>

    </div>

</div>