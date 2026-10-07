@extends('layouts.dashboard-user')

@section('title', 'Edit Data Diri')

@section('content')

    <style>
        /* =========================================================
        THEME VARIABLES
        ========================================================= */

        :root,
        [data-bs-theme="light"] {
            --profile-bg: #ffffff;
            --profile-surface: #ffffff;
            --profile-surface-soft: #f8fafc;

            --profile-text: #182338;
            --profile-text-secondary: #64748b;
            --profile-text-muted: #94a3b8;

            --profile-border: #e2e8f0;
            --profile-border-soft: rgba(15, 23, 42, .07);

            --profile-input-bg: #f8fafc;
            --profile-input-border: #dce3eb;
            --profile-input-text: #182338;
            --profile-input-placeholder: #94a3b8;

            --profile-icon-bg: #f1f5f9;
            --profile-icon-border: #dce3eb;
            --profile-icon-color: #64748b;

            --profile-gold: #f6b000;
            --profile-gold-hover: #ffc21c;
            --profile-gold-text: #111827;
            --profile-gold-soft: rgba(246, 176, 0, .10);
            --profile-gold-border: rgba(246, 176, 0, .35);

            --profile-upload-bg: #f8fafc;
            --profile-upload-border: #d7dee8;
            --profile-upload-text: #64748b;

            --profile-chip-bg: #f1f5f9;
            --profile-chip-border: #dce3eb;
            --profile-chip-text: #64748b;

            --profile-selected-bg: #fffbf0;
            --profile-selected-border: #e8c86d;
            --profile-selected-item-bg: #fff3cf;

            --profile-note-bg: #f8fafc;

            --profile-danger: #ff6464;
            --profile-danger-hover: #e54848;

            --profile-shadow: 0 4px 18px rgba(15, 23, 42, .06);
        }


        [data-bs-theme="dark"] {
            --profile-bg: #11192d;
            --profile-surface: #11192d;
            --profile-surface-soft: #121d37;

            --profile-text: #ffffff;
            --profile-text-secondary: #8fa0bc;
            --profile-text-muted: #73819d;

            --profile-border: rgba(255, 255, 255, .07);
            --profile-border-soft: rgba(255, 255, 255, .05);

            --profile-input-bg: #1c2547;
            --profile-input-border: #273555;
            --profile-input-text: #ffffff;
            --profile-input-placeholder: #7e8da8;

            --profile-icon-bg: #1a223d;
            --profile-icon-border: #37415f;
            --profile-icon-color: #8fa0bc;

            --profile-gold: #f6b000;
            --profile-gold-hover: #ffc21c;
            --profile-gold-text: #111111;
            --profile-gold-soft: rgba(246, 176, 0, .12);
            --profile-gold-border: rgba(246, 176, 0, .35);

            --profile-upload-bg: #11192d;
            --profile-upload-border: #2f3d59;
            --profile-upload-text: #8fa0bc;

            --profile-chip-bg: #1c2748;
            --profile-chip-border: #324162;
            --profile-chip-text: #8fa0bc;

            --profile-selected-bg: #171822;
            --profile-selected-border: #6e5520;
            --profile-selected-item-bg: #3a2d1d;

            --profile-note-bg: #121d37;

            --profile-danger: #ff6464;
            --profile-danger-hover: #ff8b8b;

            --profile-shadow: 0 4px 18px rgba(0, 0, 0, .18);
        }


        /* =========================================================
        PROFILE FORM
        ========================================================= */

        .profile-form-card {
            max-width: 760px;
            margin: auto;
        }


        /* =========================================================
        FORM HEADER
        ========================================================= */

        .form-header {
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }


        .header-icon {
            width: 50px;
            height: 50px;

            border-radius: 16px;

            background: var(--profile-icon-bg);
            border: 1px solid var(--profile-icon-border);

            display: flex;
            justify-content: center;
            align-items: center;

            color: var(--profile-icon-color);

            flex-shrink: 0;
        }


        .step-label {
            color: var(--profile-text-muted);

            font-size: 9.5px !important;

            letter-spacing: 2px;
            font-weight: 700;
        }


        .step-title {
            color: var(--profile-text);

            font-size: 16px;
            font-weight: 700;
        }


        .step-description {
            color: var(--profile-text-muted);
            font-size: 10px;
        }


        /* =========================================================
        UPLOAD CARD
        ========================================================= */

        .upload-card {
            padding: 12px;

            border: 1px solid var(--profile-border);
            border-radius: 18px;

            background: var(--profile-surface);

            font-size: 11px;
        }


        .upload-photo {
            height: 180px;

            border: 2px dashed var(--profile-upload-border);
            border-radius: 18px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            cursor: pointer;

            color: var(--profile-upload-text);

            transition: .3s;
        }


        .upload-photo:hover {
            border-color: var(--profile-gold);
            color: var(--profile-gold);
        }


        .upload-info {
            color: var(--profile-text-muted);
            line-height: 2;
        }


        /* =========================================================
        FORM INPUT
        ========================================================= */

        .auto-input {
            background: var(--profile-input-bg);
            border: 1px solid var(--profile-input-border);

            color: var(--profile-input-text);

            height: 36px;
        }


        .auto-input::placeholder {
            color: var(--profile-input-placeholder);
        }


        textarea.auto-input {
            height: auto;
        }


        .auto-input:focus {
            background: var(--profile-input-bg);

            border-color: var(--profile-gold);

            color: var(--profile-input-text);

            box-shadow: none;
        }


        /* =========================================================
        INPUT ICON
        ========================================================= */

        .input-icon {
            position: relative;
        }


        .input-icon i {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--profile-input-placeholder);

            z-index: 2;
        }


        .input-icon input {
            padding-left: 45px;
        }


        /* =========================================================
        SELECT
        ========================================================= */

        .auto-input.form-select {
            background-color: var(--profile-input-bg);

            border: 1px solid var(--profile-input-border);

            color: var(--profile-input-text);

            height: 36px;
            font-size: 11px;
        }


        .auto-input.form-select:focus {
            border-color: var(--profile-gold);
            box-shadow: none;
        }


        .auto-input option {
            background: var(--profile-input-bg);
            color: var(--profile-input-text);
        }


        /* =========================================================
        GENDER
        ========================================================= */

        .gender-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }


        .gender-btn {
            height: 36px;

            border-radius: 12px;
            border: 1px solid var(--profile-border);

            background: transparent;

            color: var(--profile-text-secondary);

            transition: .25s;
        }


        .gender-btn:hover {
            border-color: var(--profile-gold);
            color: var(--profile-gold);
        }


        .gender-btn.active {
            background: var(--profile-gold);

            color: var(--profile-gold-text);

            border-color: var(--profile-gold);
        }


        /* =========================================================
        WIZARD FOOTER
        ========================================================= */

        .wizard-footer {
            max-width: 760px;
            margin: 40px auto 0;
        }


        .btn-next-step {
            width: 100%;
            height: 36px;

            border: none;
            border-radius: 16px;

            background: var(--profile-gold);

            color: var(--profile-gold-text);

            font-weight: 700;
            font-size: 12px;

            transition: .25s;
        }


        .btn-next-step:hover {
            background: var(--profile-gold-hover);
            color: var(--profile-gold-text);

            transform: translateY(-1px);
        }


        /* =========================================================
        SKILL TOP
        ========================================================= */

        .skill-top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;

            color: var(--profile-text-secondary);

            font-size: 12px;
        }


        .skill-top span {
            color: var(--profile-gold);
            font-weight: 700;
        }


        .skill-top a {
            color: var(--profile-danger);

            text-decoration: none;

            font-weight: 600;
        }


        .skill-top a:hover {
            color: var(--profile-danger-hover);
        }


        /* =========================================================
        SKILL LIST
        ========================================================= */

        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }


        /* =========================================================
        SKILL CHIP
        ========================================================= */

        .skill-chip {
            border: none;

            padding: 6px 11px;

            border-radius: 40px;

            background: var(--profile-chip-bg);

            border: 1px solid var(--profile-chip-border);

            color: var(--profile-chip-text);

            font-weight: 600;

            transition: .25s;

            font-size: 11px;
        }


        .skill-chip:hover {
            border-color: var(--profile-gold);
            color: var(--profile-gold);
        }


        .skill-chip.active {
            background: var(--profile-gold);

            color: var(--profile-gold-text);

            border-color: var(--profile-gold);
        }


        .skill-chip.active::before {
            content: "✓ ";
        }


        /* =========================================================
        SELECTED SKILL
        ========================================================= */

        .selected-card {
            background: var(--profile-selected-bg);

            border: 1px solid var(--profile-selected-border);

            border-radius: 22px;

            padding: 25px;

            font-size: 11px;
        }


        .selected-card h5 {
            color: var(--profile-gold);

            margin-bottom: 20px;
        }


        .selected-skill {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }


        .selected-item {
            background: var(--profile-selected-item-bg);

            color: var(--profile-gold);

            padding: 6px 11px;

            border-radius: 30px;

            cursor: pointer;

            font-size: 11px;
        }


        .selected-item:hover {
            filter: brightness(.95);
        }


        /* =========================================================
        SKILL NOTE
        ========================================================= */

        .skill-note {
            background: var(--profile-note-bg);

            border: 1px solid var(--profile-border);

            border-radius: 22px;

            padding: 25px;

            font-size: 11px;
        }


        .skill-note h5 {
            color: var(--profile-text);
        }


        .skill-note p {
            color: var(--profile-text-secondary);

            margin: 0;
        }


        /* =========================================================
        SELECTED COUNT
        ========================================================= */

        .selected-count {
            color: var(--profile-text-secondary);
            font-size: 12px;
        }


        .selected-count span {
            color: var(--profile-gold);
            font-weight: 700;
        }


        /* =========================================================
        PLACEMENT
        ========================================================= */

        .clear-placement {
            color: var(--profile-danger);

            font-weight: 600;

            text-decoration: none;
        }


        .clear-placement:hover {
            color: var(--profile-danger-hover);
        }


        .placement-list {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }


        .placement-item,
        .placement-site-item {
            border: none;

            background: var(--profile-chip-bg);

            border: 1px solid var(--profile-chip-border);

            color: var(--profile-chip-text);

            padding: 6px 11px;

            border-radius: 50px;

            transition: .25s;

            font-weight: 600;

            font-size: 11px;
        }


        .placement-item:hover,
        .placement-site-item:hover {
            background: var(--profile-surface-soft);

            border-color: var(--profile-gold);

            color: var(--profile-gold);
        }


        .placement-item.active,
        .placement-site-item.active {
            background: var(--profile-gold);

            color: var(--profile-gold-text);

            border-color: var(--profile-gold);
        }


        /* =========================================================
        PLACEMENT SELECTED
        ========================================================= */

        .placement-selected-box {
            background: var(--profile-selected-bg);

            border: 1px solid var(--profile-selected-border);

            border-radius: 22px;

            padding: 24px;

            font-size: 11px;
        }


        .placement-selected-box h5 {
            color: var(--profile-gold);

            margin-bottom: 18px;
        }


        .placement-selected-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }


        .selected-placement {
            background: var(--profile-selected-item-bg);

            color: var(--profile-gold);

            border-radius: 40px;

            padding: 6px 11px;

            font-size: 11px;
        }


        /* =========================================================
        PLACEMENT PREVIEW
        ========================================================= */

        .placement-preview {
            border: 1px solid var(--profile-border);

            border-radius: 22px;

            background: var(--profile-note-bg);

            padding: 28px;
        }


        /* =========================================================
        BACK BUTTON
        ========================================================= */

        .btn-back-step {
            width: 180px;
            height: 46px;

            border-radius: 16px;

            border: 1px solid var(--profile-border);

            background: transparent;

            color: var(--profile-text-secondary);

            transition: .25s;
        }


        .btn-back-step:hover {
            border-color: var(--profile-gold);

            color: var(--profile-gold);

            background: var(--profile-gold-soft);
        }


        /* =========================================================
        VALIDATION
        ========================================================= */

        .is-invalid {
            border-color: #dc3545 !important;
        }


        /* =========================================================
        TABLET
        ========================================================= */

        @media (max-width: 991px) {

            .profile-form-card {
                max-width: 100%;
            }

            .upload-card {
                padding: 15px;
            }

            .upload-card .row {
                row-gap: 20px;
            }

            .upload-photo {
                max-width: 220px;
                margin: auto;
            }
        }


        /* =========================================================
        MOBILE
        ========================================================= */

        @media (max-width: 768px) {

            .profile-form-card {
                width: 100%;
            }


            /* Header */

            .form-header {
                gap: 12px;

                align-items: flex-start;

                margin-bottom: 25px !important;
            }


            .header-icon {
                width: 42px;
                height: 42px;

                border-radius: 12px;

                flex-shrink: 0;
            }


            .header-icon i {
                font-size: 20px !important;
            }


            .step-label {
                font-size: 8px !important;
                letter-spacing: 1.5px;
            }


            .step-title {
                font-size: 18px;
                margin-bottom: 4px;
            }


            .step-description {
                font-size: 11px;
                line-height: 1.6;
            }


            /* Upload */

            .upload-card {
                padding: 15px;
            }


            .upload-photo {
                width: 170px;
                height: 170px;

                margin: 0 auto 15px;
            }


            .upload-photo i {
                font-size: 36px !important;
            }


            .upload-card h5 {
                font-size: 13px;
                text-align: center;
            }


            .upload-card p {
                text-align: center;
                font-size: 11px;
            }


            .upload-info {
                font-size: 10px;
                margin-bottom: 0;
            }


            /* Form */

            .form-label {
                font-size: 11px;
                margin-bottom: 6px;
            }


            .auto-input {
                height: 40px;

                font-size: 12px;

                border-radius: 10px;
            }


            textarea.auto-input {
                min-height: 90px;
            }


            .input-icon input {
                padding-left: 42px;
            }


            .input-icon i {
                left: 13px;
                font-size: 15px !important;
            }


            /* Gender */

            .gender-group {
                grid-template-columns: 1fr;
                gap: 10px;
            }


            .gender-btn {
                height: 40px;
                font-size: 12px;
            }


            /* Button */

            .wizard-footer {
                margin-top: 25px;
            }


            .btn-next-step {
                height: 44px;

                border-radius: 12px;

                font-size: 13px;
            }


            /* Skill */

            .skill-top {
                flex-direction: column;

                align-items: flex-start;

                gap: 10px;
            }


            .skill-chip {
                width: 100%;
                text-align: center;
            }


            .btn-back-step {
                width: 120px;
            }


            /* Step 2 */

            #step2 .profile-form-card {
                padding: 0;
            }


            #step2 .wizard-footer .row {
                row-gap: 12px;
            }


            #step2 .btn-next-step,
            #step2 .btn-profile-secondary {
                height: 42px;
                font-size: 13px;
            }
        }


        /* =========================================================
        EXTRA SMALL DEVICE
        ========================================================= */

        @media (max-width: 480px) {

            .upload-photo {
                width: 140px;
                height: 140px;
            }


            .step-title {
                font-size: 16px;
            }


            .step-description {
                font-size: 10px;
            }


            .auto-input {
                font-size: 11px;
            }


            .btn-next-step {
                font-size: 12px;
            }
        }
    </style>

    <div class="container-xxl">

        @include('dashboard-user.profile.partials.edit.breadcrumb')

        <div class="row g-4">

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-9">
                @include('dashboard-user.profile.partials.edit.stepper-header')
                <br>
                <div class="card p-6">
                    <form method="POST" action="{{ route('dashboard-user.profile.update-personal-data', $data->uuid) }}" enctype="multipart/form-data">
                        @csrf
                        @include('dashboard-user.profile.partials.edit.step-1')
                        @include('dashboard-user.profile.partials.edit.step-2')
                        @include('dashboard-user.profile.partials.edit.step-3')
                        @include('dashboard-user.profile.partials.edit.step-4')
                    </form>
                </div>
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-3">

            </div>

        </div>
    </div>

@endsection

@section('js')
    {{-- INDEX --}}
    <script>
        $(function(){

            let currentStep = 1;
            const totalStep = 4;

            showStep(currentStep);

            //========================
            // NEXT
            //========================

            $(document).on("click",".btn-next-step",function(){

                let next = $(this).data("next");

                if(next){

                    currentStep = next;

                    showStep(currentStep);

                    $("html,body").animate({
                        scrollTop:0
                    },300);

                }

            });

            //========================
            // PREVIOUS
            //========================

            $(document).on("click",".btn-prev-step",function(){

                currentStep = $(this).data("prev");

                showStep(currentStep);

                $("html,body").animate({
                    scrollTop:0
                },300);

            });

            //========================
            // SHOW STEP
            //========================

            function showStep(step){

                //---------------------------------
                // Page
                //---------------------------------

                $(".wizard-page")
                    .removeClass("active")
                    .hide();

                $("#step"+step)
                    .fadeIn(200)
                    .addClass("active");

                //---------------------------------
                // Header
                //---------------------------------

                $(".step-item").removeClass("active done");

                $(".step-item").each(function(){

                    let s = $(this).data("step");

                    if(s < step){

                        $(this).addClass("done");

                    }
                    else if(s == step){

                        $(this).addClass("active");

                    }

                });

                //---------------------------------
                // Progress
                //---------------------------------

                let percent = (step / totalStep) * 100;

                $(".step-percent").text(Math.round(percent)+"%");

                $(".stepper-progress-bar").css(
                    "width",
                    percent+"%"
                );

            }

        });
    </script>

    {{-- STEP 1 --}}
    <script>
        $(function(){

            $("#photoInput").on("change",function(){

                let file=this.files[0];

                if(!file){

                    return;

                }

                let ext=file.type;

                if(ext!="image/jpeg" && ext!="image/png"){

                    Swal.fire({

                        icon:"error",

                        title:"Format tidak didukung",

                        text:"Gunakan JPG atau PNG."

                    });

                    $(this).val("");

                    return;

                }

                if(file.size>5*1024*1024){

                    Swal.fire({

                        icon:"error",

                        title:"Ukuran terlalu besar",

                        text:"Maksimal 5 MB."

                    });

                    $(this).val("");

                    return;

                }

                let reader=new FileReader();

                reader.onload=function(e){

                    $("#previewImage").attr("src",e.target.result);

                    $(".upload-placeholder").addClass("d-none");

                    $(".upload-preview").removeClass("d-none");

                    $(".upload-file-info").removeClass("d-none");

                }

                reader.readAsDataURL(file);

                $("#fileName").text(file.name);

                $("#fileSize").text((file.size/1024/1024).toFixed(2)+" MB");

            });

        });
    </script>

    {{-- LARAVOLT --}}
    <script>
        $(document).ready(function(){

            function loadCities(province, selected=""){

                $("#city")
                    .prop("disabled", true)
                    .html('<option>Memuat...</option>');

                $.get("/location/cities/"+province,function(res){

                    let html='<option value="">Pilih Kota/Kabupaten</option>';

                    $.each(res,function(i,item){

                        html+=`
                            <option
                                value="${item.code}"
                                ${selected==item.code?'selected':''}>
                                ${item.name}
                            </option>
                        `;

                    });

                    $("#city")
                        .html(html)
                        .prop("disabled", false);

                });

            }


            function loadDistricts(city, selected=""){

                $("#district")
                    .prop("disabled", true)
                    .html('<option>Memuat...</option>');

                $.get("/location/districts/"+city,function(res){

                    let html='<option value="">Pilih Kecamatan</option>';

                    $.each(res,function(i,item){

                        html+=`
                            <option
                                value="${item.code}"
                                ${selected==item.code?'selected':''}>
                                ${item.name}
                            </option>
                        `;

                    });

                    $("#district")
                        .html(html)
                        .prop("disabled", false);

                });

            }


            function loadVillages(district, selected=""){

                $("#village")
                    .prop("disabled", true)
                    .html('<option>Memuat...</option>');

                $.get("/location/villages/"+district,function(res){

                    let html='<option value="">Pilih Kelurahan</option>';

                    $.each(res,function(i,item){

                        html+=`
                            <option
                                value="${item.code}"
                                ${selected==item.code?'selected':''}>
                                ${item.name}
                            </option>
                        `;

                    });

                    $("#village")
                        .html(html)
                        .prop("disabled", false);

                });

            }


            $("#province").change(function(){

                let province = $(this).val();

                $("#city").prop("disabled", true);
                $("#district").prop("disabled", true);
                $("#village").prop("disabled", true);

                $("#district").html(
                    '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>'
                );

                $("#village").html(
                    '<option value="">Pilih Kecamatan terlebih dahulu</option>'
                );

                if(province==""){

                    $("#city").html(
                        '<option value="">Pilih Provinsi terlebih dahulu</option>'
                    );

                    return;
                }

                loadCities(province);

            });


            $("#city").change(function(){

                let city=$(this).val();

                $("#district").prop("disabled",true);
                $("#village").prop("disabled",true);

                $("#village").html(
                    '<option value="">Pilih Kecamatan terlebih dahulu</option>'
                );

                if(city==""){

                    $("#district").html(
                        '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>'
                    );

                    return;
                }

                loadDistricts(city);

            });


            $("#district").change(function(){

                let district=$(this).val();

                $("#village").prop("disabled",true);

                if(district==""){

                    $("#village").html(
                        '<option value="">Pilih Kecamatan terlebih dahulu</option>'
                    );

                    return;
                }

                loadVillages(district);

            });

            let province="{{ old('province', $province->code ?? '') }}";
            let city="{{ old('city', $city->code ?? '') }}";
            let district="{{ old('district', $district->code ?? '') }}";
            let village="{{ old('village', $village->code ?? '') }}";

            if(province!=""){
                loadCities(province,city);

                setTimeout(function(){

                    loadDistricts(city,district);

                },300);

                setTimeout(function(){

                    loadVillages(district,village);

                },600);

            }
        });

        $("#sioFileInput").on("change", function () {

            let file = this.files[0];

            if (!file) return;

            let size = (file.size / 1024 / 1024).toFixed(2);

            $("#sioFileName").text(file.name);

            $("#sioFileSize").text(size + " MB");

            $("#sioFileInfo").removeClass("d-none");

        });
    </script>


@endsection