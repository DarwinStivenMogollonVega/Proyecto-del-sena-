<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Shop | DiscZone.com" />
    <meta name="author" content="DiscZone" />
    <meta name="description" content="Shop | DiscZone.com" />
    <meta name="keywords" content="Shop, DiscZone" />
    <title>@yield('titulo', 'Shop - DiscZone')</title>
    <script>
        (function () {
            var savedTheme = localStorage.getItem('dz-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.documentElement.setAttribute('data-bs-theme', savedTheme === 'dark' ? 'dark' : 'light');
        })();
    </script>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <style>
        /* ====================================================
           PALETA: café oscuro #160800 · mauve #b89990
                   naranja quemado #c46310 · chocolate #4d2010
           ==================================================== */
        :root {
            color-scheme: light;
            --dz-body:            #fef8f3;
            --dz-surface:         #ffffff;
            --dz-surface-soft:    #fdf2ea;
            --dz-surface-muted:   #f8e6d4;
            --dz-border:          #e8cfc0;
            --dz-text:            #2e1508;
            --dz-muted:           #8a6a5c;
            --dz-text-muted:      #937a6c;
            --dz-heading:         #200c03;
            --dz-link:            #c46310;
            --dz-accent:          #c46310;
            --dz-accent-dark:     #4d2010;
            --dz-accent-soft:     #b89990;
            --dz-outline-btn-text:   #2e1508;
            --dz-outline-btn-border: #c0a090;
            --dz-page-grad-1:     #fef8f3;
            --dz-page-grad-2:     #fdf2e8;
            --dz-page-grad-3:     #fdeee0;
            --dz-overlay-1:       rgba(196, 99, 16, 0.10);
            --dz-overlay-2:       rgba(184, 153, 144, 0.12);
            --dz-shadow:          0 14px 35px rgba(46, 18, 6, 0.08);
            --dz-shadow-strong:   0 18px 44px rgba(46, 18, 6, 0.14);
            --dz-navbar-grad-1:   #160800;
            --dz-navbar-grad-2:   #c46310;
            --dz-navbar-shadow:   0 12px 28px rgba(22, 8, 0, 0.30);
            --dz-footer-bg:       rgba(254, 248, 243, 0.90);
            --dz-footer-text:     #3a1a08;
            --dz-hero-overlay:    rgba(255, 255, 255, 0.10);
        }

        html[data-theme='dark'] {
            color-scheme: dark;
            --dz-body:            #0e0400;
            --dz-surface:         #1a0800;
            --dz-surface-soft:    #240e04;
            --dz-surface-muted:   #2d1408;
            --dz-border:          #3d1e0a;
            --dz-text:            #f0e0d2;
            --dz-muted:           #b89990;
            --dz-text-muted:      #c4a898;
            --dz-heading:         #fdf0e4;
            --dz-link:            #e07a30;
            --dz-accent:          #e07a30;
            --dz-accent-dark:     #7c2810;
            --dz-accent-soft:     #b89990;
            --dz-outline-btn-text:   #f0e0d2;
            --dz-outline-btn-border: #6a3820;
            --dz-page-grad-1:     #0e0400;
            --dz-page-grad-2:     #160700;
            --dz-page-grad-3:     #1e0c04;
            --dz-overlay-1:       rgba(196, 99, 16, 0.12);
            --dz-overlay-2:       rgba(184, 153, 144, 0.10);
            --dz-shadow:          0 14px 35px rgba(0, 0, 0, 0.50);
            --dz-shadow-strong:   0 18px 44px rgba(0, 0, 0, 0.65);
            --dz-navbar-grad-1:   #0a0300;
            --dz-navbar-grad-2:   #7c2810;
            --dz-navbar-shadow:   0 12px 28px rgba(0, 0, 0, 0.55);
            --dz-footer-bg:       rgba(14, 4, 0, 0.93);
            --dz-footer-text:     #d4b4a4;
            --dz-hero-overlay:    rgba(196, 99, 16, 0.10);
        }

        body {
            font-family: 'Sora', sans-serif;
            color: var(--dz-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at 10% 12%, rgba(196, 99, 16, 0.14), transparent 28%),
                radial-gradient(circle at 85% 16%, rgba(184, 153, 144, 0.16), transparent 30%),
                linear-gradient(165deg, var(--dz-page-grad-1) 0%, var(--dz-page-grad-2) 45%, var(--dz-page-grad-3) 100%);
            background-attachment: fixed;
            transition: background 0.25s ease, color 0.25s ease;
        }

        html.theme-shifting body {
            animation: dzThemeShiftFlash 0.42s ease;
        }

        @keyframes dzThemeShiftFlash {
            0% {
                filter: saturate(1) brightness(1);
            }
            38% {
                filter: saturate(1.08) brightness(1.05);
            }
            100% {
                filter: saturate(1) brightness(1);
            }
        }

        html[data-theme='dark'] body {
            background:
                radial-gradient(circle at 10% 12%, rgba(196, 99, 16, 0.14), transparent 28%),
                radial-gradient(circle at 85% 16%, rgba(77, 32, 16, 0.20), transparent 30%),
                linear-gradient(165deg, var(--dz-page-grad-1) 0%, var(--dz-page-grad-2) 46%, var(--dz-page-grad-3) 100%);
        }

        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6 {
            color: var(--dz-heading);
        }

        p,
        li,
        label,
        small {
            color: inherit;
        }

        /* Solo enlaces de texto; excluye botones, nav y menús */
        a:not(.btn):not(.nav-link):not(.dropdown-item):not(.navbar-brand):not(.page-link) {
            color: var(--dz-link);
        }

        a:not(.btn):not(.nav-link):not(.dropdown-item):not(.navbar-brand):not(.page-link):hover {
            text-decoration: underline;
            opacity: 0.85;
        }

        .dz-main-content {
            flex: 1 0 auto;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        footer {
            flex-shrink: 0;
        }

        .dz-panel,
        .dz-surface {
            background: var(--dz-surface);
            border: 1px solid var(--dz-border);
            border-radius: 1rem;
            box-shadow: var(--dz-shadow);
        }

        .dz-panel {
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }

        .dz-panel:hover {
            transform: translateY(-2px);
            box-shadow: var(--dz-shadow-strong);
        }

        .dz-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 999px;
            padding: 0.3rem 0.7rem;
            background: var(--dz-surface-soft);
            border: 1px solid var(--dz-border);
            color: var(--dz-muted);
            font-size: 0.78rem;
            font-weight: 600;
        }

        .btn {
            border-radius: 0.8rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease, border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        }

        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, transparent 0%, rgba(255, 255, 255, 0.28) 28%, transparent 56%);
            transform: translateX(-140%);
            transition: transform 0.55s ease;
            pointer-events: none;
        }

        button:not(.btn-close):not(.navbar-toggler),
        input[type='submit'],
        input[type='button'],
        input[type='reset'] {
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease, border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        }

        .btn-primary {
            background: #c46310;
            border-color: #c46310;
            color: #fff;
            box-shadow: 0 10px 24px rgba(196, 99, 16, 0.32);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: #a85510;
            border-color: #a85510;
            color: #fff;
        }

        .btn-light {
            background: rgba(255, 255, 255, 0.96);
            border-color: rgba(255, 255, 255, 0.96);
            color: #200c03;
            box-shadow: 0 10px 24px rgba(46, 18, 6, 0.16);
        }

        .btn-light:hover,
        .btn-light:focus {
            background: #ffffff;
            border-color: #ffffff;
            color: #200c03;
        }

        .btn-outline-dark {
            color: var(--dz-outline-btn-text);
            border-color: var(--dz-outline-btn-border);
        }

        .btn-outline-dark:hover,
        .btn-outline-dark:focus {
            color: #ffffff;
            border-color: #200c03;
            background: #200c03;
        }

        .btn-dark,
        .btn-primary {
            box-shadow: 0 10px 24px rgba(46, 18, 6, 0.22);
        }

        .card,
        .table,
        .alert,
        .dropdown-menu,
        .modal-content,
        .list-group-item {
            border-radius: 0.9rem;
            border-color: var(--dz-border);
        }

        .card,
        .dropdown-menu,
        .modal-content,
        .alert,
        .list-group-item,
        .table-responsive {
            background: var(--dz-surface);
            box-shadow: var(--dz-shadow);
        }

        .pagination {
            gap: 0.25rem;
        }

        .pagination .page-link {
            border-radius: 0.65rem;
            background: var(--dz-surface);
            border-color: var(--dz-border);
            color: var(--dz-text);
        }

        .pagination .page-item.active .page-link {
            background: #c46310;
            border-color: #c46310;
            color: #fff;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--dz-text);
            color: var(--dz-text);
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            background-color: transparent;
            color: inherit;
            border-bottom-color: var(--dz-border);
        }

        .table thead th {
            color: var(--dz-muted);
            font-size: 0.78rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .table-hover > tbody > tr:hover > * {
            --bs-table-accent-bg: rgba(196, 99, 16, 0.07);
            color: var(--dz-text);
        }

        .table-striped > tbody > tr:nth-of-type(odd) > * {
            --bs-table-accent-bg: rgba(148, 163, 184, 0.08);
            color: var(--dz-text);
        }

        .form-control,
        .form-select {
            background: var(--dz-surface);
            border-color: var(--dz-border);
            color: var(--dz-text);
        }

        .form-control:focus,
        .form-select:focus {
            background: var(--dz-surface);
            color: var(--dz-text);
            border-color: rgba(196, 99, 16, 0.55);
            box-shadow: 0 0 0 0.2rem rgba(196, 99, 16, 0.16);
        }

        .form-control::placeholder,
        .form-select::placeholder {
            color: var(--dz-muted);
            opacity: 1;
        }

        .input-group-text {
            background: var(--dz-surface);
            border-color: var(--dz-border);
            color: var(--dz-muted);
        }

        .dropdown-menu {
            border: 1px solid var(--dz-border);
            box-shadow: var(--dz-shadow);
        }

        .dropdown-item {
            color: var(--dz-text);
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: var(--dz-surface-soft);
            color: var(--dz-heading);
        }

        .text-muted,
        .text-secondary,
        .text-body-secondary {
            color: var(--dz-muted) !important;
        }

        .bg-light-subtle {
            background: var(--dz-surface-soft) !important;
            color: var(--dz-text) !important;
        }

        img,
        video,
        svg {
            max-width: 100%;
            height: auto;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        html[data-theme='dark'] .card,
        html[data-theme='dark'] .dropdown-menu,
        html[data-theme='dark'] .list-group-item,
        html[data-theme='dark'] .table,
        html[data-theme='dark'] .table-responsive,
        html[data-theme='dark'] .form-control,
        html[data-theme='dark'] .form-select,
        html[data-theme='dark'] .input-group-text,
        html[data-theme='dark'] .modal-content,
        html[data-theme='dark'] .alert,
        html[data-theme='dark'] .dz-panel,
        html[data-theme='dark'] .dz-surface {
            background: #1a0800 !important;
            color: #f0e0d2 !important;
            border-color: #3d1e0a !important;
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.50);
        }

        html[data-theme='dark'] .table-striped > tbody > tr:nth-of-type(odd) > * {
            --bs-table-accent-bg: rgba(184, 153, 144, 0.08);
            color: #f0e0d2;
        }

        html[data-theme='dark'] .table-hover > tbody > tr:hover > * {
            --bs-table-accent-bg: rgba(196, 99, 16, 0.20);
            color: #fdf0e4;
        }

        html[data-theme='dark'] .pagination .page-link {
            background: #240e04;
            border-color: #3d1e0a;
            color: #d4b4a4;
        }

        html[data-theme='dark'] .pagination .page-item.active .page-link {
            background: #c46310;
            border-color: #c46310;
            color: #fff;
        }

        html[data-theme='dark'] .input-group-text {
            background: #240e04 !important;
            color: #d4b4a4 !important;
            border-color: #3d1e0a !important;
        }

        html[data-theme='dark'] .btn-primary {
            background: #c46310;
            border-color: #c46310;
            color: #fff;
        }

        html[data-theme='dark'] .btn-primary:hover,
        html[data-theme='dark'] .btn-primary:focus {
            background: #a85510;
            border-color: #a85510;
        }

        html[data-theme='dark'] .btn-light {
            background: #f8f0e8;
            border-color: #f8f0e8;
            color: #200c03;
        }

        html[data-theme='dark'] .btn-light:hover,
        html[data-theme='dark'] .btn-light:focus {
            background: #ffffff;
            border-color: #ffffff;
        }

        html[data-theme='dark'] .btn-outline-secondary {
            border-color: #6a3820;
            color: #f0e0d2;
        }

        html[data-theme='dark'] .btn-outline-secondary:hover {
            background: #3d1e0a;
            border-color: #3d1e0a;
            color: #fff;
        }

        html[data-theme='dark'] .dz-pill {
            background: #240e04;
            border-color: #3d1e0a;
            color: #d4b4a4;
        }

        html[data-theme='dark'] .text-muted,
        html[data-theme='dark'] .text-secondary,
        html[data-theme='dark'] .text-body-secondary {
            color: #c4a898 !important;
        }

        html[data-theme='dark'] .btn-outline-dark {
            color: #f0e0d2;
            border-color: #6a3820;
        }

        html[data-theme='dark'] .btn-outline-dark:hover,
        html[data-theme='dark'] .btn-outline-dark:focus {
            color: #fff;
            border-color: #fdf0e4;
            background: #200c03;
        }

        .theme-switch-btn {
            border-radius: 999px;
            font-weight: 600;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            width: 24rem;
            height: 24rem;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            filter: blur(40px);
            opacity: 0.1;
        }

        body::before {
            top: 4rem;
            left: -8rem;
            background: radial-gradient(circle, rgba(196, 99, 16, 0.22) 0%, rgba(196, 99, 16, 0) 72%);
            animation: dzOrbLeft 40s ease-in-out infinite;
        }

        body::after {
            right: -7rem;
            bottom: -7rem;
            background: radial-gradient(circle, rgba(77, 32, 16, 0.24) 0%, rgba(77, 32, 16, 0) 72%);
            animation: dzOrbRight 42s ease-in-out infinite;
        }

        .navbar,
        .dz-main-content,
        footer {
            position: relative;
            z-index: 1;
        }

        .dz-main-content > * {
            animation: dzFadeIn 0.35s ease;
        }

        .dz-panel,
        .dz-surface,
        .card,
        .alert,
        .table-responsive,
        .modal-content,
        .product-card,
        .category-card,
        .checkout-summary,
        .profile-card,
        .orders-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.14s ease, box-shadow 0.14s ease, border-color 0.14s ease, background-color 0.14s ease;
        }

        .dz-panel::before,
        .card::before,
        .product-card::before,
        .category-card::before,
        .checkout-summary::before,
        .profile-card::before,
        .orders-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, transparent 0%, rgba(255, 255, 255, 0.05) 32%, transparent 58%);
            transform: translateX(-135%);
            transition: transform 0.6s ease;
            pointer-events: none;
        }

        .dz-panel:hover,
        .card:hover,
        .product-card:hover,
        .category-card:hover,
        .checkout-summary:hover,
        .profile-card:hover,
        .orders-card:hover,
        .table-responsive:hover,
        .alert:hover {
            transform: translateY(-0.5px);
            box-shadow: var(--dz-shadow-strong);
        }

        .dz-panel:hover::before,
        .card:hover::before,
        .product-card:hover::before,
        .category-card:hover::before,
        .checkout-summary:hover::before,
        .profile-card:hover::before,
        .orders-card:hover::before {
            transform: translateX(130%);
        }

        .btn,
        .form-control,
        .form-select,
        .input-group-text,
        .nav-link,
        .page-link,
        .list-group-item {
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease, background-color 0.22s ease, color 0.22s ease;
        }

        .btn:hover,
        .btn:focus,
        .page-link:hover,
        .page-link:focus {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 16px 30px rgba(46, 18, 6, 0.20);
        }

        .btn:hover::before,
        .btn:focus::before {
            transform: translateX(135%);
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.14);
        }

        button:not(.btn-close):not(.navbar-toggler):hover,
        button:not(.btn-close):not(.navbar-toggler):focus,
        input[type='submit']:hover,
        input[type='submit']:focus,
        input[type='button']:hover,
        input[type='button']:focus,
        input[type='reset']:hover,
        input[type='reset']:focus {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 16px 30px rgba(46, 18, 6, 0.20);
        }

        button:not(.btn-close):not(.navbar-toggler):active,
        input[type='submit']:active,
        input[type='button']:active,
        input[type='reset']:active {
            transform: translateY(0);
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.14);
        }

        .btn:disabled,
        .btn.disabled {
            transform: none !important;
            box-shadow: none !important;
        }

        .btn:disabled::before,
        .btn.disabled::before {
            display: none;
        }

        button:disabled,
        input[type='submit']:disabled,
        input[type='button']:disabled,
        input[type='reset']:disabled {
            transform: none !important;
            box-shadow: none !important;
        }

        .form-control:hover,
        .form-select:hover,
        .input-group-text:hover {
            border-color: rgba(196, 99, 16, 0.32);
        }

        .table-hover > tbody > tr,
        .table tbody > tr {
            transition: transform 0.18s ease, background-color 0.18s ease;
        }

        .table-hover > tbody > tr:hover,
        .table tbody > tr:hover {
            transform: none;
        }

        .fx-reveal {
            opacity: 0;
            transform: translateY(4px);
            filter: blur(0);
        }

        .fx-reveal.fx-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
            transition: opacity 0.26s ease, transform 0.26s ease, filter 0.26s ease;
        }

        @keyframes dzFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes dzOrbLeft {
            0%,
            100% { transform: translate3d(0, 0, 0); }
            50% { transform: translate3d(4px, 4px, 0); }
        }

        @keyframes dzOrbRight {
            0%,
            100% { transform: translate3d(0, 0, 0); }
            50% { transform: translate3d(-4px, -3px, 0); }
        }

        @media (prefers-reduced-motion: reduce) {
            body::before,
            body::after,
            .dz-panel,
            .dz-surface,
            .card,
            .alert,
            .table-responsive,
            .modal-content,
            .product-card,
            .category-card,
            .checkout-summary,
            .profile-card,
            .orders-card,
            .btn,
            .form-control,
            .form-select,
            .input-group-text,
            .nav-link,
            .page-link,
            .list-group-item,
            .table-hover > tbody > tr,
            .table tbody > tr,
            .fx-reveal,
            .fx-reveal.fx-visible {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                filter: none !important;
                opacity: 1 !important;
            }

            html.theme-shifting body {
                animation: none !important;
            }
        }

        @media (max-width: 991.98px) {
            .dz-main-content .container,
            .dz-main-content .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .store-hero,
            .client-hero,
            .orders-hero,
            .profile-hero,
            .cart-hero,
            .checkout-hero {
                padding: 1.25rem !important;
            }
        }

        @media (max-width: 575.98px) {
            body {
                font-size: 0.95rem;
            }

            .btn {
                font-size: 0.92rem;
            }

            .product-card .card-img-top {
                height: 190px;
            }

            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            .table {
                font-size: 0.9rem;
            }
        }
    </style>
    @stack('estilos')
</head>
<body>
    @include('web.partials.nav')

    @if(View::hasSection('header'))
        @include('web.partials.header')
    @endif

    <main class="dz-main-content">
        @yield('contenido')
    </main>

    @include('web.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        (function () {
            function initSiteVisualFx() {
                var selectors = [
                    '.dz-main-content > *',
                    '.card',
                    '.dz-panel',
                    '.alert',
                    '.table-responsive',
                    '.product-card',
                    '.category-card',
                    '.checkout-summary',
                    '.profile-card',
                    '.orders-card',
                    '.store-hero',
                    '.client-hero',
                    '.orders-hero',
                    '.profile-hero',
                    '.cart-hero',
                    '.checkout-hero'
                ];

                var elements = Array.from(document.querySelectorAll(selectors.join(',')))
                    .filter(function (element, index, list) {
                        return element && list.indexOf(element) === index;
                    });

                if (!elements.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    return;
                }

                elements.forEach(function (element, index) {
                    element.classList.add('fx-reveal');
                    element.style.transitionDelay = Math.min(index * 8, 48) + 'ms';
                });

                var reveal = function (element) {
                    element.classList.add('fx-visible');
                };

                if (!('IntersectionObserver' in window)) {
                    requestAnimationFrame(function () {
                        elements.forEach(reveal);
                    });
                    return;
                }

                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        reveal(entry.target);
                        observer.unobserve(entry.target);
                    });
                }, { threshold: 0.04, rootMargin: '0px 0px -10px 0px' });

                requestAnimationFrame(function () {
                    elements.forEach(function (element) {
                        observer.observe(element);
                    });
                });
            }

            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                document.documentElement.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
                localStorage.setItem('dz-theme', theme);
                var buttons = document.querySelectorAll('[data-theme-toggle]');
                buttons.forEach(function (btn) {
                    var icon = btn.querySelector('i');
                    var label = btn.querySelector('[data-theme-label]');
                    if (icon) {
                        icon.className = theme === 'dark' ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
                    }
                    if (label) {
                        label.textContent = theme === 'dark' ? 'Oscuro' : 'Claro';
                    }
                });

                document.documentElement.classList.add('theme-shifting');
                clearTimeout(window.__dzThemeShiftTimer);
                window.__dzThemeShiftTimer = setTimeout(function () {
                    document.documentElement.classList.remove('theme-shifting');
                }, 430);
            }

            function initHoverDropdowns() {
                if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches || typeof bootstrap === 'undefined') {
                    return;
                }

                document.querySelectorAll('.navbar .dropdown').forEach(function (dropdown) {
                    var toggle = dropdown.querySelector('.dropdown-toggle');
                    if (!toggle) {
                        return;
                    }

                    var instance = bootstrap.Dropdown.getOrCreateInstance(toggle);
                    var hideTimer;

                    dropdown.addEventListener('mouseenter', function () {
                        if (hideTimer) {
                            clearTimeout(hideTimer);
                        }
                        instance.show();
                    });

                    dropdown.addEventListener('mouseleave', function () {
                        hideTimer = setTimeout(function () {
                            instance.hide();
                        }, 120);
                    });
                });
            }

            document.addEventListener('click', function (e) {
                var toggle = e.target.closest('[data-theme-toggle]');
                if (!toggle) {
                    return;
                }
                e.preventDefault();
                e.stopPropagation();
                /* Cooldown: ignora disparos rápidos (doble clic, tecla retenida, hold) */
                if (window.__dzThemeToggleLocked) {
                    return;
                }
                window.__dzThemeToggleLocked = true;
                setTimeout(function () {
                    window.__dzThemeToggleLocked = false;
                }, 700);
                toggle.classList.add('is-toggling');
                setTimeout(function () {
                    toggle.classList.remove('is-toggling');
                }, 460);
                var current = document.documentElement.getAttribute('data-theme') || 'light';
                applyTheme(current === 'dark' ? 'light' : 'dark');
            });

            applyTheme(document.documentElement.getAttribute('data-theme') || 'light');
            initSiteVisualFx();
            initHoverDropdowns();
        })();
    </script>
    @stack('scripts')
</body>
</html>
