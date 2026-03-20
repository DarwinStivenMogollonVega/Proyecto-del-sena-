<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('titulo', 'Sistema')</title>
    <script>
      (function () {
        var savedTheme = localStorage.getItem('dz-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        document.documentElement.setAttribute('data-bs-theme', savedTheme === 'dark' ? 'dark' : 'light');
      })();
    </script>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Sistema | IncanatoApps.com" />
    <meta name="author" content="IncanatoApps" />
    <meta
      name="description"
      content="Sistema."
    />
    <meta
      name="keywords"
      content="Sistema, IncanatoApps"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('css/adminlte.css')}}" />
    <!--end::Required Plugin(AdminLTE)-->
    <style>
      :root {
        color-scheme: light;
        --auth-surface: rgba(255, 255, 255, 0.92);
        --auth-surface-strong: #ffffff;
        --auth-border: #e8cfc0;
        --auth-text: #2e1508;
        --auth-muted: #8a6a5c;
        --auth-heading: #200c03;
        --auth-link: #c46310;
        --auth-primary: #c46310;
        --auth-primary-contrast: #ffffff;
        --auth-accent: #c46310;
        --auth-shadow: 0 24px 60px rgba(196, 99, 16, 0.18);
        --auth-glass: rgba(254, 248, 243, 0.72);
      }

      /* Modo oscuro global inspirado en perfil */
      html[data-theme='dark'] {
        color-scheme: dark;
        --auth-surface: #111827;
        --auth-surface-strong: #111827;
        --auth-border: #334155;
        --auth-text: #f0e0d2;
        --auth-muted: #b89990;
        --auth-heading: #fdf0e4;
        --auth-link: #e07a30;
        --auth-primary: #c46310;
        --auth-primary-contrast: #ffffff;
        --auth-accent: #e07a30;
        --auth-shadow: 0 24px 60px rgba(2, 6, 23, 0.55);
        --auth-glass: rgba(31, 41, 55, 0.65);
      }

      html[data-theme='dark'] .auth-shell {
        background: radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.15), transparent 30%), radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.14), transparent 28%), linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
      }
      html[data-theme='dark'] .auth-card {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
      }
      html[data-theme='dark'] .auth-form-panel {
        background: transparent;
      }
      html[data-theme='dark'] .auth-summary-panel {
        background: linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
        color: #fff;
      }
      html[data-theme='dark'] .summary-title,
      html[data-theme='dark'] .summary-copy,
      html[data-theme='dark'] .summary-pill strong,
      html[data-theme='dark'] .summary-pill span,
      html[data-theme='dark'] .summary-list li {
        color: #fff !important;
      }

      body.dz-auth-page {
        min-height: 100vh;
        margin: 0;
        font-family: 'Sora', 'Source Sans 3', sans-serif;
        color: var(--auth-text);
        background:
          radial-gradient(circle at 10% 12%, rgba(196, 99, 16, 0.14), transparent 28%),
          radial-gradient(circle at 85% 16%, rgba(184, 153, 144, 0.16), transparent 30%),
          linear-gradient(165deg, #fef8f3 0%, #fdf2e8 46%, #fdeee0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
      }

      html[data-theme='dark'] body.dz-auth-page {
        background:
          radial-gradient(circle at 10% 12%, rgba(196, 99, 16, 0.14), transparent 28%),
          radial-gradient(circle at 85% 16%, rgba(77, 32, 16, 0.20), transparent 30%),
          linear-gradient(165deg, #0e0400 0%, #160700 46%, #1e0c04 100%);
      }

      .login-box,
      .register-box {
        width: min(1080px, 100%);
        margin: 0;
      }

      .auth-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(280px, 0.95fr);
        background: var(--auth-glass);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        box-shadow: var(--auth-shadow);
        overflow: hidden;
      }

      .auth-form-panel,
      .auth-summary-panel {
        min-width: 0;
      }

      .auth-form-panel {
        background: var(--auth-surface-strong);
        padding: 2rem;
      }

      .auth-summary-panel {
        padding: 2rem;
        color: #fff;
        background:
          radial-gradient(circle at top left, rgba(196, 99, 16, 0.40), transparent 38%),
          radial-gradient(circle at 78% 80%, rgba(77, 32, 16, 0.45), transparent 40%),
          linear-gradient(145deg, #160800 0%, #c46310 52%, #4d2010 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 1.5rem;
      }

      .auth-card {
        border: 1px solid var(--auth-border);
        border-radius: 1.15rem;
        background: var(--auth-surface);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.08);
      }

      html[data-theme='dark'] .auth-card {
        box-shadow: 0 14px 36px rgba(2, 6, 23, 0.34);
      }

      .auth-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: var(--auth-heading) !important;
      }

      .auth-brand-mark {
        width: 2.6rem;
        height: 2.6rem;
        border-radius: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #c46310, #4d2010);
        color: #fff;
        box-shadow: 0 12px 28px rgba(196, 99, 16, 0.34);
      }

      .auth-brand-mark-full {
        width: 10.6rem;
        height: 3rem;
        border-radius: 0.7rem;
        padding: 0.18rem 0.28rem;
      }

      .auth-brand-mark-icon {
        display: none;
      }

      .auth-brand-icon {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 0.65rem;
      }

      @media (max-width: 575.98px) {
        .auth-brand {
          gap: 0.6rem;
        }

        .auth-brand-mark-full {
          display: none;
        }

        .auth-brand-mark-icon {
          display: inline-flex;
        }
      }

      .auth-heading {
        color: var(--auth-heading);
        font-weight: 700;
      }

      .auth-copy,
      .login-box-msg,
      .register-box-msg {
        color: var(--auth-muted) !important;
      }

      .auth-form-panel .form-control,
      .auth-form-panel .input-group-text {
        border-color: var(--auth-border);
        background: var(--auth-surface-strong);
        color: var(--auth-text);
      }

      .auth-form-panel .form-control {
        border-right: 0;
      }

      .auth-form-panel .input-group-text {
        border-left: 0;
      }

      .auth-form-panel .form-control:focus {
        border-color: rgba(196, 99, 16, 0.55);
        box-shadow: 0 0 0 0.22rem rgba(196, 99, 16, 0.14);
      }

      .auth-form-panel .form-floating > label {
        color: var(--auth-muted);
      }

      .auth-btn-primary {
        background: #c46310;
        border-color: #c46310;
        color: #ffffff;
        border-radius: 0.85rem;
        font-weight: 700;
        padding: 0.8rem 1.1rem;
        box-shadow: 0 12px 28px rgba(196, 99, 16, 0.32);
      }

      .auth-btn-primary:hover,
      .auth-btn-primary:focus {
        background: #a85510;
        border-color: #a85510;
        color: #fff;
      }

      html[data-theme='dark'] .auth-btn-primary:hover,
      html[data-theme='dark'] .auth-btn-primary:focus {
        background: #e07a30;
        border-color: #e07a30;
        color: #fff;
      }

      .auth-link,
      .auth-form-panel a:not(.btn) {
        color: var(--auth-link);
      }

      .summary-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ffffff;
      }

      .summary-kicker-icon {
        width: 1rem;
        height: 1rem;
        object-fit: cover;
        border-radius: 50%;
      }

      .summary-title {
        color: #fff;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 700;
        line-height: 1.05;
      }

      .summary-copy {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.98rem;
      }

      .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.85rem;
      }

      .summary-pill {
        padding: 0.95rem;
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.14);
      }

      .summary-pill strong {
        display: block;
        font-size: 1rem;
        margin-bottom: 0.2rem;
      }

      .summary-pill span {
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.82rem;
      }

      .summary-list {
        display: grid;
        gap: 0.75rem;
        padding: 0;
        margin: 0;
        list-style: none;
      }

      .summary-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
        color: rgba(255, 255, 255, 0.86);
      }

      .summary-list i {
        color: #fde68a;
        margin-top: 0.1rem;
      }

      .summary-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #fff;
        text-decoration: none;
        font-weight: 700;
      }

      .summary-cta:hover {
        color: #fff;
        opacity: 0.9;
      }

      @media (max-width: 991.98px) {
        .auth-shell {
          grid-template-columns: 1fr;
        }

        .auth-form-panel,
        .auth-summary-panel {
          padding: 1.5rem;
        }
      }

      @media (max-width: 575.98px) {
        body.dz-auth-page {
          padding: 1rem;
        }

        .auth-shell,
        .auth-card {
          border-radius: 1.1rem;
        }

        .summary-grid {
          grid-template-columns: 1fr;
        }
      }

      body.dz-auth-page::before,
      body.dz-auth-page::after {
        content: '';
        position: fixed;
        width: 24rem;
        height: 24rem;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        filter: blur(42px);
        opacity: 0.1;
      }

      body.dz-auth-page::before {
        top: -7rem;
        left: -6rem;
        background: radial-gradient(circle, rgba(196, 99, 16, 0.22) 0%, rgba(196, 99, 16, 0) 72%);
        animation: authFloatOne 40s ease-in-out infinite;
      }

      body.dz-auth-page::after {
        right: -7rem;
        bottom: -7rem;
        background: radial-gradient(circle, rgba(77, 32, 16, 0.28) 0%, rgba(77, 32, 16, 0) 72%);
        animation: authFloatTwo 42s ease-in-out infinite;
      }

      .login-box {
        position: relative;
        z-index: 1;
      }

      .auth-shell,
      .auth-card,
      .auth-form-panel,
      .auth-summary-panel,
      .auth-btn-primary,
      .form-control,
      .input-group-text {
        /* transition: transform 0.14s ease, box-shadow 0.14s ease, border-color 0.14s ease, background-color 0.14s ease; */
      }

      .auth-shell,
      .auth-card,
      .auth-summary-panel {
        overflow: hidden;
      }

      /* Eliminado el brillito al pasar el ratón */
      .auth-shell::before,
      .auth-card::before,
      .auth-summary-panel::before {
        display: none !important;
      }

      .auth-shell:hover,
      .auth-card:hover,
      .auth-summary-panel:hover {
        transform: none !important;
      }

      .auth-shell:hover::before,
      .auth-card:hover::before,
      .auth-summary-panel:hover::before {
        transform: none !important;
      }

      .auth-btn-primary:hover,
      .auth-btn-primary:focus {
        transform: none;
      }

      .form-control:hover,
      .input-group-text:hover {
        border-color: rgba(196, 99, 16, 0.34);
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
        transition: opacity 0.24s ease, transform 0.24s ease, filter 0.24s ease;
      }

      @keyframes authFloatOne {
        0%,
        100% { transform: translate3d(0, 0, 0); }
        50% { transform: translate3d(4px, 4px, 0); }
      }

      @keyframes authFloatTwo {
        0%,
        100% { transform: translate3d(0, 0, 0); }
        50% { transform: translate3d(-4px, -3px, 0); }
      }

      @media (prefers-reduced-motion: reduce) {
        body.dz-auth-page::before,
        body.dz-auth-page::after,
        .auth-shell,
        .auth-card,
        .auth-form-panel,
        .auth-summary-panel,
        .auth-btn-primary,
        .form-control,
        .input-group-text,
        .fx-reveal,
        .fx-reveal.fx-visible {
          animation: none !important;
          transition: none !important;
          transform: none !important;
          filter: none !important;
          opacity: 1 !important;
        }
      }
    </style>
    @stack('estilos')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="login-page dz-auth-page">
    <div class="login-box">
      @yield('contenido')
    </div>
    <!-- /.login-box -->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{asset('js/adminlte.js')}}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };

      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
    @stack('scripts')
  </body>
  <!--end::Body-->
</html>
