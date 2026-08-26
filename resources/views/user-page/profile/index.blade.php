@extends('layouts.user-page')

@section('title', 'Profil')

@section('content')
    <div class="container-xxl">
        @include('user-page.profile.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                @if($profile_progress['progress'] < 100)
                    @include('user-page.profile.partials.alert-complete-data')
                @endif
                @include('user-page.profile.partials.header')
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $('.certificate-menu').on('show.bs.dropdown', function(){

            $('.certificate-section').css({
                paddingBottom:'220px',
                transition:'all .2s'
            });

        });

        $('.certificate-menu').on('hide.bs.dropdown', function(){

            $('.certificate-section').css({
                paddingBottom:'0'
            });

        });

        $(".btn-add-badge").on("click", function () {
            console.log(1);
            $("#certificateModal").modal("show");

        });

        $("#certificateFile").change(function(){

            let file = this.files[0];

            if(!file) return;

            let size;

            if(file.size >= 1024*1024){

                size = (file.size/1024/1024).toFixed(2)+" MB";

            }else{

                size = (file.size/1024).toFixed(1)+" KB";

            }

            $("#uploadArea").addClass("has-file");

            $(".upload-icon i")
                .removeClass("ki-file-up")
                .addClass("ki-check-circle text-success");

            $(".upload-title").text(file.name);

            $(".upload-subtitle").text(size);

        });

        $("#btnSaveCertificate").click(function(){

            let form=document.getElementById("formCertificate");

            if(!form.checkValidity()){
                form.reportValidity();
                return;
            }

            let uuid=$("#certificateUuid").val();

            let formData=new FormData(form);

            let url;
            let method;

            if(uuid==""){

                url="{{ route('user-page.profile.certificate.store') }}";
                method="POST";

            }else{

                url="/user-page/profile/certificate/"+uuid;
                method="POST";

                formData.append("_method","PUT");

            }

            $.ajax({

                url:url,
                type:method,
                data:formData,
                processData:false,
                contentType:false,

                beforeSend:function(){

                    $("#btnSaveCertificate")
                        .prop("disabled",true);

                },

                success:function(res){

                    $("#certificateModal").modal("hide");

                    if(uuid==""){

                        addCertificateCard(res.data);

                    }else{

                        updateCertificateCard(res.data);

                    }

                    Swal.fire({

                        icon:"success",
                        title:"Berhasil",
                        text:res.message,
                        timer:1500,
                        showConfirmButton:false

                    });

                    form.reset();

                    $("#certificateUuid").val("");

                    $("#certificateModalTitle").text("Tambah Sertifikasi");

                    $("#certificateModalSubtitle").text("Lengkapi informasi sertifikat");

                    $("#btnSaveCertificate").text("Tambahkan");

                    updateProfileBadge(res.data);

                },

                complete:function(){

                    $("#btnSaveCertificate")
                        .prop("disabled",false);

                }

            });

        });

        function resetUploadArea(){

            $("#certificateFile").val("");

            $("#uploadArea").removeClass("has-file");

            $(".upload-icon i")
                .removeClass("ki-check-circle text-success")
                .addClass("ki-file-up");

            $(".upload-title")
                .text("Drag & Drop atau klik untuk memilih");

            $(".upload-subtitle")
                .text("PDF, JPG, PNG • Maks 10 MB");

        }

        function addCertificateCard(data){

            const today = new Date();

            const publishDate = new Date(data.publish_date);
            const expiredDate = new Date(data.expired_date);

            const isActive = today >= publishDate && today <= expiredDate;

            const status = `
                <span class="certificate-status ${isActive ? 'active' : 'expired'}">
                    ${isActive ? 'Aktif' : 'Kadaluarsa'}
                </span>
            `;

            const badge = data.is_badge == 1
                ? `<span class="certificate-badge">★ BADGE</span>`
                : '';

            const iconClass = data.is_badge == 1 ? '' : 'empty';

            const fileUrl = data.file
                ? `/storage/${data.file}`
                : 'javascript:;';

            const publish = publishDate.toLocaleDateString('id-ID',{
                day:'2-digit',
                month:'long',
                year:'numeric'
            });

            const expired = expiredDate.toLocaleDateString('id-ID',{
                day:'2-digit',
                month:'long',
                year:'numeric'
            });

            let badgeMenu = data.is_badge == 1
            ? `
                Matikan Badge Profil
            `
            : `
                Jadikan Badge Profil
            `;

        let badgeIcon = data.is_badge == 1
            ? 'text-warning'
            : '';

            let html = `
            <div class="certificate-card" 
            data-uuid="${data.uuid}"
            data-title="${data.title}"
            data-publisher="${data.publisher}"
            data-category="${data.category}"
            data-publish="${data.publish_date}"
            data-expired="${data.expired_date}"
            data-number="${data.certificate_number}"
            data-file="${data.file}"
            >

                <div class="certificate-icon ${iconClass}">

                    <i class="ki-duotone ki-star"></i>

                </div>

                <div class="certificate-content">

                    <div class="certificate-top">

                        <div>

                            <div class="certificate-title">

                                ${data.title}

                                ${badge}

                            </div>

                            <div class="certificate-instansi">

                                ${data.publisher}

                            </div>

                        </div>

                        ${status}

                    </div>

                    <div class="certificate-detail">

                        <span class="certificate-number">

                            ${data.certificate_number}

                        </span>

                        <span class="certificate-date">

                            ${publish}
                            →
                            <span class="text-danger">

                                ${expired}

                            </span>

                        </span>

                    </div>

                    <span class="certificate-category">

                        ${data.category}

                    </span>

                </div>

                <div class="dropup">

                    <button
                        class="certificate-menu"
                        type="button"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="static">

                        <i class="ki-duotone ki-dots-horizontal fs-4"></i>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end certificate-dropdown">

                        <li>

                            <a
                                class="dropdown-item btnBadge"
                                href="javascript:;"
                                data-uuid="${data.uuid}"
                                data-badge="${data.is_badge}"
                                >

                                <i class="ki-duotone ki-star ${badgeIcon} me-3"></i>

                                <span>${badgeMenu}</span>

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item btnEdit"
                                href="javascript:;"
                                data-uuid="${data.uuid}">

                                <i class="ki-duotone ki-notepad-edit me-3"></i>

                                Edit

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item" href="${data.file}" target="_blank">

                                <i class="ki-duotone ki-file-sheet me-3"></i>

                                Lihat Dokumen

                            </a>

                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>

                            <a class="dropdown-item text-danger btnDelete"
                                href="javascript:;"
                                data-uuid="${data.uuid}">

                                <i class="ki-duotone ki-trash text-danger me-3"></i>

                                Hapus

                            </a>

                        </li>

                    </ul>

                </div>

            </div>`;

            $(".certificate-body").prepend(html);

            updateCertificateCount();
        }

        // buka modal
        $(document).on("click",".btnDelete",function(){

            let uuid = $(this).data("uuid");

            $("#deleteCertificateUuid").val(uuid);

            $("#deleteCertificateModal").modal("show");

        });

        $("#btnDeleteCertificate").click(function(){

            let btn = $(this);

            let uuid = $("#deleteCertificateUuid").val();

            $.ajax({

                url: "/user-page/profile/certificate/" + uuid,

                type: "DELETE",

                data:{
                    _token:$('meta[name="csrf-token"]').attr("content")
                },

                beforeSend:function(){

                    btn.prop("disabled",true)
                    .html('<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...');

                },

                success:function(res){

                    $("#deleteCertificateModal").modal("hide");

                    $(".certificate-card[data-uuid='"+uuid+"']")
                        .fadeOut(250,function(){

                            $(this).remove();

                            updateCertificateCount();

                        });

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message,

                        timer:1800,

                        showConfirmButton:false

                    });

                    updateProfileBadge(res.data);

                },

                error:function(){

                    Swal.fire({

                        icon:"error",

                        title:"Gagal",

                        text:"Gagal menghapus sertifikat."

                    });

                },

                complete:function(){

                    btn.prop("disabled",false)
                    .html("Hapus");

                }

            });

        });

        function updateCertificateCount(){

            let total = $(".certificate-card").length;

            $("#certificateCount").text(total);

        }

        $(document).on("click",".btnBadge",function(){

            let uuid=$(this).data("uuid");
            let badge = $(this).data('badge');

            $.ajax({

                url:"/user-page/profile/certificate/"+uuid+"/badge",

                type:"PATCH",

                data:{
                    _token:$("meta[name=csrf-token]").attr("content")
                },

                success:function(res){

                    $(".certificate-card").each(function(){

                        $(this)
                            .find(".certificate-badge")
                            .remove();

                        $(this)
                            .find(".certificate-icon")
                            .addClass("empty");

                    });

                    $(".btnBadge").each(function(){

                        $(this)
                            .find("span")
                            .text("Jadikan Badge Profil");

                        $(this)
                            .find("i")
                            .removeClass("text-warning");

                    });

                    if(res.is_badge){

                        let card=$(".certificate-card[data-uuid='"+res.uuid+"']");

                        card.find(".certificate-title").append(`
                            <span class="certificate-badge">
                                ★ BADGE
                            </span>
                        `);

                        card.find(".certificate-icon")
                            .removeClass("empty");

                        let btn=$(".btnBadge[data-uuid='"+res.uuid+"']");

                        btn.find("span")
                            .text("Nonaktifkan Badge Profil");

                        btn.find("i")
                            .addClass("text-warning");

                        card.find('.btnBadge').attr('data-badge', res.is_badge);
                        card.find(".certificate-icon").removeClass("empty");
                    }

                    updateProfileBadge(res.data);

                }

            });


        });

        $(document).on("click",".btnCreate",function(){

            $("#certificateUuid").val("");

            if ($("#certificateModalTitle").text().trim() != "Tambah Sertifikasi") {
                $("#formCertificate")[0].reset();
            }

            $("#certificateModalTitle").text("Tambah Sertifikasi");

            $("#certificateModalSubtitle").text("Lengkapi informasi sertifikat");

            $("#btnSaveCertificate").text("Tambahkan");
        });

        $(document).on("click",".btnEdit",function(){

            let card=$(this).closest(".certificate-card");

            $("#certificateUuid").val($(this).data("uuid"));

            $("#certificateModalTitle").text("Edit Sertifikasi");
            $("#certificateModalSubtitle").text("Perbarui informasi sertifikat");

            $("#btnSaveCertificate").text("Simpan Perubahan");

            $("input[name=title]").val(card.find(".certificate-title").clone().children().remove().end().text().trim());

            $("input[name=publisher]").val(
                card.find(".certificate-instansi").text().trim()
            );

            $("input[name=certificate_number]").val(
                card.find(".certificate-number").text().trim()
            );

            $("select[name=category]").val(
                card.find(".certificate-category").text().trim()
            );

            let date=card.find(".certificate-date").text().split("→");

            $("input[name=publish_date]").val(moment(date[0].trim(),"DD MMMM YYYY").format("YYYY-MM-DD"));

            $("input[name=expired_date]").val(moment(date[1].trim(),"DD MMMM YYYY").format("YYYY-MM-DD"));

            $("#formCertificate").attr(
                "action",
                "/user-page/profile/certificate/"+$(this).data("uuid")
            );

            $("#certificateModal").modal("show");

        });

        function updateCertificateCard(data){

            let card=$(`.certificate-card[data-uuid="${data.uuid}"]`);

            let expired=new Date(data.expired_date)<new Date();

            card.find(".certificate-title").html(
                data.title+
                (
                    data.is_badge==1
                    ?'<span class="certificate-badge">★ BADGE</span>'
                    :''
                )
            );

            card.find(".certificate-instansi").text(data.publisher);

            card.find(".certificate-number").text(data.certificate_number);

            card.find(".certificate-category").text(data.category);

            card.find(".certificate-date").html(
                data.publish_date+
                " → <span class='"+(expired?"text-danger":"text-success")+"'>"+
                data.expired_date+
                "</span>"
            );

            card.find(".certificate-status")
                .removeClass("active expired")
                .addClass(expired?"expired":"active")
                .text(expired?"Kadaluarsa":"Aktif");

            let icon=card.find(".certificate-icon");

            if(data.is_badge){

                icon.removeClass("empty");

            }else{

                icon.addClass("empty");

            }

        }

        function updateProfileBadge(data)
        {
            console.log(data);
            if(data && data.is_badge == 1){

                $("#profileBadgeContainer").html(`
                    <span class="badge-license">
                        <i class="ki-duotone ki-shield-tick me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        ${data.title}
                    </span>
                `);

            }else{

                $("#profileBadgeContainer").html("");

            }
        }
    </script>

    {{-- HISTORY  --}}
    <script>
        $(document).on("change","#isCurrentAssignment",function(){

            let endDate=$("#endDate");

            if($(this).is(":checked")){

                endDate
                    .val("")
                    .prop("disabled",true)
                    .prop("required",false);

            }else{

                endDate
                    .prop("disabled",false)
                    .prop("required",true);

            }

        });

        $("#btnSaveHistory").click(function(){

            let form=$("#formHistory")[0];

            let formData = new FormData(form);
            
            let uuid=$("#historyUuid").val();

            let url;
            let method;

            if(uuid==""){

                url="{{ route('user-page.profile.history.store') }}";
                method="POST";

            }else{

                url="/user-page/profile/history/"+uuid;
                method="POST";

                formData.append("_method","PUT");

            }

            if(!form.checkValidity()){
                form.reportValidity();
                return;
            }

            let btn=$(this);

            btn.prop("disabled",true)
                .html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

            $.ajax({

                url:url,

                type:method,

                data:formData,

                processData:false,

                contentType:false,

                success:function(res){

                    console.log(res);

                    if($("#historyModalTitle").text()=="Tambah Riwayat Penugasan"){

                        addHistoryCard(res.data);

                    }else{

                        updateHistoryCard(res.data);

                    }

                    form.reset();

                    $("#endDate")
                        .prop("disabled",false)
                        .prop("required",true)
                        .attr("type","date");

                    $("#isCurrentAssignment").prop("checked",false);

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById("historyModal")
                    ).hide();

                    btn.html("Tambahkan").prop("disabled",false);

                    Swal.fire({
                        icon:"success",
                        title:"Berhasil",
                        text:res.message,
                        timer:1500,
                        showConfirmButton:false
                    });

                },

                error:function(xhr){

                    btn.html("Tambahkan").prop("disabled",false);

                    Swal.fire({
                        icon:"error",
                        title:"Oops",
                        text:xhr.responseJSON.message
                    });

                }

            });

        });

        function formatDate(date){

            if(!date) return '';

            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });

        }

        function addHistoryCard(data){

            let period = formatDate(data.start_date);

            if(data.is_current == 1){
                period += " &nbsp;&ndash;&nbsp; Sekarang";
            }else{
                period += " &nbsp;&ndash;&nbsp; " + formatDate(data.end_date);
            }

            let iconClass = data.is_current == 1 ? "" : "inactive";
            let iconColor = data.is_current == 1 ? "text-warning" : "";

            let html = `
            <div class="assignment-item" data-uuid="${data.uuid}">

                <div class="assignment-icon">

                    <div class="assignment-icon ${iconClass}">

                        <i class="ki-duotone ki-shield-tick fs-2 ${iconColor}">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                    </div>

                </div>

                <div class="assignment-content">

                    <h5 class="assignment-position">
                        ${data.position}
                    </h5>

                    <div class="assignment-company">
                        ${data.company_name}
                    </div>

                    <div class="assignment-meta">

                        ${period}

                        <span class="mx-2">•</span>

                        ${data.location}

                    </div>

                    <div class="assignment-description">

                        ${data.description ?? ''}

                    </div>

                </div>

                <div class="dropup">

                    <button
                        class="history-menu"
                        type="button"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="static">

                        <i class="ki-duotone ki-dots-horizontal fs-4"></i>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end history-dropdown">

                        <li>

                            <a class="dropdown-item btnEditHistory"
                                href="javascript:;"
                                data-uuid="${data.uuid}"
                                data-position="${data.position}"
                                data-company="${data.company_name}"
                                data-location="${data.location}"
                                data-placement="${data.placement}"
                                data-start="${data.start_date}"
                                data-end="${data.end_date}"
                                data-current="${data.is_current}"
                                data-category="${data.category}"
                                data-description="${data.description}">

                                <i class="ki-duotone ki-notepad-edit me-3"></i>

                                Edit

                            </a>

                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>

                            <a class="dropdown-item text-danger btnDeleteSubmitHistory"
                                href="javascript:;"
                                data-uuid="${data.uuid}">

                                <i class="ki-duotone ki-trash text-danger me-3"></i>

                                Hapus

                            </a>

                        </li>

                    </ul>

                </div>

            </div>
            `;

            $(".assignment-timeline").prepend(html);

        }

        function updateHistoryCard(data){

            let card = $('.assignment-item[data-uuid="'+data.uuid+'"]');

            let period = formatDate(data.start_date);

            if(data.is_current == 1){
                period += " &nbsp;&ndash;&nbsp; Sekarang";
            }else{
                period += " &nbsp;&ndash;&nbsp; " + formatDate(data.end_date);
            }

            let icon = card.find(".assignment-icon");
            let iconI = icon.find("i");

            if(data.is_current == 1){

                icon.removeClass("inactive");
                iconI.addClass("text-warning");

            }else{

                icon.addClass("inactive");
                iconI.removeClass("text-warning");

            }

            // Update tampilan
            card.find(".assignment-position").text(data.position);

            card.find(".assignment-company").text(data.company_name);

            card.find(".assignment-meta").html(`
                ${period}
                <span class="mx-2">•</span>
                ${data.location}
            `);

            card.find(".assignment-description").text(data.description ?? '');

            let btnEdit = card.find(".btnEditHistory");

            btnEdit
                .attr("data-position", data.position)
                .data("position", data.position)

                .attr("data-company", data.company_name)
                .data("company", data.company_name)

                .attr("data-location", data.location)
                .data("location", data.location)

                .attr("data-placement", data.placement)
                .data("placement", data.placement)

                .attr("data-start", data.start_date)
                .data("start", data.start_date)

                .attr("data-end", data.end_date)
                .data("end", data.end_date)

                .attr("data-current", data.is_current)
                .data("current", data.is_current)

                .attr("data-category", data.category)
                .data("category", data.category)

                .attr("data-description", data.description ?? "")
                .data("description", data.description ?? "");

            // Update tombol hapus jika UUID berubah (opsional)
            card.find(".btnDeleteSubmitHistory")
                .attr("data-uuid", data.uuid);
        }

        $(document).on("click", ".btnEditHistory", function () {

            let btn = $(this);
            let form = $("#formHistory");
            
            $("#historyModalTitle").text("Edit Riwayat Penugasan");
            $("#certificateModalSubtitle").text("Perbarui informasi riwayat.");

            $("#btnSaveHistory").html("Simpan Perubahan");

            form.attr("action", "/user-page/profile/history/" + btn.data("uuid"));

            $("#historyUuid").val(btn.data("uuid"));

            form.find("[name=position]").val(btn.data("position"));
            form.find("[name=company_name]").val(btn.data("company"));
            form.find("[name=location]").val(btn.data("location"));
            form.find("[name=start_date]").val(btn.data("start"));
            form.find("[name=end_date]").val(btn.data("end"));
            form.find("[name=description]").val(btn.data("description"));
            form.find("[name=category]")
            .val(btn.data("category"))
            .trigger("change");

            if(btn.data("current") == 1){

                $("#isCurrentAssignment")
                    .prop("checked", true)
                    .trigger("change");

            }else{

                $("#isCurrentAssignment")
                    .prop("checked", false)
                    .trigger("change");

            }

            new bootstrap.Modal("#historyModal").show();

        });

        $(".btnAddHistory").click(function(){
            if ($("#historyModalTitle").text().trim() != "Tambah Riwayat Penugasan") {
                $("#formHistory")[0].reset();
            }

            $("#historyModalTitle").text("Tambah Riwayat Penugasan");

            $("#historyModalSubtitle").text("Lengkapi informasi riwayat penugasan");

            $("#formHistory")
                .attr("action","{{ route('user-page.profile.history.store') }}");

            $("#historyUuid").val("");

            $("#isCurrentAssignment")
                .prop("checked",false)
                .trigger("change");

            $("#btnSaveHistory").html("Tambahkan");
        });

        $("#btnDeleteHistory").click(function(){

            let btn = $(this);

            let uuid = $("#deleteHistoryUuid").val();

            $.ajax({

                url: "/user-page/profile/history/" + uuid,

                type: "DELETE",

                data:{
                    _token:$('meta[name="csrf-token"]').attr("content")
                },

                beforeSend:function(){

                    btn.prop("disabled",true)
                    .html('<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...');

                },

                success:function(res){

                    $("#deleteHistoryModal").modal("hide");

                    $(".assignment-item[data-uuid='"+uuid+"']")
                        .fadeOut(250,function(){

                            $(this).remove();

                        });

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message,

                        timer:1800,

                        showConfirmButton:false

                    });

                },

                error:function(){

                    Swal.fire({

                        icon:"error",

                        title:"Gagal",

                        text:"Gagal menghapus sertifikat."

                    });

                },

                complete:function(){

                    btn.prop("disabled",false)
                    .html("Hapus");

                }

            });

        });

        $(document).on("click",".btnDeleteSubmitHistory",function(){

            let uuid = $(this).data("uuid");

            $("#deleteHistoryUuid").val(uuid);

            $("#deleteHistoryModal").modal("show");

        });
    </script>
@endsection
