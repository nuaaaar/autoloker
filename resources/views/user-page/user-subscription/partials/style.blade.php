<style>

/* ============================================================
   PAYMENT HISTORY
============================================================ */

.payment-history-page {

    --ph-bg: #f7f9fc;
    --ph-surface: #ffffff;
    --ph-surface-2: #f4f7fb;
    --ph-border: #dfe5ee;

    --ph-text: #172033;
    --ph-text-soft: #68758a;
    --ph-text-muted: #8d99aa;

    --ph-primary: #1264d8;
    --ph-primary-soft: rgba(18, 100, 216, .08);

    --ph-success: #00c896;
    --ph-success-soft: rgba(0, 200, 150, .08);

    --ph-warning: #f5aa00;
    --ph-warning-soft: rgba(245, 170, 0, .09);

    --ph-danger: #ef476f;
    --ph-danger-soft: rgba(239, 71, 111, .08);

    --ph-shadow: 0 8px 25px rgba(27, 39, 61, .05);

    color: var(--ph-text);
}


/* ============================================================
   DARK MODE
============================================================ */

.dark-layout .payment-history-page,
.dark-mode .payment-history-page,
[data-theme="dark"] .payment-history-page,
[data-bs-theme="dark"] .payment-history-page {

    --ph-bg: #080f1e;
    --ph-surface: #0c1628;
    --ph-surface-2: #101c30;
    --ph-border: #1d2c45;

    --ph-text: #f1f5fb;
    --ph-text-soft: #8795ab;
    --ph-text-muted: #687891;

    --ph-primary: #2684ff;
    --ph-primary-soft: rgba(38, 132, 255, .10);

    --ph-success: #00d6a3;
    --ph-success-soft: rgba(0, 214, 163, .08);

    --ph-warning: #ffb800;
    --ph-warning-soft: rgba(255, 184, 0, .09);

    --ph-danger: #ff496f;
    --ph-danger-soft: rgba(255, 73, 111, .08);

    --ph-shadow: none;
}


/* ============================================================
   BREADCRUMB
============================================================ */

.payment-breadcrumb-wrapper {

    margin-bottom: 20px;

}

.payment-history-page .breadcrumb {

    margin-bottom: 0;

}

.payment-history-page .breadcrumb-item {

    font-size: 12px;
    font-weight: 500;

}

.payment-history-page .breadcrumb-item a {

    color: var(--ph-text-soft);
    text-decoration: none;

}

.payment-history-page .breadcrumb-item.active {

    color: var(--ph-text);

}


/* ============================================================
   FLASH
============================================================ */

.ph-flash {

    display: flex;
    align-items: center;
    gap: 10px;

    padding: 10px;

    margin-bottom: 12px;

    border: 1px solid;
    border-radius: 11px;

}

.ph-flash-success {

    background: var(--ph-success-soft);
    border-color: rgba(0, 200, 150, .30);

}

.ph-flash-danger {

    background: var(--ph-danger-soft);
    border-color: rgba(239, 71, 111, .30);

}

.ph-flash-icon {

    width: 30px;
    height: 30px;

    flex: 0 0 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    font-size: 15px;

}

.ph-flash-success .ph-flash-icon {

    color: var(--ph-success);
    background: var(--ph-success-soft);

}

.ph-flash-danger .ph-flash-icon {

    color: var(--ph-danger);
    background: var(--ph-danger-soft);

}

.ph-flash-title {

    font-size: 10px;
    font-weight: 700;

}

.ph-flash-message {

    margin-top: 1px;

    color: var(--ph-text-soft);

    font-size: 8px;

}


/* ============================================================
   SUMMARY
============================================================ */

.payment-summary {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 10px;

    margin-bottom: 14px;

}

.payment-summary-card {

    min-height: 72px;

    padding: 12px 14px;

    display: flex;
    flex-direction: column;

    justify-content: center;
    align-items: center;

    background: var(--ph-surface);

    border: 1px solid var(--ph-border);

    border-radius: 11px;

    box-shadow: var(--ph-shadow);

}

.payment-summary-label {

    margin-bottom: 3px;

    color: var(--ph-text-muted);

    font-size: 10px;
    font-weight: 500;

}

.payment-summary-value {

    color: var(--ph-text);

    font-size: 13px;
    font-weight: 700;

    line-height: 1.4;

}

.payment-summary-sub {

    margin-top: 1px;

    color: var(--ph-text-soft);

    font-size: 9px;

}


/* ============================================================
   ALERT
============================================================ */

.payment-alert {

    display: flex;
    align-items: center;

    gap: 10px;

    padding: 10px;

    border: 1px solid;

    border-radius: 11px;

    margin-bottom: 12px;

}

.payment-alert-icon {

    width: 32px;
    height: 32px;

    flex: 0 0 32px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    font-size: 15px;

}

.payment-alert-content {

    min-width: 0;

    flex: 1;

}

.payment-alert-title {

    margin-bottom: 1px;

    font-size: 11px;
    font-weight: 700;

}

.payment-alert-description {

    color: var(--ph-text-soft);

    font-size: 9px;

    line-height: 1.45;

}

.payment-alert-action {

    flex: 0 0 auto;

}

.payment-alert.warning {

    border-color:
        rgba(245, 170, 0, .45);

    background:
        var(--ph-warning-soft);

}

.payment-alert.warning
.payment-alert-icon {

    color: var(--ph-warning);

    border:
        1px solid
        rgba(245, 170, 0, .35);

}

.payment-alert.warning
.payment-alert-title {

    color: var(--ph-warning);

}

.payment-alert.danger {

    border-color:
        rgba(239, 71, 111, .40);

    background:
        var(--ph-danger-soft);

}

.payment-alert.danger
.payment-alert-icon {

    color: var(--ph-danger);

    border:
        1px solid
        rgba(239, 71, 111, .35);

}

.payment-alert.danger
.payment-alert-title {

    color: var(--ph-danger);

}


/* ============================================================
   BUTTON
============================================================ */

.ph-btn {

    min-height: 28px;

    padding: 5px 13px;

    border-radius: 15px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border: 1px solid transparent;

    font-size: 9px;
    font-weight: 700;

    transition: all .2s ease;

    cursor: pointer;

}

.ph-btn:hover {

    transform: translateY(-1px);

}

.ph-btn:disabled {

    opacity: .65;

    cursor: not-allowed;

    transform: none;

}

.ph-btn-warning {

    color: #111;

    background:
        var(--ph-warning);

    border-color:
        var(--ph-warning);

    box-shadow:
        0 4px 12px
        rgba(245, 170, 0, .20);

}

.ph-btn-danger {

    color: var(--ph-danger);

    background:
        rgba(239, 71, 111, .07);

    border-color:
        rgba(239, 71, 111, .35);

}

.ph-btn-outline {

    color: var(--ph-text-soft);

    background: transparent;

    border-color:
        var(--ph-border);

}


/* ============================================================
   SECTION TITLE
============================================================ */

.ph-section-title {

    margin-top: 15px;
    margin-bottom: 8px;

    color: var(--ph-text-muted);

    font-size: 9px;
    font-weight: 700;

    letter-spacing: 1.1px;

    text-transform: uppercase;

}


/* ============================================================
   BANK ACCOUNT
============================================================ */

.bank-account-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 6px;

}

.bank-card {

    position: relative;

    padding: 11px;

    min-height: 94px;

    background:
        var(--ph-surface);

    border:
        1px solid
        var(--ph-border);

    border-radius: 11px;

    transition:
        all .2s ease;

}

.bank-card:hover {

    transform:
        translateY(-2px);

    box-shadow:
        var(--ph-shadow);

}

.bank-card.bca {

    border-color:
        rgba(18, 100, 216, .65);

}

.bank-card.mandiri {

    border-color:
        rgba(245, 170, 0, .45);

}

.bank-card.bni {

    border-color:
        rgba(239, 92, 48, .55);

}

.bank-card.default {

    border-color:
        var(--ph-border);

}

.bank-name {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 8px;

    font-size: 10px;

    font-weight: 800;

}

.bank-card.bca
.bank-name {

    color: #3d91ff;

}

.bank-card.mandiri
.bank-name {

    color: #ffca28;

}

.bank-card.bni
.bank-name {

    color: #ff754d;

}

.bank-card.default
.bank-name {

    color: var(--ph-text);

}

.bank-account-number {

    margin-bottom: 2px;

    color:
        var(--ph-text);

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 1.5px;

}

.bank-account-owner {

    margin-bottom: 8px;

    color:
        var(--ph-text-soft);

    font-size: 8px;

}

.bank-copy-btn {

    width: 100%;

    height: 22px;

    border: 1px solid;

    border-radius: 7px;

    background: transparent;

    font-size: 8px;

    font-weight: 700;

    cursor: pointer;

}

.bank-card.bca
.bank-copy-btn {

    color: #3d91ff;

    border-color:
        rgba(18, 100, 216, .45);

}

.bank-card.mandiri
.bank-copy-btn {

    color: #ffca28;

    border-color:
        rgba(245, 170, 0, .45);

}

.bank-card.bni
.bank-copy-btn {

    color: #ff754d;

    border-color:
        rgba(239, 92, 48, .45);

}

.bank-card.default
.bank-copy-btn {

    color: var(--ph-primary);

    border-color:
        rgba(38, 132, 255, .35);

}

.bank-copy-btn:hover {

    background:
        var(--ph-surface-2);

}

.bank-description {

    margin-top: 7px;

    color:
        var(--ph-text-soft);

    font-size: 8px;

}

.bank-empty {

    grid-column:
        1 / -1;

    min-height: 70px;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    border:
        1px dashed
        var(--ph-border);

    border-radius: 11px;

    color:
        var(--ph-text-soft);

    font-size: 9px;

}


/* ============================================================
   ORDER CARD
============================================================ */

.payment-order-card {

    position: relative;

    margin-bottom: 8px;

    padding: 10px;

    background:
        var(--ph-surface);

    border:
        1px solid
        var(--ph-border);

    border-radius: 11px;

    overflow: hidden;

}

.payment-order-card.status-approved {

    border-color:
        rgba(0, 200, 150, .55);

}

.payment-order-card.status-verification {

    border-color:
        rgba(38, 132, 255, .55);

}

.payment-order-card.status-pending {

    border-color:
        rgba(245, 170, 0, .45);

}

.payment-order-card.status-rejected {

    border-color:
        rgba(239, 71, 111, .40);

}


/* ============================================================
   ORDER HEADER
============================================================ */

.order-header {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 10px;

}

.order-title-wrapper {

    display: flex;

    align-items: center;

    gap: 8px;

}

.order-icon {

    width: 28px;
    height: 28px;

    flex: 0 0 28px;

    display: flex;

    align-items: center;
    justify-content: center;

    border:
        1px solid
        var(--ph-border);

    border-radius: 8px;

    color:
        var(--ph-primary);

    background:
        var(--ph-primary-soft);

    font-size: 13px;

}

.status-approved
.order-icon {

    color:
        var(--ph-success);

    background:
        var(--ph-success-soft);

    border-color:
        rgba(0, 200, 150, .35);

}

.status-pending
.order-icon {

    color:
        var(--ph-warning);

    background:
        var(--ph-warning-soft);

    border-color:
        rgba(245, 170, 0, .35);

}

.status-rejected
.order-icon {

    color:
        var(--ph-danger);

    background:
        var(--ph-danger-soft);

    border-color:
        rgba(239, 71, 111, .35);

}

.order-number {

    margin-bottom: 1px;

    color:
        var(--ph-text-muted);

    font-size: 8px;

    font-weight: 500;

}

.order-package {

    color:
        var(--ph-text);

    font-size: 10px;

    font-weight: 700;

}


/* ============================================================
   STATUS
============================================================ */

.ph-status {

    padding: 4px 8px;

    border: 1px solid;

    border-radius: 12px;

    font-size: 7px;

    font-weight: 700;

    white-space: nowrap;

}

.ph-status.approved {

    color:
        var(--ph-success);

    border-color:
        rgba(0, 200, 150, .35);

    background:
        var(--ph-success-soft);

}

.ph-status.verification {

    color:
        var(--ph-primary);

    border-color:
        rgba(38, 132, 255, .35);

    background:
        var(--ph-primary-soft);

}

.ph-status.pending {

    color:
        var(--ph-warning);

    border-color:
        rgba(245, 170, 0, .35);

    background:
        var(--ph-warning-soft);

}

.ph-status.rejected {

    color:
        var(--ph-danger);

    border-color:
        rgba(239, 71, 111, .35);

    background:
        var(--ph-danger-soft);

}


/* ============================================================
   ORDER INFORMATION
============================================================ */

.order-information {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    margin-top: 9px;

    gap: 3px 25px;

}

.order-info-item {

    min-width: 0;

}

.order-info-label {

    margin-bottom: 1px;

    color:
        var(--ph-text-muted);

    font-size: 7px;

}

.order-info-value {

    color:
        var(--ph-text);

    font-size: 8px;

    font-weight: 700;

}

.order-info-value.success {

    color:
        var(--ph-success);

}


/* ============================================================
   TIMELINE
============================================================ */

.payment-timeline {

    position: relative;

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    margin: 11px 0 8px;

}

.timeline-item {

    position: relative;

    text-align: center;

}

.timeline-item:not(:last-child)::after {

    content: '';

    position: absolute;

    top: 6px;

    left:
        calc(50% + 9px);

    width:
        calc(100% - 18px);

    height: 1px;

    background:
        var(--ph-border);

}

.timeline-item.completed:not(:last-child)::after {

    background:
        var(--ph-success);

}

.timeline-dot {

    position: relative;

    z-index: 2;

    width: 13px;
    height: 13px;

    margin:
        0 auto 3px;

    display: flex;

    align-items: center;
    justify-content: center;

    border:
        2px solid
        var(--ph-border);

    border-radius: 50%;

    background:
        var(--ph-surface);

    color:
        var(--ph-text-muted);

    font-size: 6px;

}

.timeline-item.completed
.timeline-dot {

    color:
        var(--ph-success);

    border-color:
        var(--ph-success);

}

.timeline-item.current
.timeline-dot {

    color:
        var(--ph-warning);

    border-color:
        var(--ph-warning);

}

.timeline-item.rejected
.timeline-dot {

    color:
        var(--ph-danger);

    border-color:
        var(--ph-danger);

}

.timeline-label {

    color:
        var(--ph-text-muted);

    font-size: 7px;

    white-space: nowrap;

}

.timeline-item.completed
.timeline-label {

    color:
        var(--ph-success);

}

.timeline-item.current
.timeline-label {

    color:
        var(--ph-warning);

}

.timeline-item.rejected
.timeline-label {

    color:
        var(--ph-danger);

}


/* ============================================================
   VERIFICATION
============================================================ */

.payment-verification-message {

    display: flex;

    align-items: center;

    gap: 5px;

    padding: 6px 8px;

    border:
        1px solid
        rgba(0, 200, 150, .25);

    border-radius: 8px;

    background:
        var(--ph-success-soft);

    color:
        var(--ph-success);

    font-size: 7px;

}

.payment-rejected-message {

    display: flex;

    align-items: flex-start;

    gap: 5px;

    margin-top: 7px;

    padding: 7px 8px;

    border:
        1px solid
        rgba(239, 71, 111, .28);

    border-radius: 8px;

    background:
        var(--ph-danger-soft);

    color:
        var(--ph-danger);

    font-size: 7px;

    line-height: 1.45;

}


/* ============================================================
   ACTIONS
============================================================ */

.order-actions {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 5px;

    margin-top: 8px;

    padding-top: 7px;

    border-top:
        1px solid
        var(--ph-border);

}

.order-actions.single {

    grid-template-columns:
        1fr;

}

.order-action {

    height: 25px;

    display: flex;

    align-items: center;
    justify-content: center;

    border:
        1px solid
        var(--ph-border);

    border-radius: 7px;

    background: transparent;

    color:
        var(--ph-text-soft);

    font-size: 8px;

    font-weight: 600;

    cursor: pointer;

    transition:
        all .2s ease;

}

.order-action:hover {

    color:
        var(--ph-text);

    background:
        var(--ph-surface-2);

}

.order-action.primary {

    color: #111;

    background:
        var(--ph-warning);

    border-color:
        var(--ph-warning);

    font-weight: 700;

}

.order-action.danger {

    color:
        var(--ph-danger);

    border-color:
        rgba(239, 71, 111, .35);

    background:
        var(--ph-danger-soft);

}


/* ============================================================
   EMPTY STATE
============================================================ */

.payment-empty-state {

    padding:
        25px 10px;

    text-align: center;

}

.payment-empty-icon {

    width: 40px;
    height: 40px;

    margin:
        0 auto 10px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        var(--ph-surface-2);

    color:
        var(--ph-text-muted);

    font-size: 18px;

}

.payment-empty-title {

    color:
        var(--ph-text);

    font-size: 11px;

    font-weight: 700;

}

.payment-empty-description {

    margin-top: 3px;

    color:
        var(--ph-text-soft);

    font-size: 9px;

}


/* ============================================================
   MODAL
============================================================ */

.payment-modal .modal-content {

    background:
        var(--ph-surface);

    border:
        1px solid
        var(--ph-border);

    border-radius: 13px;

    color:
        var(--ph-text);

}

.payment-modal .modal-header,
.payment-modal .modal-footer {

    border-color:
        var(--ph-border);

}

.payment-modal .modal-title {

    font-size: 14px;

    font-weight: 700;

}

.payment-modal .form-label {

    color:
        var(--ph-text-soft);

    font-size: 10px;

    font-weight: 600;

}

.payment-modal .form-control,
.payment-modal select {

    color:
        var(--ph-text);

    background:
        var(--ph-surface-2);

    border-color:
        var(--ph-border);

    border-radius: 8px;

    font-size: 11px;

}

.payment-modal .form-control:focus,
.payment-modal select:focus {

    color:
        var(--ph-text);

    background:
        var(--ph-surface);

    border-color:
        var(--ph-primary);

    box-shadow:
        0 0 0 2px
        var(--ph-primary-soft);

}

.payment-modal .btn-close {

    filter:
        var(--ph-close-filter, none);

}

.dark-layout .payment-modal .btn-close,
.dark-mode .payment-modal .btn-close,
[data-theme="dark"] .payment-modal .btn-close,
[data-bs-theme="dark"] .payment-modal .btn-close {

    filter:
        invert(1)
        grayscale(100%)
        brightness(200%);

}

.payment-upload-help {

    color:
        var(--ph-text-soft);

    font-size: 10px;

}


/* ============================================================
   DETAIL MODAL
============================================================ */

.detail-modal-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 12px;

}

.detail-modal-item {

    padding: 9px;

    background:
        var(--ph-surface-2);

    border:
        1px solid
        var(--ph-border);

    border-radius: 8px;

}

.detail-modal-label {

    margin-bottom: 3px;

    color:
        var(--ph-text-muted);

    font-size: 8px;

}

.detail-modal-value {

    color:
        var(--ph-text);

    font-size: 10px;

    font-weight: 700;

}


/* ============================================================
   RESPONSIVE
============================================================ */

@media (max-width: 767.98px) {


    .payment-summary {

        gap: 6px;

    }


    .payment-summary-card {

        min-height: 68px;

        padding:
            9px 5px;

    }


    .payment-summary-value {

        font-size: 11px;

    }


    .payment-summary-label {

        font-size: 8px;

    }


    .payment-summary-sub {

        font-size: 8px;

    }


    .bank-account-grid {

        grid-template-columns:
            1fr;

    }


    .bank-card {

        min-height: auto;

    }


    .payment-alert {

        align-items:
            flex-start;

    }


    .payment-alert-action {

        margin-left:
            auto;

    }


}


@media (max-width: 480px) {


    .payment-alert {

        flex-wrap: wrap;

    }


    .payment-alert-action {

        width: 100%;

    }


    .payment-alert-action .ph-btn {

        width: 100%;

    }


    .order-actions {

        grid-template-columns:
            1fr;

    }


    .detail-modal-grid {

        grid-template-columns:
            1fr;

    }


}

.payment-proof-preview {
    margin-top: 5px;
    padding: 10px;
    border: 1px solid #e1e3ea;
    border-radius: 10px;
    background: #f8f9fa;
    text-align: center;
}

.payment-proof-image {
    display: block;
    width: 100%;
    max-width: 300px;
    max-height: 350px;
    object-fit: contain;
    margin: 0 auto;
    border-radius: 8px;
}

.payment-proof-pdf {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    border: 1px solid #e1e3ea;
    border-radius: 8px;
}

.payment-proof-pdf i {
    font-size: 24px;
}

</style>