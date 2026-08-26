<style>
    /* ===========================
        REKOMENDASI
    =========================== */

    .recommend-wrapper{

        background:#11192d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:22px;

        overflow:visible;

    }

    .recommend-header{

        padding:12px 24px;

        display:flex;

        justify-content:space-between;

        align-items:center;

        border-bottom:1px solid rgba(255,255,255,.05);

    }

    .recommend-heading{

        color:#fff;

        font-size:14px;

        font-weight:700;

        margin:0;

    }

    .recommend-subtitle{

        margin-top:4px;

        color:#90a0be;

        font-size:11px;

    }

    .recommend-body{

        padding:18px 24px;

    }

    .recommend-list{

        display:flex;

        flex-direction:column;

        gap:16px;

    }

    .recommend-card{

        background:#1d2848;

        border:1px solid #304060;

        border-radius:16px;

        padding:16px;

        transition:.25s;

    }

    .recommend-card:hover{

        border-color:#f6b00055;

        transform:translateY(-2px);

    }

    .recommend-avatar{

        width:42px;

        height:42px;

        border-radius:50%;

        object-fit:cover;

        border:2px solid #2f3c58;

        flex-shrink:0;

    }

    .recommend-name{

        color:#ecf1ff;

        font-size:13px;

        font-weight:700;

    }

    .recommend-position{

        color:#8796b5;

        font-size:11px;

        margin-top:3px;

    }

    .recommend-text{

        color:#aab7d1;

        font-size:12px;

        line-height:1.8;

        font-style:italic;

        margin-top:16px;

        position:relative;

        padding-left:18px;

    }

    .recommend-text:before{

        content:"“";

        position:absolute;

        left:0;

        top:-6px;

        font-size:28px;

        color:#f6b000;

        opacity:.35;

        font-family:serif;

    }

    .recommend-empty{

        padding:50px 25px;

        text-align:center;

    }

    .recommend-empty-icon{

        width:32px;
        height:32px;

        margin:auto auto 20px;

        display:flex;
        align-items:center;
        justify-content:center;

        border-radius:50%;

        background:rgba(246,176,0,.08);

        border:1px solid rgba(246,176,0,.18);

    }

    .recommend-empty-title{

        color:#fff;

        font-size:15px;

        font-weight:700;

    }

    .recommend-empty-text{

        max-width:520px;

        margin:10px auto 0;

        color:#8fa0bc;

        font-size:12px;

        line-height:1.8;

    }

</style>

<div id="tab-rekomendasi" class="profile-content">

    <div class="recommend-wrapper">

        <!-- Header -->

        <div class="recommend-header">

            <div>

                <h4 class="recommend-heading">

                    Rekomendasi

                </h4>

                <div class="recommend-subtitle">

                    Testimoni dari atasan dan rekan kerja

                </div>

            </div>

        </div>

        <!-- Body -->

        <div class="recommend-body">

            <div class="recommend-list">

                @php

                    $recommendations = [

                    ];

                @endphp

                @forelse($recommendations as $recommend)

                    <div class="recommend-card">

                        <div class="d-flex">

                            <img src="{{ $recommend['photo'] }}"
                                class="recommend-avatar">

                            <div class="ms-3">

                                <div class="recommend-name">

                                    {{ $recommend['name'] }}

                                </div>

                                <div class="recommend-position">

                                    {{ $recommend['position'] }}
                                    •
                                    {{ $recommend['company'] }}

                                </div>

                            </div>

                        </div>

                        <div class="recommend-text">

                            "{{ $recommend['message'] }}"

                        </div>

                    </div>

                @empty

                    <div class="recommend-empty">

                        <div class="recommend-empty-icon">

                            <i class="ki-duotone ki-like fs-6 text-warning">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                        </div>

                        <div class="recommend-empty-title">

                            Belum Ada Rekomendasi

                        </div>

                        <div class="recommend-empty-text">

                            Rekomendasi dari atasan, supervisor, atau rekan kerja akan
                            meningkatkan kredibilitas profil Anda di mata perusahaan
                            maupun BUJP.

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>