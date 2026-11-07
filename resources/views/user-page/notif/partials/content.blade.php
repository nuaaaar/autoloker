<style>
    .notification-title{
        color:#fff;
        font-size:16px;
        font-weight:700;
    }

    .read-all{
        color:#e8a401;
        text-decoration:none;
        font-size:12px;
        font-weight:600;
    }

    .read-all:hover{
        color:#ffcb3f;
    }

    .notification-card{

        background:#11192d;
        border:1px solid #28334c;
        border-radius:18px;
        overflow:hidden;

    }

    .notification-item{

        display:block;
        padding:12px 16px;
        color:#fff;
        text-decoration:none;
        border-bottom:1px solid #29344c;
        transition:.25s;

    }

    .notification-item:last-child{
        border-bottom:none;
    }

    .notification-item:hover{

        background:#17233f;

    }

    .notification-avatar{

        width:32px;
        height:32px;
        border-radius:50%;
        object-fit:cover;

    }

    .notification-icon{

        width:32px;
        height:32px;
        border-radius:50%;

        display:flex;
        align-items:center;
        justify-content:center;

        background:#1b2950;
        color:#8aa5ff;

        flex-shrink:0;

    }

    .notification-icon.warning{

        color:#f3b012;

    }

    .notification-icon.danger{

        color:#ff5d73;

    }

    .notification-icon.purple{

        color:#a875ff;

    }

    .notification-text{

        color:#dfe5ef;
        font-size:12px;
        font-weight:500;
        line-height:1.45;

    }

    .notification-time{

        margin-top:1px;

        font-size:10px;

        color:#8b97b4;

        font-family:monospace;

    }

    .dot-unread{

        width:10px;
        height:10px;
        background:#e8a401;
        border-radius:50%;
        flex-shrink:0;

    }

    .unread{

        background:#171d2b;

    }


    /*==================================
    LIGHT MODE
    ==================================*/

    [data-bs-theme="light"] .notification-title{
        color:#1e293b;
    }

    [data-bs-theme="light"] .read-all{
        color:#d18f00;
    }

    [data-bs-theme="light"] .read-all:hover{
        color:#b77900;
    }

    [data-bs-theme="light"] .notification-card{

        background:#ffffff;
        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .notification-item{

        color:#334155;
        border-bottom-color:#e2e8f0;

    }

    [data-bs-theme="light"] .notification-item:hover{

        background:#f8fafc;

    }

    [data-bs-theme="light"] .notification-icon{

        background:#eef2ff;
        color:#5274d9;

    }

    [data-bs-theme="light"] .notification-icon.warning{

        color:#d18f00;

    }

    [data-bs-theme="light"] .notification-icon.danger{

        color:#e0445d;

    }

    [data-bs-theme="light"] .notification-icon.purple{

        color:#8b5bd6;

    }

    [data-bs-theme="light"] .notification-text{

        color:#475569;

    }

    [data-bs-theme="light"] .notification-time{

        color:#94a3b8;

    }

    [data-bs-theme="light"] .unread{

        background:#fffaf0;

    }


    /*==================================
    RESPONSIVE
    ==================================*/

    @media(max-width:991px){

        .notification-title{

            font-size:12px;

        }

        .notification-item{

            padding:18px;

        }

        .notification-text{

            font-size:10px;

        }

        .notification-time{

            font-size:10px;

        }

        .notification-avatar,
        .notification-icon{

            width:32px;
            height:32px;

        }

    }

    /* =========================================================
    EMPTY NOTIFICATION
    ========================================================= */

    .notification-empty {
        min-height: 320px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        padding: 40px 24px;

        text-align: center;
    }

    /* =========================================================
    ICON
    ========================================================= */

    .notification-empty-icon {
        width: 72px;
        height: 72px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 18px;

        border-radius: 50%;

        background: #f1f5f9;
        color: #64748b;
    }

    .notification-empty-icon i {
        color: #71809a;
    }

    /* =========================================================
    TITLE
    ========================================================= */

    .notification-empty-title {
        color: #182338;

        font-size: 16px;
        font-weight: 700;

        margin-bottom: 6px;
    }

    /* =========================================================
    DESCRIPTION
    ========================================================= */

    .notification-empty-text {
        max-width: 360px;

        color: #8a97a9;

        font-size: 13px;
        line-height: 1.6;
    }


    /* =========================================================
    DARK MODE
    ========================================================= */

    [data-bs-theme="dark"] .notification-empty {
        color: #d8deea;
    }

    [data-bs-theme="dark"] .notification-empty-icon {
        background: #202a3d;
        color: #8fa1ba;
    }

    [data-bs-theme="dark"] .notification-empty-icon i {
        color: #91a2ba;
    }

    [data-bs-theme="dark"] .notification-empty-title {
        color: #e7ebf3;
    }

    [data-bs-theme="dark"] .notification-empty-text {
        color: #8997ad;
    }
</style>

<style>
    .notification-title {
        font-size: 22px;
        font-weight: 700;
        color: #181c32;
        margin-bottom: 0;
    }

    .read-all {
        font-size: 13px;
        font-weight: 600;
        color: #f1a900;
        text-decoration: none;
        transition: .2s;
    }

    .read-all:hover {
        color: #d89500;
    }

    .notification-card {
        border: 1px solid #eff0f5;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0, 0, 0, .03);
    }

    .notification-item {
        display: block;
        padding: 20px 24px;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f1f1f4;
        transition: background .2s ease;
        position: relative;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background: #fafbfc;
    }

    .notification-item.unread {
        background: #fffcf4;
    }

    .notification-item.unread:hover {
        background: #fff8e8;
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notification-icon.warning {
        background: #fff4d9;
        color: #e6a000;
    }

    .notification-icon.danger {
        background: #fff0f0;
        color: #e74c3c;
    }

    .notification-icon.success {
        background: #e8f8ef;
        color: #28a76b;
    }

    .notification-icon.primary {
        background: #eaf2ff;
        color: #3699ff;
    }

    .notification-icon.purple {
        background: #f2eaff;
        color: #8950fc;
    }

    .notification-text {
        font-size: 14px;
        line-height: 1.6;
        color: #5e6278;
    }

    .notification-text strong {
        color: #181c32;
        font-weight: 600;
    }

    .notification-time {
        margin-top: 5px;
        font-size: 12px;
        color: #a1a5b7;
    }

    .dot-unread {
        width: 9px;
        height: 9px;
        min-width: 9px;
        border-radius: 50%;
        background: #e74c3c;
        margin-left: 15px;
    }

    .notification-empty {
        padding: 75px 20px;
        text-align: center;
    }

    .notification-empty-icon {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        background: #fff7e6;
        color: #e6a000;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px;
    }

    .notification-empty-icon i {
        font-size: 38px !important;
    }

    .notification-empty-title {
        font-size: 17px;
        font-weight: 700;
        color: #181c32;
        margin-bottom: 8px;
    }

    .notification-empty-text {
        font-size: 13px;
        line-height: 1.7;
        color: #a1a5b7;
        max-width: 350px;
        margin: auto;
    }

    .notification-pagination {
        padding: 18px 24px;
        border-top: 1px solid #f1f1f4;
    }

    @media (max-width: 576px) {
        .notification-item {
            padding: 16px;
        }

        .notification-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
        }

        .notification-title {
            font-size: 19px;
        }

        .notification-empty {
            padding: 55px 15px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="notification-title">
            Notifikasi
        </h4>

        <small class="text-muted">
            {{ $notifications->total() }} notifikasi
            @if ($unreadNotificationCount > 0)
                · {{ $unreadNotificationCount }} belum dibaca
            @endif
        </small>
    </div>

    @if ($unreadNotificationCount > 0)
        <button type="button" class="read-all border-0 bg-transparent"
            id="btnReadAll">
            <i class="fas fa-check-double me-1"></i>
            Tandai semua dibaca
        </button>
    @endif

</div>


<div class="card notification-card">

    <div class="list-group list-group-flush">

        @forelse ($notifications as $notification)

            <a href="{{ route('user-page.notif.read', $notification->uuid) }}"
                class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">

                <div class="d-flex align-items-center">

                    <div class="notification-icon primary">
                        <i class="ki-duotone ki-notification-on fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                    </div>

                    <div class="ms-4 flex-grow-1">

                        <div class="notification-text">
                            <strong>
                                {{ $notification->title }}
                            </strong>

                            <div>
                                {{ $notification->message }}
                            </div>
                        </div>

                        <div class="notification-time">
                            <i class="far fa-clock me-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>

                    </div>

                    @if (!$notification->is_read)
                        <span class="dot-unread"></span>
                    @endif

                </div>

            </a>

        @empty

            <div class="notification-empty">

                <div class="notification-empty-icon">
                    <i class="ki-duotone ki-notification-on">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                </div>

                <div class="notification-empty-title">
                    Belum ada notifikasi
                </div>

                <div class="notification-empty-text">
                    Saat ini belum ada notifikasi untuk Anda.
                    Notifikasi baru akan muncul di sini.
                </div>

            </div>

        @endforelse

    </div>

    @if ($notifications->hasPages())
        <div class="notification-pagination">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
