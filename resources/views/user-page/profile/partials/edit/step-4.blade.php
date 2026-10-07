<div class="wizard-page" id="step4">

    <div class="profile-form-card">

        <!-- Header -->
        <div class="form-header mb-8">
            <div class="header-icon">
                <i class="ki-duotone ki-geolocation-home fs-2 text-warning"></i>
            </div>

            <div>
                <div class="step-label">
                    LANGKAH 4 DARI 4
                </div>

                <h2 class="step-title">
                    Penempatan
                </h2>

                <div class="step-description">
                    Tandai semua jenis lokasi tempat Anda pernah bertugas.
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-between align-items-center flex-wrap mb-6">

            <div class="selected-count">
                Dipilih:
                <span id="placementCount">0</span>
                jenis penempatan
            </div>

            <a href="javascript:;" class="clear-placement" id="clearPlacement">
                Hapus semua
            </a>

        </div>


        <!-- LIST -->
        @php
            /*
            |--------------------------------------------------------------------------
            | PLACEMENT YANG TERSIMPAN DI DATABASE
            |--------------------------------------------------------------------------
            */

            $placements = $data->placements
                ? array_filter(
                    array_map('trim', explode(',', $data->placements))
                )
                : [];


            /*
            |--------------------------------------------------------------------------
            | AMBIL SEMUA MASTER PLACEMENT
            |--------------------------------------------------------------------------
            */

            $master_placements = \App\Models\MasterPlacement::orderBy('title')
                ->get();


            /*
            |--------------------------------------------------------------------------
            | PISAHKAN BERDASARKAN CATEGORY
            |--------------------------------------------------------------------------
            */

            $securityPlacements = $master_placements
                ->where('category', 'security')
                ->values();

            $csPlacements = $master_placements
                ->where('category', 'cs')
                ->values();


            /*
            |--------------------------------------------------------------------------
            | ROLE SAAT INI
            |--------------------------------------------------------------------------
            */

            $currentRole = Auth::user()->role;
        @endphp


        <div class="placement-list" id="placementList">

            {{-- Hidden input --}}
            <input
                type="hidden"
                name="placements"
                id="placements"
                value="{{ implode(',', $placements) }}"
            >


            {{-- ==========================================================
                SATPAM
                ========================================================== --}}

            <div
                class="placement-role-list"
                data-role="satpam"
                style="{{ $currentRole === 'satpam' ? '' : 'display:none;' }}"
            >

                @foreach($securityPlacements as $placement)

                    <button
                        type="button"
                        class="placement-site-item {{ in_array($placement->title, $placements) ? 'active' : '' }}"
                        data-value="{{ $placement->title }}"
                    >
                        {{ $placement->title }}
                    </button>

                @endforeach

            </div>


            {{-- ==========================================================
                CLEANING SERVICE
                ========================================================== --}}

            <div
                class="placement-role-list"
                data-role="cs"
                style="{{ $currentRole === 'cs' ? '' : 'display:none;' }}"
            >

                @foreach($csPlacements as $placement)

                    <button
                        type="button"
                        class="placement-site-item"
                        data-value="{{ $placement->title }}"
                    >
                        {{ $placement->title }}
                    </button>

                @endforeach

            </div>

        </div>

        <!-- Selected -->

        <div class="placement-selected-box mt-8">

            <h5>
                Riwayat penempatan dipilih:
            </h5>

            <div class="placement-selected-list" id="placementSelectedList">

            </div>

        </div>


        <!-- Catatan -->

        <div class="mt-8">

            <label class="form-label">
                Catatan Tambahan
                <span class="text-muted">(opsional)</span>
            </label>

            <textarea
                name="additional_notes"
                class="form-control auto-input"
                id="placement_note"
                maxlength="500"
                rows="6"
                placeholder="Contoh : Pernah bertugas di kapal ferry selama 2 tahun, berpengalaman menangani kerumunan besar di event konser internasional...">{{ $data->additional_notes }}</textarea>

            <div class="text-end mt-2">
                <span id="placementChar">0</span>/500
            </div>

            <small class="text-muted">
                Tuliskan pengalaman spesifik, kemampuan lain, atau hal yang ingin diketahui perekrut.
            </small>

        </div>


    <!-- Footer -->

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-3">

                <button class="btn btn-profile-secondary w-100 btn-prev-step"
                data-prev="3" type="button">

                    <i class="ki-duotone ki-left me-2"></i>

                    Kembali

                </button>

            </div>

            <div class="col-9">

                <button class="btn-next-step" type="submit">

                    Simpan & Selesaikan Profil

                </button>

            </div>

        </div>

    </div>

</div>