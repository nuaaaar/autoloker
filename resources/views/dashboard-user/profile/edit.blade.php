@extends('layouts.dashboard-user')

@section('title', 'Edit Data Diri')

@section('content')

    <style>
        .profile-form-card{

            max-width:760px;

            margin:auto;

        }

        .form-header{

            display:flex;

            gap: 18px;

            align-items:flex-start;

        }

        .header-icon{

            width:50px;

            height:50px;

            border-radius:16px;

            background:#1a223d;

            border:1px solid #37415f;

            display:flex;

            justify-content:center;

            align-items:center;

        }

        .step-label{

            color:#8f9ab5;

            font-size: 9.5px !important;

            letter-spacing:2px;

            font-weight:700;

        }

        .step-title{

            color:#fff;

            font-size: 16px;

            font-weight:700;

        }

        .step-description{

            color:#8f9ab5;

            font-size:10px;

        }

        .upload-card{

            padding: 12px;

            border:1px solid #283652;

            border-radius:18px;

            background:#11192d;

            font-size: 11px;

        }

        .upload-photo{

            height:180px;

            border:2px dashed #2f3d59;

            border-radius:18px;

            display:flex;

            flex-direction:column;

            justify-content:center;

            align-items:center;

            cursor:pointer;

            color:#8fa0bc;

            transition:.3s;

        }

        .upload-photo:hover{

            border-color:#f6b000;

            color:#f6b000;

        }

        .upload-info{

            color:#8f9ab5;

            line-height:2;

        }

        .auto-input{

            background:#1c2547;

            border:1px solid #273555;

            color:white;

            height: 36px;

        }

        textarea.auto-input{

            height:auto;

        }

        .auto-input:focus{

            background:#1c2547;

            border-color:#f6b000;

            color:white;

            box-shadow:none;

        }

        .input-icon{

            position:relative;

        }

        .input-icon i{

            position:absolute;

            left:15px;

            top:50%;

            transform:translateY(-50%);

            color:#7e8da8;

        }

        .input-icon input{

            padding-left: 45px;

        }

        .gender-group{

            display:grid;

            grid-template-columns:1fr 1fr;

            gap:15px;

        }

        .gender-btn{

            height: 36px;

            border-radius:12px;

            border:1px solid #2c3954;

            background:transparent;

            color:#8fa0bc;

            transition:.25s;

        }

        .gender-btn.active{

            background:#f6b000;

            color:#111;

            border-color:#f6b000;

        }

        .wizard-footer{

            max-width:760px;

            margin:40px auto 0;

        }

        .btn-next-step{

            width:100%;

            height: 36px;

            border:none;

            border-radius:16px;

            background:#f6b000;

            color:#111;

            font-weight:700;

            font-size: 12px;

        }

        /* ==========================================================
        RESPONSIVE TABLET
        ========================================================== */

        @media (max-width:991px){

            .profile-form-card{

                max-width:100%;

            }

            .upload-card{

                padding:15px;

            }

            .upload-card .row{

                row-gap:20px;

            }

            .upload-photo{

                max-width:220px;

                margin:auto;

            }

        }


        /* ==========================================================
        RESPONSIVE MOBILE
        ========================================================== */

        @media (max-width:768px){

            /* Card */

            .profile-form-card{

                width:100%;

            }

            /* Header */

            .form-header{

                gap:12px;

                align-items:flex-start;

                margin-bottom:25px !important;

            }

            .header-icon{

                width:42px;

                height:42px;

                border-radius:12px;

                flex-shrink:0;

            }

            .header-icon i{

                font-size:20px !important;

            }

            .step-label{

                font-size:8px !important;

                letter-spacing:1.5px;

            }

            .step-title{

                font-size:18px;

                margin-bottom:4px;

            }

            .step-description{

                font-size:11px;

                line-height:1.6;

            }

            /* Upload */

            .upload-card{

                padding:15px;

            }

            .upload-photo{

                width:170px;

                height:170px;

                margin:0 auto 15px;

            }

            .upload-photo i{

                font-size:36px !important;

            }

            .upload-card h5{

                font-size:13px;

                text-align:center;

            }

            .upload-card p{

                text-align:center;

                font-size:11px;

            }

            .upload-info{

                font-size:10px;

                margin-bottom:0;

            }

            /* Form */

            .form-label{

                font-size:11px;

                margin-bottom:6px;

            }

            .auto-input{

                height:40px;

                font-size:12px;

                border-radius:10px;

            }

            textarea.auto-input{

                min-height:90px;

            }

            .input-icon input{

                padding-left:42px;

            }

            .input-icon i{

                left:13px;

                font-size:15px !important;

            }

            /* Gender */

            .gender-group{

                grid-template-columns:1fr;

                gap:10px;

            }

            .gender-btn{

                height:40px;

                font-size:12px;

            }

            /* Button */

            .wizard-footer{

                margin-top:25px;

            }

            .btn-next-step{

                height:44px;

                border-radius:12px;

                font-size:13px;

            }

        }


        /* ==========================================================
        EXTRA SMALL DEVICE
        ========================================================== */

        @media (max-width:480px){

            .upload-photo{

                width:140px;

                height:140px;

            }

            .step-title{

                font-size:16px;

            }

            .step-description{

                font-size:10px;

            }

            .auto-input{

                font-size:11px;

            }

            .btn-next-step{

                font-size:12px;

            }

        }
    </style>

    <style>
        /* Select */

        .auto-input.form-select{

            background:#1c2547;

            border:1px solid #273555;

            color:#fff;

            height:36px;

            font-size: 11px;

        }

        .auto-input.form-select:focus{

            border-color:#f6b000;

            box-shadow:none;

        }

        /* Option */

        .auto-input option{

            background:#16213a;

            color:#fff;

        }

        /* Responsive */

        @media(max-width:768px){

            #step2 .profile-form-card{

                padding:0;

            }

            #step2 .wizard-footer .row{

                row-gap:12px;

            }

            #step2 .btn-next-step,
            #step2 .btn-profile-secondary{

                height:42px;

                font-size:13px;

            }

        }
    </style>

    <style>
        /* TOP */

        .skill-top{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:25px;

            color:#92a0bd;

            font-size: 12px;

        }

        .skill-top span{

            color:#f6b000;

            font-weight:700;

        }

        .skill-top a{

            color:#ff6666;

            text-decoration:none;

            font-weight:600;

        }

        /* LIST */

        .skill-list{

            display:flex;

            flex-wrap:wrap;

            gap:14px;

        }

        /* CHIP */

        .skill-chip{

            border:none;

            padding: 6px 11px;

            border-radius:40px;

            background:#1c2748;

            border:1px solid #324162;

            color:#8fa0bc;

            font-weight:600;

            transition:.25s;

            font-size: 11px;

        }

        .skill-chip:hover{

            border-color:#f6b000;

        }

        .skill-chip.active{

            background:#f6b000;

            color:#111;

            border-color:#f6b000;

        }

        .skill-chip.active::before{

            content:"✓ ";

        }

        /* SELECTED */

        .selected-card{

            background:#171822;

            border:1px solid #6e5520;

            border-radius:22px;

            padding:25px;

            font-size: 11px;

        }

        .selected-card h5{

            color:#f6b000;

            margin-bottom:20px;

        }

        .selected-skill{

            display:flex;

            flex-wrap:wrap;

            gap:12px;

        }

        .selected-item{

            background:#3a2d1d;

            color:#f6b000;

            padding: 6px 11px;

            border-radius:30px;

            cursor:pointer;

            font-size: 11px;

        }

        .selected-item:hover{

            background:#553c17;

        }

        /* NOTE */

        .skill-note{

            background:#121d37;

            border:1px solid #273555;

            border-radius:22px;

            padding:25px;

            font-size: 11px;

        }

        .skill-note h5{

            color:white;

        }

        .skill-note p{

            color:#8fa0bc;

            margin:0;

        }

        /* FOOTER */

        .btn-back-step{

            width:180px;

            height:46px;

            border-radius:16px;

            border:1px solid #2b3852;

            background:transparent;

            color:#8fa0bc;

        }

        .btn-back-step:hover{

            border-color:#f6b000;

            color:#f6b000;

        }

        /* MOBILE */

        @media(max-width:768px){

        .skill-top{

        flex-direction:column;

        align-items:flex-start;

        gap:10px;

        }

        .skill-chip{

        width:100%;

        text-align:center;

        }

        .btn-back-step{

        width:120px;

        }

        }
    </style>

    <style>
        .selected-count{
            color:#95a2bf;
            font-size: 12px;
        }

        .selected-count span{
            color:#f6b000;
            font-weight:700;
        }

        .clear-placement{
            color:#ff6464;
            font-weight:600;
            text-decoration:none;
        }

        .clear-placement:hover{
            color:#ff8b8b;
        }

        .placement-list{
            display:flex;
            flex-wrap:wrap;
            gap:14px;
        }

        .placement-item{

            border:none;

            background:#1d274b;

            border:1px solid #334165;

            color:#9cadc7;

            padding:6px 11px;

            border-radius:50px;

            transition:.25s;

            font-weight:600;

            font-size: 11px;
        }

        .placement-item:hover{

            background:#28345d;

        }

        .placement-item.active{

            background:#f6b000;

            color:#111;

            border-color:#f6b000;

        }

        .placement-selected-box{

            background:#181926;

            border:1px solid #6a4c17;

            border-radius:22px;

            padding:24px;

            font-size: 11px;

        }

        .placement-selected-box h5{

            color:#f6b000;

            margin-bottom:18px;

        }

        .placement-selected-list{

            display:flex;

            flex-wrap:wrap;

            gap:10px;

        }

        .selected-placement{

            background:#43321d;

            color:#f6b000;

            border-radius:40px;

            padding:6px 11px;

            font-size: 11px;

        }

        .placement-preview{

            border:1px solid #2d3956;

            border-radius: 22px;

            background:#131d35;

            padding: 28px;

        }

        .placement-site-item{

            border:none;

            background:#1d274b;

            border:1px solid #334165;

            color:#9cadc7;

            padding:6px 11px;

            border-radius:50px;

            transition:.25s;

            font-weight:600;

            font-size: 11px;
        }

        .placement-site-item:hover{

            background:#28345d;

        }

        .placement-site-item.active{

            background:#f6b000;

            color:#111;

            border-color:#f6b000;

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