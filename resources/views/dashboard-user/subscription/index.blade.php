@extends('layouts.dashboard-user')

@section('title', 'Paket Berlangganan')

@section('css')
<style>
    /* =========================================================
    SUBSCRIPTION PAGE — THEME VARIABLES
    ========================================================= */

    .subscription-page {
        --sub-bg: var(--dashboard-bg, #f7f8fa);
        --sub-card: var(--dashboard-card, #ffffff);
        --sub-border: var(--dashboard-border, #e2e8f0);

        --sub-title: var(--dashboard-title, #182338);
        --sub-text: var(--dashboard-text, #475569);
        --sub-muted: var(--dashboard-muted, #94a3b8);

        --sub-primary: var(--dashboard-primary, #f7b003);
        --sub-primary-hover: var(--dashboard-primary-hover, #ffc928);
        --sub-primary-soft: var(--dashboard-primary-soft, #fff4d6);

        --sub-green: var(--dashboard-green, #3b765c);
        --sub-green-soft: var(--dashboard-green-soft, #edf5f0);

        --sub-blue: var(--dashboard-blue, #4d86cc);
        --sub-blue-soft: var(--dashboard-blue-soft, #edf5ff);

        --sub-purple: var(--dashboard-purple, #7967c7);
        --sub-purple-soft: var(--dashboard-purple-soft, #f2efff);

        --sub-red: var(--dashboard-red, #d95c5c);
        --sub-red-soft: var(--dashboard-red-soft, #fff1f1);

        --sub-shadow: var(--dashboard-shadow, 0 8px 25px rgba(15,23,42,.06));
        --sub-shadow-hover: var(--dashboard-shadow-hover, 0 12px 28px rgba(15,23,42,.10));
        --sub-divider: var(--dashboard-divider, rgba(15,23,42,.07));

        color: var(--sub-text);
        padding-bottom: 36px;
    }

    .subscription-page *,
    .subscription-page *::before,
    .subscription-page *::after {
        box-sizing: border-box;
    }

    /* =========================================================
    DARK MODE VARIABLES
    Mendukung beberapa selector tema dashboard
    ========================================================= */

    :is(
        [data-bs-theme="dark"],
        .dark-layout,
        .dark-mode,
        [data-theme="dark"]
    ) .subscription-page {
        --sub-bg: #0d1424;
        --sub-card: #11192d;
        --sub-border: rgba(255,255,255,.09);

        --sub-title: #ffffff;
        --sub-text: #c3ccdc;
        --sub-muted: #94a3b8;

        --sub-primary: #f7b003;
        --sub-primary-hover: #ffc928;
        --sub-primary-soft: #2b241d;

        --sub-green: #69a487;
        --sub-green-soft: #172d25;

        --sub-blue: #76a5df;
        --sub-blue-soft: #182940;

        --sub-purple: #9a8be1;
        --sub-purple-soft: #28243d;

        --sub-red: #e47777;
        --sub-red-soft: #351f25;

        --sub-shadow: 0 8px 25px rgba(0,0,0,.22);
        --sub-shadow-hover: 0 12px 28px rgba(0,0,0,.32);
        --sub-divider: rgba(255,255,255,.08);

        color: var(--sub-text);
        color-scheme: dark;
    }

    /* =========================================================
    HERO
    ========================================================= */

    .subscription-page .sub-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 30px 32px;
        margin-bottom: 25px;
        border: 1px solid var(--sub-border);
        border-left: 4px solid var(--sub-primary);
        border-radius: 16px;
        background: var(--sub-card);
        color: var(--sub-text);
        box-shadow: var(--sub-shadow);
    }

    .subscription-page .sub-hero::before {
        content: "";
        position: absolute;
        z-index: -1;
        width: 210px;
        height: 210px;
        top: -115px;
        right: -60px;
        border: 24px solid rgba(247,176,3,.09);
        border-radius: 50%;
        pointer-events: none;
    }

    .subscription-page .sub-hero::after {
        content: "";
        position: absolute;
        z-index: -1;
        width: 120px;
        height: 120px;
        right: 60px;
        bottom: -95px;
        border: 18px solid rgba(247,176,3,.07);
        border-radius: 50%;
        pointer-events: none;
    }

    .subscription-page .sub-hero-content {
        position: relative;
        z-index: 1;
        max-width: 690px;
    }

    .subscription-page .sub-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 11px;
        margin-bottom: 15px;
        border: 1px solid rgba(247,176,3,.25);
        border-radius: 8px;
        background: var(--sub-primary-soft);
        color: var(--sub-title);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .4px;
    }

    .subscription-page .sub-hero-label i {
        color: #b17c00;
        font-size: 15px;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-hero-label i {
        color: var(--sub-primary);
    }

    .subscription-page .sub-hero h2 {
        margin: 0 0 10px;
        color: var(--sub-title);
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 800;
        line-height: 1.35;
    }

    .subscription-page .sub-hero p {
        max-width: 580px;
        margin: 0;
        color: var(--sub-text);
        font-size: 12px;
        line-height: 1.9;
    }

    .subscription-page .sub-hero-bottom {
        display: flex;
        flex-wrap: wrap;
        gap: 17px;
        margin-top: 20px;
        color: var(--sub-muted);
        font-size: 11px;
    }

    .subscription-page .sub-hero-bottom span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .subscription-page .sub-hero-bottom i {
        color: var(--sub-green);
        font-size: 15px;
    }

    /* =========================================================
    CURRENT SUBSCRIPTION
    ========================================================= */

    .subscription-page .sub-current {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 19px 21px;
        margin-bottom: 30px;
        border: 1px solid var(--sub-border);
        border-radius: 14px;
        background: var(--sub-card);
        color: var(--sub-text);
        box-shadow: var(--sub-shadow);
    }

    .subscription-page .sub-current-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .subscription-page .sub-current-icon {
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border: 1px solid rgba(247,176,3,.20);
        border-radius: 12px;
        background: var(--sub-primary-soft);
        color: #a87500;
        font-size: 22px;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-current-icon {
        color: var(--sub-primary);
    }

    .subscription-page .sub-current h5 {
        margin: 0 0 6px;
        color: var(--sub-title);
        font-size: 13px;
        font-weight: 800;
    }

    .subscription-page .sub-current p {
        margin: 0;
        color: var(--sub-muted);
        font-size: 11px;
        line-height: 1.8;
    }

    .subscription-page .sub-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 7px;
        background: var(--sub-green-soft);
        color: var(--sub-green);
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .subscription-page .sub-status.inactive {
        background: var(--sub-primary-soft);
        color: #a87500;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-status.inactive {
        color: var(--sub-primary);
    }

    /* =========================================================
    SECTION HEADING
    ========================================================= */

    .subscription-page .sub-section-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 19px;
    }

    .subscription-page .sub-section-heading h3 {
        margin: 0 0 6px;
        color: var(--sub-title);
        font-size: 21px;
        font-weight: 800;
    }

    .subscription-page .sub-section-heading p {
        margin: 0;
        color: var(--sub-muted);
        font-size: 11px;
        line-height: 1.8;
    }

    .subscription-page .sub-count {
        flex-shrink: 0;
        padding: 7px 10px;
        border: 1px solid var(--sub-border);
        border-radius: 8px;
        background: var(--sub-card);
        color: var(--sub-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .subscription-page #sub-visible-count {
        color: var(--sub-title);
        font-weight: 800;
    }

    /* =========================================================
    FILTER & SEARCH
    ========================================================= */

    .subscription-page .sub-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 21px;
    }

    .subscription-page .sub-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .subscription-page .sub-filter {
        padding: 9px 13px;
        border: 1px solid var(--sub-border);
        border-radius: 8px;
        background: var(--sub-card);
        color: var(--sub-text);
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .subscription-page .sub-filter:hover {
        border-color: var(--sub-primary);
    }

    .subscription-page .sub-filter.active {
        border-color: var(--sub-primary);
        background: var(--sub-primary-soft);
        color: var(--sub-title);
        box-shadow: inset 0 -2px 0 var(--sub-primary);
    }

    .subscription-page .sub-search {
        position: relative;
        width: 240px;
        max-width: 100%;
    }

    .subscription-page .sub-search i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: var(--sub-muted);
        font-size: 16px;
        pointer-events: none;
    }

    .subscription-page .sub-search input {
        width: 100%;
        height: 39px;
        padding: 0 12px 0 36px;
        outline: none;
        border: 1px solid var(--sub-border);
        border-radius: 9px;
        background: var(--sub-card);
        color: var(--sub-title);
        font-size: 11px;
        transition: .2s ease;
    }

    .subscription-page .sub-search input::placeholder {
        color: var(--sub-muted);
    }

    .subscription-page .sub-search input:focus {
        border-color: var(--sub-primary);
        box-shadow: 0 0 0 3px rgba(247,176,3,.10);
    }

    /* =========================================================
    PACKAGE CARDS
    ========================================================= */

    .subscription-page .sub-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .subscription-page .sub-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 23px;
        overflow: hidden;
        border: 1px solid var(--sub-border);
        border-radius: 14px;
        background: var(--sub-card);
        color: var(--sub-text);
        box-shadow: var(--sub-shadow);
        transition: transform .2s ease, border-color .2s ease,
                    box-shadow .2s ease;
    }

    .subscription-page .sub-card:hover {
        transform: translateY(-3px);
        border-color: rgba(247,176,3,.65);
        box-shadow: var(--sub-shadow-hover);
    }

    /* Paket populer: background tetap mengikuti tema */
    .subscription-page .sub-card.featured {
        border: 1px solid var(--sub-primary);
        background: var(--sub-card);
        box-shadow: inset 0 3px 0 var(--sub-primary), var(--sub-shadow);
    }

    .subscription-page .sub-popular {
        position: absolute;
        top: 0;
        right: 0;
        padding: 7px 10px;
        border-radius: 0 0 0 9px;
        border-left: 1px solid rgba(247,176,3,.20);
        border-bottom: 1px solid rgba(247,176,3,.20);
        background: var(--sub-primary-soft);
        color: var(--sub-title);
        font-size: 9px;
        font-weight: 800;
    }

    .subscription-page .sub-card-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 19px;
        padding-right: 4px;
    }

    .subscription-page .sub-plan-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: var(--sub-primary-soft);
        color: #a87500;
        font-size: 22px;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-plan-icon {
        color: var(--sub-primary);
    }

    .subscription-page .sub-plan-name {
        margin: 0 0 5px;
        color: var(--sub-title);
        font-size: 15px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-plan-caption {
        margin: 0;
        color: var(--sub-muted);
        font-size: 10px;
    }

    .subscription-page .sub-price {
        margin: 0 0 6px;
        color: var(--sub-title);
        font-size: clamp(23px, 2vw, 28px);
        font-weight: 900;
        letter-spacing: -.5px;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-price small {
        color: var(--sub-muted);
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0;
    }

    .subscription-page .sub-price-note {
        min-height: 18px;
        margin-bottom: 18px;
        color: var(--sub-muted);
        font-size: 10px;
    }

    .subscription-page .sub-divider {
        height: 1px;
        margin-bottom: 17px;
        background: var(--sub-divider);
    }

    .subscription-page .sub-description {
        margin: 0 0 17px;
        color: var(--sub-text);
        font-size: 11px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-feature-title {
        margin-bottom: 12px;
        color: var(--sub-title);
        font-size: 11px;
        font-weight: 800;
    }

    .subscription-page .sub-features {
        display: flex;
        flex-direction: column;
        gap: 11px;
        margin: 0 0 24px;
        padding: 0;
        list-style: none;
    }

    .subscription-page .sub-features li {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        color: var(--sub-text);
        font-size: 11px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-features li i {
        flex-shrink: 0;
        margin-top: 2px;
        color: var(--sub-green);
        font-size: 15px;
    }

    .subscription-page .sub-card-bottom {
        margin-top: auto;
    }

    /* =========================================================
    BUTTONS
    ========================================================= */

    .subscription-page .sub-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 42px;
        padding: 10px 14px;
        border: 1px solid var(--sub-primary);
        border-radius: 9px;
        background: var(--sub-primary);
        color: #182338 !important;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none !important;
        cursor: pointer;
        transition: .2s ease;
    }

    .subscription-page .sub-btn:hover {
        border-color: var(--sub-primary-hover);
        background: var(--sub-primary-hover);
        color: #182338 !important;
        box-shadow: 0 4px 12px rgba(247,176,3,.16);
    }

    .subscription-page .sub-btn.outline {
        border-color: var(--sub-border);
        background: transparent;
        color: var(--sub-title) !important;
    }

    .subscription-page .sub-btn.outline:hover {
        border-color: var(--sub-primary);
        background: var(--sub-primary-soft);
    }

    .subscription-page .sub-btn:disabled,
    .subscription-page .sub-btn.disabled {
        opacity: .6;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* =========================================================
    EMPTY STATE
    ========================================================= */

    .subscription-page .sub-no-results {
        display: none;
        padding: 38px 20px;
        border: 1px dashed var(--sub-border);
        border-radius: 14px;
        background: var(--sub-card);
        color: var(--sub-muted);
        text-align: center;
    }

    .subscription-page .sub-no-results > i {
        display: block;
        margin-bottom: 12px;
        color: var(--sub-primary);
        font-size: 34px;
    }

    .subscription-page .sub-no-results h5 {
        margin-bottom: 7px;
        color: var(--sub-title);
        font-size: 14px;
        font-weight: 800;
    }

    .subscription-page .sub-no-results p {
        margin: 0;
        font-size: 11px;
    }

    /* =========================================================
    INFORMATION BOX
    ========================================================= */

    .subscription-page .sub-info-box {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 17px 19px;
        margin-top: 23px;
        border: 1px solid var(--sub-border);
        border-radius: 12px;
        background: var(--sub-card);
        color: var(--sub-text);
    }

    .subscription-page .sub-info-box > i {
        flex-shrink: 0;
        color: var(--sub-primary);
        font-size: 21px;
    }

    .subscription-page .sub-info-box h6 {
        margin: 0 0 6px;
        color: var(--sub-title);
        font-size: 11px;
        font-weight: 800;
    }

    .subscription-page .sub-info-box p {
        margin: 0;
        color: var(--sub-muted);
        font-size: 11px;
        line-height: 1.8;
    }

    /* =========================================================
    FAQ
    ========================================================= */

    .subscription-page .sub-faq {
        margin-top: 35px;
    }

    .subscription-page .sub-faq-heading {
        margin-bottom: 16px;
    }

    .subscription-page .sub-faq-heading h3 {
        margin: 0 0 6px;
        color: var(--sub-title);
        font-size: 20px;
        font-weight: 800;
    }

    .subscription-page .sub-faq-heading p {
        margin: 0;
        color: var(--sub-muted);
        font-size: 11px;
    }

    .subscription-page .sub-faq-item {
        margin-bottom: 10px;
        overflow: hidden;
        border: 1px solid var(--sub-border);
        border-radius: 11px;
        background: var(--sub-card);
        color: var(--sub-text);
        transition: border-color .2s ease;
    }

    .subscription-page .sub-faq-item:has(.sub-faq-question.active) {
        border-color: rgba(247,176,3,.5);
    }

    .subscription-page .sub-faq-question {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        width: 100%;
        padding: 15px 17px;
        border: 0;
        background: transparent;
        color: var(--sub-title);
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .subscription-page .sub-faq-question i {
        flex-shrink: 0;
        color: var(--sub-muted);
        font-size: 18px;
        transition: transform .2s ease;
    }

    .subscription-page .sub-faq-question.active i {
        transform: rotate(180deg);
        color: var(--sub-primary);
    }

    .subscription-page .sub-faq-answer {
        display: none;
        padding: 0 17px 16px;
        background: transparent;
        color: var(--sub-muted);
        font-size: 11px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-faq-answer p {
        margin: 0;
    }

    /* =========================================================
    DARK MODE OVERRIDES
    Memaksa komponen Bootstrap mengikuti warna tema gelap
    ========================================================= */

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-hero,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-current,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-card,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-count,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-no-results,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-info-box,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-faq-item,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-filter {
        background-color: var(--sub-card) !important;
        border-color: var(--sub-border);
    }

    /* Card Bootstrap jika ada di dalam halaman subscription */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .card,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .card-header,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .card-body,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .card-footer {
        background-color: var(--sub-card) !important;
        border-color: var(--sub-border) !important;
        color: var(--sub-text) !important;
    }

    /* Utilitas Bootstrap yang sering menyebabkan card tetap putih */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .bg-white,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .bg-light {
        background-color: var(--sub-card) !important;
        color: var(--sub-text) !important;
    }

    /* Komponen Bootstrap accordion */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .accordion,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .accordion-item,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .accordion-header,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .accordion-button,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .accordion-body {
        background-color: var(--sub-card) !important;
        color: var(--sub-text) !important;
        border-color: var(--sub-border) !important;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .accordion-button:not(.collapsed) {
        color: var(--sub-title) !important;
        box-shadow: none;
    }

    /* Form controls */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page input,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page select,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page textarea {
        background-color: var(--sub-card) !important;
        color: var(--sub-title) !important;
        border-color: var(--sub-border) !important;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page input::placeholder,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page textarea::placeholder {
        color: var(--sub-muted) !important;
    }

    /* Teks Bootstrap */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .text-dark,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .text-body {
        color: var(--sub-text) !important;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .text-muted {
        color: var(--sub-muted) !important;
    }

    /* Filter aktif tetap mendapat aksen kuning */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-filter.active {
        background-color: var(--sub-primary-soft) !important;
        border-color: var(--sub-primary);
        color: var(--sub-title);
    }

    /* Paket unggulan tetap gelap, bukan kuning atau putih */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-card.featured {
        background-color: var(--sub-card) !important;
        border-color: var(--sub-primary);
        box-shadow: inset 0 3px 0 var(--sub-primary),
                    var(--sub-shadow);
    }

    /* Tombol outline */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-btn.outline {
        background-color: transparent !important;
        color: var(--sub-title) !important;
        border-color: var(--sub-border);
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-btn.outline:hover {
        background-color: var(--sub-primary-soft) !important;
        border-color: var(--sub-primary);
    }

    /* FAQ tetap gelap saat dibuka */
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-faq-question,
    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-faq-answer {
        background-color: transparent !important;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-faq-question {
        color: var(--sub-title) !important;
    }

    :is([data-bs-theme="dark"], .dark-layout, .dark-mode, [data-theme="dark"])
    .subscription-page .sub-faq-answer {
        color: var(--sub-muted) !important;
    }

    /* =========================================================
    RESPONSIVE
    ========================================================= */

    @media (max-width: 1199px) {
        .subscription-page .sub-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .subscription-page .sub-hero {
            padding: 23px 19px;
            border-radius: 13px;
        }

        .subscription-page .sub-hero h2 {
            font-size: 24px;
        }

        .subscription-page .sub-hero-bottom {
            gap: 11px;
        }

        .subscription-page .sub-current {
            padding: 15px;
        }

        .subscription-page .sub-current-left {
            align-items: flex-start;
        }

        .subscription-page .sub-current-icon {
            width: 41px;
            height: 41px;
            font-size: 19px;
        }

        .subscription-page .sub-current > .sub-status {
            display: none;
        }

        .subscription-page .sub-section-heading h3 {
            font-size: 18px;
        }

        .subscription-page .sub-toolbar {
            align-items: stretch;
        }

        .subscription-page .sub-search {
            width: 100%;
        }

        .subscription-page .sub-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .subscription-page .sub-card {
            padding: 20px;
        }

        .subscription-page .sub-price {
            font-size: 26px;
        }
    }

    /* =========================================================
    REDUCED MOTION
    ========================================================= */

    @media (prefers-reduced-motion: reduce) {
        .subscription-page *,
        .subscription-page *::before,
        .subscription-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet">
@endsection

@section('content')
    @php
        $currentSubscription = $currentSubscription ?? null;
        $subscriptions = $subscriptions ?? collect();
        $faqs = $faqs ?? collect();

        $currentSubscriptionActive = $currentSubscription
            && $currentSubscription->status === 'active'
            && (
                !$currentSubscription->end_date
                || \Carbon\Carbon::parse($currentSubscription->end_date)->endOfDay()->gte(now())
            );
    @endphp

    <div class="subscription-page">

        {{-- HERO --}}
        <div class="sub-hero">
            <div class="sub-hero-content">
                <div class="sub-hero-label">
                    <i class="bx bx-crown"></i>
                    PAKET BERLANGGANAN
                </div>

                <h2>Pilih Paket yang Tepat<br>untuk Kebutuhan Anda</h2>

                <p>
                    Nikmati fitur dan layanan sesuai kebutuhan Anda.
                    Pilih paket berlangganan yang tersedia dan tingkatkan pengalaman
                    penggunaan platform Anda.
                </p>

                <div class="sub-hero-bottom">
                    <span><i class="bx bx-check-circle"></i> Pilihan paket fleksibel</span>
                    <span><i class="bx bx-shield-quarter"></i> Pembayaran terverifikasi</span>
                    <span><i class="bx bx-support"></i> Dukungan pengguna</span>
                </div>
            </div>
        </div>

        @php
            /*
            |--------------------------------------------------------------------------
            | PAKET GRATIS DEFAULT
            |--------------------------------------------------------------------------
            | Jika tidak ada langganan aktif, cari paket dengan harga 0.
            */
            $freeSubscription = isset($subscriptions)
                ? $subscriptions->first(function ($subscription) {
                    return (float) ($subscription->price ?? 0) === 0.0;
                })
                : null;

            /*
            |--------------------------------------------------------------------------
            | NAMA PAKET YANG DITAMPILKAN
            |--------------------------------------------------------------------------
            */
            $currentPlanName = $currentSubscription->subscription->name
                ?? $currentSubscription->subscription_name
                ?? $currentSubscription->name
                ?? 'Paket Aktif';

            $freePlanName = $freeSubscription->name ?? 'Paket Gratis';

            /*
            |--------------------------------------------------------------------------
            | MASA AKTIF LANGGANAN
            |--------------------------------------------------------------------------
            | Menggunakan expired_at sesuai struktur tabel user_subscriptions.
            */
            $subscriptionExpiredAt = $currentSubscription->expired_at ?? null;
        @endphp

        {{-- PAKET AKTIF --}}
        @if ($currentSubscriptionActive)

            <div class="sub-current">
                <div class="sub-current-left">
                    <div class="sub-current-icon">
                        <i class="bx bx-badge-check"></i>
                    </div>

                    <div>
                        <h5>
                            Anda sedang berlangganan {{ $currentPlanName }}
                        </h5>

                        <p>
                            @if ($subscriptionExpiredAt)
                                Masa aktif hingga
                                {{ \Carbon\Carbon::parse($subscriptionExpiredAt)->translatedFormat('d F Y') }}.
                            @else
                                Langganan Anda sedang aktif.
                            @endif

                            Anda dapat melihat paket lain yang tersedia di bawah ini.
                        </p>

                        <div style="margin-top:9px">
                            <span class="sub-status">
                                <i class="bx bx-check-circle"></i>
                                Langganan Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <span class="sub-status">
                    <i class="bx bx-check-circle"></i>
                    Aktif
                </span>
            </div>

        @elseif ($freeSubscription)

            {{-- PAKET GRATIS DEFAULT JIKA BELUM ADA LANGGANAN AKTIF --}}
            <div class="sub-current">
                <div class="sub-current-left">
                    <div class="sub-current-icon">
                        <i class="bx bx-package"></i>
                    </div>

                    <div>
                        <h5>
                            Anda dapat memulai dengan {{ $freePlanName }}
                        </h5>

                        <p>
                            Paket gratis tersedia untuk Anda dengan biaya
                            Rp0. Pilih paket ini untuk memulai menggunakan layanan.
                        </p>

                        <div style="margin-top:9px">
                            <span class="sub-status">
                                <i class="bx bx-check-circle"></i>
                                Paket Gratis
                            </span>
                        </div>
                    </div>
                </div>

                <span class="sub-status">
                    <i class="bx bx-check-circle"></i>
                    Rp0
                </span>
            </div>

        @else

            {{-- BELUM ADA LANGGANAN DAN PAKET GRATIS BELUM TERSEDIA --}}
            <div class="sub-current">
                <div class="sub-current-left">
                    <div class="sub-current-icon">
                        <i class="bx bx-package"></i>
                    </div>

                    <div>
                        <h5>Belum Ada Paket Aktif</h5>
                        <p>
                            Pilih salah satu paket di bawah untuk mulai berlangganan.
                        </p>
                    </div>
                </div>

                <span class="sub-status inactive">
                    <i class="bx bx-info-circle"></i>
                    Belum Berlangganan
                </span>
            </div>

        @endif

        {{-- HEADER DAFTAR PAKET --}}
        <div class="sub-section-heading">
            <div>
                <h3>Temukan Paket Anda</h3>
                <p>Pilih paket yang sesuai dengan kebutuhan dan anggaran Anda.</p>
            </div>

            <div class="sub-count">
                <span id="sub-visible-count">{{ $subscriptions->count() }}</span>
                Paket Tersedia
            </div>
        </div>

        {{-- FILTER DAN SEARCH --}}
        <div class="sub-toolbar">
            <div class="sub-filters">
                <button type="button" class="sub-filter active" data-filter="all">
                    Semua Paket
                </button>

                {{-- <button type="button" class="sub-filter" data-filter="affordable">
                    Harga Terjangkau
                </button>

                <button type="button" class="sub-filter" data-filter="premium">
                    Premium
                </button> --}}
            </div>

            <div class="sub-search">
                <i class="bx bx-search"></i>
                <input type="text" id="sub-search-input" placeholder="Cari nama paket...">
            </div>
        </div>

        {{-- DAFTAR PAKET --}}
        <div class="sub-grid" id="sub-grid">
            @forelse($subscriptions as $index => $subscription)
                @php
                    $price = (float) ($subscription->price ?? 0);
                    $duration = strtolower((string) ($subscription->duration ?? 'month'));

                    $durationLabel = match ($duration) {
                        'day' => 'hari',
                        'year' => 'tahun',
                        default => 'bulan',
                    };

                    $features = $subscription->features ?? [];

                    if (is_string($features)) {
                        $features = json_decode($features, true) ?? [];
                    }

                    if (!is_array($features)) {
                        $features = [];
                    }

                    $description = $subscription->description ?? 'Paket berlangganan untuk mendukung kebutuhan Anda.';

                    $planName = $subscription->name ?? 'Paket Berlangganan';

                    $isCurrentPlan = $currentSubscriptionActive
                        && (
                            ($currentSubscription->subscription_id ?? null) == $subscription->id
                            || ($currentSubscription->master_subscription_id ?? null) == $subscription->id
                            || ($currentSubscription->subscription->id ?? null) == $subscription->id
                        );

                    $searchText = strtolower($planName . ' ' . $description . ' ' . implode(' ', array_map(
                        fn($feature) => is_scalar($feature) ? (string) $feature : '',
                        $features
                    )));

                    $planCategory = $price <= 100000 ? 'affordable' : 'premium';
                @endphp

                <div class="sub-card {{ $index === 1 ? 'featured' : '' }}"
                    data-name="{{ strtolower($planName) }}"
                    data-search="{{ $searchText }}"
                    data-category="{{ $planCategory }}"
                    data-price="{{ $price }}">

                    @if($index === 1)
                        <div class="sub-popular">
                            <i class="bx bxs-star"></i> PILIHAN POPULER
                        </div>
                    @endif

                    <div class="sub-card-top">
                        <div class="sub-plan-icon">
                            @if($index === 0)
                                <i class="bx bx-leaf"></i>
                            @elseif($index === 1)
                                <i class="bx bx-rocket"></i>
                            @else
                                <i class="bx bx-crown"></i>
                            @endif
                        </div>

                        <div>
                            <h4 class="sub-plan-name">{{ $planName }}</h4>
                            <p class="sub-plan-caption">Paket berlangganan</p>
                        </div>
                    </div>

                    <div class="sub-price">
                        Rp {{ number_format($price, 0, ',', '.') }}
                        <small>/ {{ $durationLabel }}</small>
                    </div>

                    <div class="sub-price-note">
                        Durasi berlangganan {{ $subscription->duration ?? 30 }}
                        {{ $durationLabel }}
                    </div>

                    <div class="sub-divider"></div>

                    <p class="sub-description">
                        {{ $description }}
                    </p>

                    <div class="sub-feature-title">Fitur yang Anda dapatkan</div>

                    <ul class="sub-features">
                        @php
                            /*
                            |--------------------------------------------------------------------------
                            | NORMALISASI FEATURES
                            |--------------------------------------------------------------------------
                            */
                            $features = $subscription->features ?? [];

                            if (is_string($features)) {
                                $features = json_decode($features, true) ?? [];
                            }

                            if (!is_array($features)) {
                                $features = [];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | LABEL FEATURE
                            |--------------------------------------------------------------------------
                            */
                            $featureLabels = [
                                'job_vacancy' => 'Lamaran aktif',
                                'training' => 'Pelatihan aktif',
                                'video_bimtek' => 'Video Bimtek',
                            ];
                        @endphp

                        @forelse ($features as $featureKey => $feature)
                            @php
                                /*
                                |--------------------------------------------------------------------------
                                | NORMALISASI DATA FEATURE
                                |--------------------------------------------------------------------------
                                */
                                if (is_array($feature)) {
                                    $enabled = filter_var(
                                        $feature['enabled'] ?? false,
                                        FILTER_VALIDATE_BOOLEAN
                                    );

                                    $limit = (int) ($feature['limit'] ?? -2);

                                    $featureLabel = $featureLabels[$featureKey]
                                        ?? ($feature['name'] ?? ucwords(
                                            str_replace('_', ' ', (string) $featureKey)
                                        ));
                                } else {
                                    // Mendukung format feature sederhana berupa string atau angka.
                                    $enabled = true;
                                    $limit = -1;

                                    $featureLabel = is_string($feature) || is_numeric($feature)
                                        ? (string) $feature
                                        : ucwords(str_replace('_', ' ', (string) $featureKey));
                                }
                            @endphp

                            @if (is_string($feature) || is_numeric($feature) || is_array($feature))
                                <li>
                                    {{-- ICON DAN NAMA FEATURE --}}
                                    @if (!$enabled || (is_array($feature) && $limit === -2))
                                        <i class="bx bx-x-circle"></i>
                                    @else
                                        <i class="bx bx-check-circle"></i>
                                    @endif

                                    <span>
                                        {{ $featureLabel }}

                                        {{-- STATUS DAN LIMIT FEATURE --}}
                                        @if (is_array($feature))
                                            @if (!$enabled || $limit === -2)
                                                <small>(Tidak tersedia)</small>
                                            @elseif ($limit === -1)
                                                <small>(Unlimited)</small>
                                            @else
                                                <small>({{ number_format($limit, 0, ',', '.') }})</small>
                                            @endif
                                        @endif
                                    </span>
                                </li>
                            @endif
                        @empty
                            <li>
                                <i class="bx bx-check-circle"></i>
                                <span>Akses layanan sesuai paket yang dipilih</span>
                            </li>
                        @endforelse
                    </ul>

                    <div class="sub-card-bottom">
                        @if($isCurrentPlan)
                            <button type="button" class="sub-btn disabled" disabled>
                                <i class="bx bx-check-circle"></i>
                                Paket Sedang Digunakan
                            </button>
                        @else
                            <form action="{{ route('user-page.subscription.order.store') }}"
                                method="POST"
                                class="sub-subscribe-form">
                                @csrf

                                <input type="hidden"
                                    name="subscription_uuid"
                                    value="{{ $subscription->uuid }}">

                                <button type="button"
                                        class="sub-btn {{ $index === 1 ? '' : 'outline' }} btn-subscribe"
                                        data-name="{{ $planName }}"
                                        data-price="{{ number_format($price, 0, ',', '.') }}"
                                        data-duration="{{ $durationLabel }}">
                                    Pilih Paket
                                    <i class="bx bx-right-arrow-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;padding:35px 20px;text-align:center;border:1px dashed var(--sub-border);border-radius:18px;color:var(--sub-muted)">
                    <i class="bx bx-package" style="font-size:40px"></i>
                    <h5 style="margin-top:10px;color:var(--sub-text)">Belum Ada Paket Berlangganan</h5>
                    <p style="font-size:12px;margin-bottom:0">
                        Saat ini belum ada paket yang tersedia untuk akun Anda.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="sub-no-results" id="sub-no-results">
            <i class="bx bx-search-alt"></i>
            <h5>Paket Tidak Ditemukan</h5>
            <p>Coba gunakan kata kunci lain atau pilih filter yang berbeda.</p>
        </div>

        {{-- INFORMASI PEMBAYARAN --}}
        <div class="sub-info-box">
            <i class="bx bx-info-circle"></i>
            <div>
                <h6>Informasi Berlangganan</h6>
                <p>
                    Pastikan Anda memilih paket yang sesuai sebelum melanjutkan.
                    Pengajuan berlangganan akan diproses sesuai mekanisme pembayaran
                    dan verifikasi yang berlaku pada platform.
                </p>
            </div>
        </div>

        {{-- FAQ --}}
        @if($faqs->count())
            <div class="sub-faq">
                <div class="sub-faq-heading">
                    <h3>Pertanyaan yang Sering Diajukan</h3>
                    <p>Informasi singkat untuk membantu Anda memilih paket.</p>
                </div>

                @foreach($faqs as $faq)
                    <div class="sub-faq-item">
                        <button type="button" class="sub-faq-question">
                            <span>{{ $faq->title }}</span>
                            <i class="bx bx-chevron-down"></i>
                        </button>

                        <div class="sub-faq-answer">
                            <p>{{ $faq->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        const $cards = $('.subscription-page .sub-card');
        let activeFilter = 'all';

        function filterSubscriptions() {
            const keyword = ($('#sub-search-input').val() || '').toLowerCase().trim();
            let visibleCount = 0;

            $cards.each(function () {
                const $card = $(this);
                const name = String($card.data('name') || '').toLowerCase();
                const search = String($card.data('search') || name).toLowerCase();
                const category = String($card.data('category') || '');
                const price = Number($card.data('price') || 0);

                const matchesSearch =
                    !keyword ||
                    name.includes(keyword) ||
                    search.includes(keyword);

                let matchesFilter = true;

                if (activeFilter === 'affordable') {
                    matchesFilter = category === 'affordable';
                } else if (activeFilter === 'premium') {
                    matchesFilter = category === 'premium';
                }

                const visible = matchesSearch && matchesFilter;

                $card.toggle(visible);

                if (visible) {
                    visibleCount++;
                }
            });

            $('#sub-visible-count').text(visibleCount);
            $('#sub-no-results').toggle(visibleCount === 0 && $cards.length > 0);
        }

        $('.sub-filter').on('click', function () {
            $('.sub-filter').removeClass('active');
            $(this).addClass('active');

            activeFilter = $(this).data('filter') || 'all';

            filterSubscriptions();
        });

        $('#sub-search-input').on('input', filterSubscriptions);

        // Konfirmasi sebelum mengirim pilihan paket.
        $(document).on('click', '.btn-subscribe', function () {
            const $button = $(this);
            const $form = $button.closest('form');

            const name = $button.data('name') || 'Paket Berlangganan';
            const price = $button.data('price') || '0';
            const duration = $button.data('duration') || 'bulan';

            // Menggunakan SweetAlert2 bila tersedia di layout.
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Paket',
                    html:
                        'Anda akan memilih paket <strong>' + escapeHtml(name) +
                        '</strong><br><br>' +
                        '<span style="color:var(--sub-muted)">Harga</span><br>' +
                        '<strong>Rp ' + escapeHtml(price) +
                        ' / ' + escapeHtml(duration) + '</strong>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Pilih Paket',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#39745a',
                    reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $button.prop('disabled', true);
                        $button.html('<i class="bx bx-loader-alt bx-spin"></i> Memproses...');
                        $form.trigger('submit');
                    }
                });
            } else {
                const confirmed = window.confirm(
                    'Pilih paket ' + name + ' dengan harga Rp ' +
                    price + ' / ' + duration + '?'
                );

                if (confirmed) {
                    $button.prop('disabled', true);
                    $button.text('Memproses...');
                    $form.trigger('submit');
                }
            }
        });

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // FAQ accordion.
        $('.sub-faq-question').on('click', function () {
            const $button = $(this);
            const $answer = $button.next('.sub-faq-answer');

            $button.toggleClass('active');
            $answer.stop(true, true).slideToggle(200);
        });

        // Tampilkan error validasi Laravel bila tersedia.
        @if($errors->any())
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Periksa kembali data',
                    text: @json($errors->first())
                });
            }
        @endif

        // Filter awal.
        filterSubscriptions();
    });
</script>
@endsection
