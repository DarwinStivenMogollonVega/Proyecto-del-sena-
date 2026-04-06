<!doctype html>
<html lang="es">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistema</title>
    <script>
      (function () {
        var savedTheme = localStorage.getItem('dz-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        document.documentElement.setAttribute('data-bs-theme', savedTheme === 'dark' ? 'dark' : 'light');
      })();
    </script>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Sistema | ArtCode.com" />
    <meta name="author" content="ArtCode" />
    <meta
      name="description"
      content="Sistema."
    />
    <meta name="keywords" content="Sistema, ArtCode" />
    <!-- Sticky actions column for small screens -->
    <style>
      @media (max-width: 768px) {
        .table-responsive { overflow: visible; }
        th.actions-col,
        td.actions-col {
          position: -webkit-sticky;
          position: sticky;
          right: 0;
          background: var(--adm-surface);
          z-index: 1051;
          box-shadow: -8px 0 18px rgba(15,23,42,0.06);
          min-width: 72px;
          vertical-align: middle;
        }
        th.actions-col { text-align: right; }
        td.actions-col .btn { min-width: 40px; }
      }
    </style>
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
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
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
    <style>
      :root {
        color-scheme: light;
        --adm-body-bg: #f4f7fb;
        --adm-surface: #ffffff;
        --adm-surface-soft: #ffffff; /* usar blanco en modo light */
        --adm-border: #dbe4ef;
        --adm-text: #172033;
        --adm-muted: #607086;
        --adm-heading: #0f172a;
        --adm-accent: #1d4ed8;
        --adm-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        --adm-header-bg: rgba(255, 255, 255, 0.82);
        --adm-footer-bg: rgba(255, 255, 255, 0.78);
        --adm-sidebar-bg: linear-gradient(180deg, #0f172a 0%, #162032 52%, #1a2540 100%);
        --adm-sidebar-border: rgba(255, 255, 255, 0.08);
        --adm-sidebar-divider: rgba(255, 255, 255, 0.12);
        --adm-sidebar-text: rgba(226, 232, 240, 0.9);
        --adm-sidebar-muted: rgba(226, 232, 240, 0.68);
        --adm-sidebar-active-bg: rgba(255, 255, 255, 0.08);
        --adm-sidebar-active-text: #ffffff;
        --adm-sidebar-panel: rgba(255, 255, 255, 0.03);
      }

      html[data-theme='dark'] {
        --adm-body-bg: #0b1220;
        --adm-surface: #111827;
        --adm-surface-soft: #162133;
        --adm-border: #273244;
        --adm-text: #e5e7eb;
        --adm-muted: #a8b5c7;
        --adm-heading: #f8fafc;
        --adm-accent: #93c5fd;
        --adm-shadow: 0 12px 30px rgba(2, 6, 23, 0.3);
        --adm-header-bg: rgba(8, 17, 31, 0.82);
        --adm-footer-bg: rgba(8, 17, 31, 0.76);
        --adm-sidebar-bg: linear-gradient(180deg, #08111f 0%, #0f1727 52%, #111827 100%);
        --adm-sidebar-border: rgba(148, 163, 184, 0.14);
        --adm-sidebar-divider: rgba(148, 163, 184, 0.18);
        --adm-sidebar-text: rgba(226, 232, 240, 0.92);
        --adm-sidebar-muted: rgba(203, 213, 225, 0.72);
        --adm-sidebar-active-bg: rgba(148, 163, 184, 0.12);
        --adm-sidebar-active-text: #ffffff;
        --adm-sidebar-panel: rgba(148, 163, 184, 0.05);
      }

      /* === Light-mode: separar colores de "soft" y botones === */
      html[data-theme='light'] {
        /* aseguramos que los paneles suaves usen blanco */
        --adm-surface-soft: #ffffff;
      }

      /* Forzar fondos blancos en botones del sidebar y header en modo light */
      html[data-theme='light'] .dz-admin-sidebar .nav-treeview,
      html[data-theme='light'] .dz-admin-sidebar .nav-treeview .nav-link,
      html[data-theme='light'] .dz-admin-sidebar .nav-link {
        background: #162133 !important; /* background requested */
        color: #ffffff !important; /* ensure contrast */
        border: 1px solid #162133 !important; /* border requested */
        box-shadow: none !important;
      }

      html[data-theme='light'] .app-header .nav-link,
      html[data-theme='light'] .app-header .navbar-nav .nav-link.admin-profile-btn {
        background: #ffffff !important;
        color: var(--adm-text) !important;
        border-radius: .6rem;
      }

      /* Responsive sidebar color adjustments */
      /* On small screens prefer a simpler, high-contrast solid background */
      @media (max-width: 767.98px) {
        :root {
          --adm-sidebar-bg: linear-gradient(180deg, #0b1220 0%, #0f1727 100%);
          --adm-sidebar-text: rgba(226,232,240,0.96);
          --adm-sidebar-muted: rgba(226,232,240,0.72);
          --adm-sidebar-active-bg: rgba(255,255,255,0.06);
          --adm-sidebar-panel: rgba(255,255,255,0.02);
        }

        html[data-theme='dark'] {
          --adm-sidebar-bg: linear-gradient(180deg, #07101a 0%, #0b1220 100%);
          --adm-sidebar-text: rgba(229,231,235,0.98);
          --adm-sidebar-muted: rgba(203,213,225,0.76);
          --adm-sidebar-active-bg: rgba(148,163,184,0.10);
          --adm-sidebar-panel: rgba(148,163,184,0.03);
        }
      }

      /* Slightly different palette when the sidebar is collapsed (narrow) */
      @media (max-width: 992px) {
        .app-sidebar {
          box-shadow: inset -1px 0 0 var(--adm-sidebar-border), 8px 0 18px rgba(2,6,23,0.08);
        }
        .app-sidebar .nav-link p { opacity: 0.98; }
      }

      body.admin-shell {
        background:
          linear-gradient(180deg, rgba(255, 255, 255, 0.35), transparent 16%),
          var(--adm-body-bg);
        color: var(--adm-text);
      }

      html[data-theme='dark'] body.admin-shell {
        background:
          linear-gradient(180deg, rgba(148, 163, 184, 0.06), transparent 18%),
          var(--adm-body-bg);
      }

      .app-main,
      .app-content-header,
      .app-footer,
      .app-header,
      .card,
      .dropdown-menu,
      .modal-content,
      .alert,
      .table-responsive,
      .list-group-item,
      .form-control,
      .form-select,
      .input-group-text {
        color: var(--adm-text);
      }

      .app-header {
        background: var(--adm-headerheader-bg);
        border-bottom: 1px solid var(--adm-border);
        backdrop-filter: blur(10px);
      }

      .app-header .nav-link,
      .app-header .navbar-nav .nav-link,
      .app-footer,
      .app-content-header,
      .text-body,
      .text-muted,
      .text-body-secondary {
        color: var(--adm-text) !important;
      }

      .app-content-header {
        color: var(--adm-muted) !important;
      }

      .app-footer {
        background: var(--adm-footer-bg);
        border-top: 1px solid var(--adm-border);
        backdrop-filter: blur(10px);
      }

      .card,
      .dropdown-menu,
      .modal-content,
      .alert,
      .list-group-item,
      .table-responsive {
        background: var(--adm-surface);
        border-color: var(--adm-border);
        box-shadow: var(--adm-shadow);
        border-radius: 1rem;
      }

      .card-header,
      .modal-header,
      .modal-footer {
        border-color: var(--adm-border);
      }

      .card-header:not(.bg-dark):not(.bg-primary):not(.bg-danger) {
        background: var(--adm-surface);
      }

      .table {
        --bs-table-bg: transparent;
        --bs-table-color: var(--adm-text);
        margin-bottom: 0;
      }

      .table > :not(caption) > * > * {
        background-color: transparent;
        color: inherit;
        border-bottom-color: var(--adm-border);
      }

      .table thead th {
        color: var(--adm-muted);
        font-size: 0.78rem;
        letter-spacing: 0.03em;
        text-transform: uppercase;
      }

      .table-hover > tbody > tr:hover > * {
        --bs-table-accent-bg: rgba(29, 78, 216, 0.05);
      }

      .form-control,
      .form-select,
      .input-group-text {
        background: var(--adm-surface);
        border-color: var(--adm-border);
      }

      .form-control:focus,
      .form-select:focus {
        background: var(--adm-surface);
        color: var(--adm-text);
        border-color: rgba(59, 130, 246, 0.45);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.14);
      }

      .dropdown-item {
        color: var(--adm-text);
      }

      .dropdown-item:hover,
      .dropdown-item:focus {
        background: var(--adm-surface-soft);
        color: var(--adm-heading);
      }

      .pagination .page-link {
        background: var(--adm-surface);
        border-color: var(--adm-border);
        color: var(--adm-text);
      }

      .pagination .page-item.active .page-link {
        background: var(--adm-accent);
        border-color: var(--adm-accent);
        color: #fff;
      }

      .modal-footer .btn-outline-light,
      .modal-header .btn-outline-light {
        color: var(--adm-text);
        border-color: var(--adm-border);
      }

      .modal-footer .btn-outline-light:hover,
      .modal-header .btn-outline-light:hover,
      .modal-footer .btn-outline-light:focus,
      .modal-header .btn-outline-light:focus {
        background: var(--adm-surface-soft);
        border-color: var(--adm-border);
        color: var(--adm-heading);
      }

      .app-sidebar {
        background: var(--adm-sidebar-bg);
        border-right: 1px solid var(--adm-sidebar-border);
        box-shadow: inset -1px 0 0 var(--adm-sidebar-border), 16px 0 32px rgba(2, 6, 23, 0.14);
      }

      .app-sidebar .sidebar-brand {
        border-bottom: 1px solid var(--adm-sidebar-border);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent);
      }

      .app-sidebar .brand-link,
      .app-sidebar .nav-link,
      .app-sidebar .nav-header,
      .app-sidebar .nav-icon,
      .app-sidebar .nav-arrow,
      .app-sidebar .brand-text {
        color: var(--adm-sidebar-text) !important;
      }

      .app-sidebar .brand-link {
        padding: 1rem 0.95rem 1rem 0.9rem;
      }

      .app-sidebar .brand-link .brand-project-logo {
        width: 132px;
        max-width: 100%;
        height: auto;
        object-fit: contain;
        margin-right: 0.55rem;
      }
      .logo-dis-music.light { display: block; }
      .logo-dis-music.dark { display: none; }
      html[data-theme='dark'] .logo-dis-music.light { display: none; }
      html[data-theme='dark'] .logo-dis-music.dark { display: block; }
      }

      .app-sidebar .brand-link .brand-project-logo-icon {
        width: 2.1rem;
        height: 2.1rem;
        border-radius: 50%;
        object-fit: cover;
        display: none;
      }

      .app-sidebar .brand-text {
        font-size: 0.8rem;
        font-weight: 700 !important;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #f8fafc !important;
      }

      @media (max-width: 575.98px) {
        .app-sidebar .brand-link .brand-project-logo-full {
          display: none;
        }

        .app-sidebar .brand-link .brand-project-logo-icon {
          display: inline-block;
        }

        .app-sidebar .brand-text {
          display: none;
        }
      }

      .app-sidebar .sidebar-wrapper {
        padding: 0.8rem 0.7rem 1rem;
      }

      .app-sidebar .sidebar-menu {
        gap: 0.18rem;
      }

      .app-sidebar .nav-link:hover,
      .app-sidebar .nav-link:focus,
      .app-sidebar .nav-link.active,
      .app-sidebar .nav-item.menu-open > .nav-link {
        background: var(--adm-sidebar-active-bg);
        color: var(--adm-sidebar-active-text) !important;
        border-radius: 0.9rem;
      }

      .app-sidebar .nav-treeview .nav-link {
        color: var(--adm-sidebar-muted) !important;
      }

      .app-sidebar .nav-link {
        position: relative;
        border: 1px solid transparent;
        border-radius: 0.9rem;
        margin-bottom: 0.2rem;
        min-height: 2.95rem;
        padding: 0.72rem 0.82rem;
        background: transparent;
      }

      .app-sidebar .nav-link::before {
        content: '';
        position: absolute;
        left: 0.45rem;
        top: 0.6rem;
        bottom: 0.6rem;
        width: 2px;
        border-radius: 999px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(148, 163, 184, 0.36));
        opacity: 0;
        transition: opacity 0.18s ease, transform 0.18s ease;
        transform: scaleY(0.45);
      }

      .app-sidebar .nav-link p {
        font-size: 0.9rem;
        font-weight: 650;
        letter-spacing: 0.01em;
      }

      .app-sidebar .nav-treeview {
        margin-top: 0.1rem;
        padding-left: 0.45rem;
      }

      .app-sidebar .nav-treeview .nav-link {
        min-height: 2.6rem;
        padding-left: 0.9rem;
      }

      .app-sidebar .nav-treeview .nav-link p {
        font-size: 0.82rem;
        font-weight: 560;
      }

      .app-sidebar .nav-link:hover,
      .app-sidebar .nav-link:focus {
        border-color: rgba(255, 255, 255, 0.06);
        background: var(--adm-sidebar-panel);
      }

      .app-sidebar .nav-link.active,
      .app-sidebar .nav-item.menu-open > .nav-link {
        border-color: rgba(255, 255, 255, 0.08);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.03);
      }

      .app-sidebar .nav-link.active::before,
      .app-sidebar .nav-item.menu-open > .nav-link::before,
      .app-sidebar .nav-link:hover::before,
      .app-sidebar .nav-link:focus::before {
        opacity: 1;
        transform: scaleY(1);
      }

      /* Mobile sidebar off-canvas behaviour */
      @media (max-width: 991.98px) {
        .app-sidebar {
          position: fixed;
          top: 0;
          left: 0;
          height: 100vh;
          width: 18rem;
          transform: translateX(-110%);
          transition: transform 0.28s ease, box-shadow 0.18s ease;
          z-index: 1050;
        }

        body.sidebar-open .app-sidebar {
          transform: translateX(0);
          box-shadow: 0 24px 48px rgba(2,6,23,0.28);
        }

        .sidebar-mobile-backdrop {
          position: fixed;
          inset: 0;
          background: rgba(2,6,23,0.45);
          opacity: 0;
          visibility: hidden;
          transition: opacity 0.22s ease, visibility 0.22s ease;
          z-index: 1040;
        }

        body.sidebar-open .sidebar-mobile-backdrop {
          opacity: 1;
          visibility: visible;
        }

        /* When sidebar is hidden adjust main content spacing */
        .app-main {
          transition: margin-left 0.28s ease;
        }
      }

      .app-sidebar .nav-header.dz-sidebar-section {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.85rem 0.78rem 0.45rem;
        margin: 0.1rem 0 0.15rem;
        font-size: 0.64rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--adm-sidebar-muted) !important;
      }

      .app-sidebar .nav-header.dz-sidebar-section::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, var(--adm-sidebar-divider), transparent);
      }

      .app-sidebar .dz-sidebar-divider {
        list-style: none;
        height: 1px;
        margin: 0.45rem 0.78rem 0.65rem;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.14), transparent);
        opacity: 0.9;
      }

      .admin-theme-toggle {
        border-radius: 999px;
        border: 1px solid var(--adm-border);
        background: var(--adm-surface);
        color: var(--adm-text);
        font-weight: 700;
      }

      .admin-theme-toggle:hover,
      .admin-theme-toggle:focus {
        background: var(--adm-surface-soft);
        color: var(--adm-heading);
      }

      .app-header .navbar-nav .nav-link.admin-profile-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid var(--adm-border);
        background: var(--adm-surface);
        color: var(--adm-text) !important;
        border-radius: 999px;
        padding: 0.36rem 0.7rem;
        font-weight: 700;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
      }

      .admin-profile-meta {
        display: flex;
        flex-direction: column;
        min-width: 0;
        line-height: 1.08;
      }

      .app-header .navbar-nav .nav-link.admin-profile-btn.dropdown-toggle::after {
        display: none;
      }

      .admin-profile-avatar {
        width: 1.85rem;
        height: 1.85rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(29, 78, 216, 0.18), rgba(249, 115, 22, 0.18));
        border: 1px solid rgba(59, 130, 246, 0.28);
        color: var(--adm-heading);
        font-size: 0.82rem;
        font-weight: 800;
      }

      /* image inside profile avatar */
      .admin-profile-avatar-img {
        width: 1.85rem;
        height: 1.85rem;
        border-radius: 999px;
        object-fit: cover;
        display: inline-block;
        vertical-align: middle;
      }

      .admin-profile-name {
        max-width: 12rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.83rem;
      }

      .admin-profile-role {
        font-size: 0.67rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        color: var(--adm-muted);
      }

      .admin-profile-caret {
        font-size: 0.76rem;
        opacity: 0.72;
        transition: transform 0.22s ease, opacity 0.2s ease;
      }

      .app-header .navbar-nav .nav-link.admin-profile-btn:hover,
      .app-header .navbar-nav .nav-link.admin-profile-btn:focus,
      .app-header .navbar-nav .show > .nav-link.admin-profile-btn,
      .app-header .navbar-nav .nav-link.admin-profile-btn.show {
        background: var(--adm-surface-soft);
        border-color: rgba(59, 130, 246, 0.32);
        color: var(--adm-heading) !important;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.1);
      }

      .app-header .navbar-nav .show > .nav-link.admin-profile-btn .admin-profile-caret,
      .app-header .navbar-nav .nav-link.admin-profile-btn.show .admin-profile-caret {
        transform: rotate(180deg);
        opacity: 1;
      }

      html[data-theme='dark'] .app-header .navbar-nav .nav-link.admin-profile-btn {
        background: rgba(148, 163, 184, 0.1);
        border-color: rgba(148, 163, 184, 0.28);
      }

      html[data-theme='dark'] .admin-profile-avatar {
        background: linear-gradient(135deg, rgba(147, 197, 253, 0.2), rgba(251, 146, 60, 0.2));
        border-color: rgba(148, 163, 184, 0.3);
        color: #f8fafc;
      }

      html[data-theme='dark'] .app-header .navbar-nav .nav-link.admin-profile-btn:hover,
      html[data-theme='dark'] .app-header .navbar-nav .nav-link.admin-profile-btn:focus,
      html[data-theme='dark'] .app-header .navbar-nav .show > .nav-link.admin-profile-btn,
      html[data-theme='dark'] .app-header .navbar-nav .nav-link.admin-profile-btn.show {
        background: rgba(148, 163, 184, 0.2);
        border-color: rgba(148, 163, 184, 0.38);
      }

      html[data-theme='dark'] .admin-profile-role {
        color: #cbd5e1;
      }

      .app-header .user-menu .dropdown-menu {
        width: 21rem;
        padding: 0;
        border: 1px solid var(--adm-border);
        overflow: hidden;
      }

      .admin-user-header {
        margin: 0;
        padding: 1rem 1rem 0.9rem;
        text-align: center;
        background:
          linear-gradient(145deg, rgba(37, 99, 235, 0.96), rgba(29, 78, 216, 0.95)),
          radial-gradient(circle at 85% 10%, rgba(255, 255, 255, 0.25), transparent 45%);
        color: #fff;
      }

      .admin-user-avatar-lg {
        width: 3.1rem;
        height: 3.1rem;
        margin: 0 auto 0.55rem;
        border-radius: 999px;
        display: grid;
        place-items: center;
        font-size: 1.02rem;
        font-weight: 800;
        color: #0f172a;
        background: linear-gradient(135deg, #f8fafc, #dbeafe);
        border: 2px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 10px 20px rgba(2, 6, 23, 0.2);
      }

      .admin-user-avatar-lg img { width:100%; height:100%; border-radius:999px; object-fit:cover; }

      .admin-user-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        letter-spacing: 0.01em;
      }

      .admin-user-email {
        margin: 0.2rem 0 0.55rem;
        font-size: 0.81rem;
        color: rgba(255, 255, 255, 0.88);
      }

      .admin-user-badges {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.4rem;
      }

      .admin-user-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.28rem 0.58rem;
        font-size: 0.7rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.28);
        color: #fff;
      }

      .admin-user-quick-links {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.7rem;
        padding: 0.9rem 1rem;
        background: var(--adm-surface);
      }

      .admin-user-quick-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        text-decoration: none;
        border-radius: 0.65rem;
        border: 1px solid var(--adm-border);
        background: var(--adm-surface-soft);
        color: var(--adm-text);
        font-weight: 700;
        font-size: 0.79rem;
        padding: 0.48rem 0.4rem;
      }

      .admin-user-quick-link:hover,
      .admin-user-quick-link:focus {
        color: var(--adm-heading);
        border-color: rgba(59, 130, 246, 0.36);
        background: color-mix(in srgb, var(--adm-surface-soft) 88%, rgba(59, 130, 246, 0.18));
      }

      .admin-user-quick-link i {
        font-size: 0.88rem;
      }

      .app-header .user-menu .user-footer {
        display: flex;
        justify-content: space-between;
        gap: 0.7rem;
        padding: 0.85rem 1rem 1rem;
        border-top: 1px solid var(--adm-border);
        background: var(--adm-surface);
      }

      .app-header .user-menu .user-footer .admin-user-action {
        flex: 1;
        border-radius: 0.7rem;
        border: 1px solid var(--adm-border);
        background: var(--adm-surface-soft);
        color: var(--adm-text);
        font-weight: 700;
      }

      .app-header .user-menu .user-footer .admin-user-logout {
        color: #b42318;
        border-color: color-mix(in srgb, var(--adm-border) 70%, #ef4444 30%);
      }

      html[data-theme='dark'] .admin-user-header {
        background:
          linear-gradient(145deg, rgba(37, 99, 235, 0.9), rgba(30, 64, 175, 0.88)),
          radial-gradient(circle at 85% 10%, rgba(255, 255, 255, 0.16), transparent 45%);
      }

      html[data-theme='dark'] .admin-user-avatar-lg {
        color: #111827;
        background: linear-gradient(135deg, #e2e8f0, #bfdbfe);
      }

      html[data-theme='dark'] .admin-user-quick-link {
        background: rgba(148, 163, 184, 0.12);
        border-color: rgba(148, 163, 184, 0.28);
      }

      html[data-theme='dark'] .app-header .user-menu .user-footer .admin-user-action {
        background: rgba(148, 163, 184, 0.12);
        border-color: rgba(148, 163, 184, 0.28);
      }

      @media (max-width: 575.98px) {
        .app-header .user-menu .dropdown-menu {
          width: min(92vw, 21rem);
        }
      }

      body.admin-shell::before,
      body.admin-shell::after {
        content: '';
        position: fixed;
        inset: auto;
        width: 16rem;
        height: 16rem;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        filter: blur(42px);
        opacity: 0.08;
      }

      body.admin-shell::before {
        top: 5rem;
        right: -7rem;
        background: radial-gradient(circle, rgba(29, 78, 216, 0.11) 0%, rgba(29, 78, 216, 0) 72%);
      }

      body.admin-shell::after {
        bottom: -6rem;
        left: -6rem;
        background: radial-gradient(circle, rgba(249, 115, 22, 0.11) 0%, rgba(249, 115, 22, 0) 72%);
      }

      .app-wrapper,
      .app-main,
      .app-content,
      .app-content-header,
      .app-footer {
        position: relative;
        z-index: 1;
      }

      .card,
      .table-responsive,
      .modal-content,
      .dropdown-menu,
      .alert {
        overflow: hidden;
      }

      .card::before,
      .table-responsive::before,
      .modal-content::before,
      .alert::before {
        content: '';
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.42), transparent);
        opacity: 0.2;
        pointer-events: none;
      }

      .card,
      .table-responsive,
      .modal-content,
      .dropdown-menu,
      .alert,
      .btn,
      .form-control,
      .form-select,
      .input-group-text,
      .app-sidebar .nav-link {
        transition: box-shadow 0.18s ease, border-color 0.18s ease, background-color 0.18s ease, color 0.18s ease, opacity 0.18s ease, filter 0.18s ease;
      }

      .card:hover,
      .table-responsive:hover,
      .modal-content:hover,
      .alert:hover {
        box-shadow: 0 16px 28px rgba(15, 23, 42, 0.07);
        border-color: color-mix(in srgb, var(--adm-accent) 10%, var(--adm-border));
      }

      .btn:hover,
      .btn:focus {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.18);
      }

      button:not(.btn-close):not(.navbar-toggler):hover,
      button:not(.btn-close):not(.navbar-toggler):focus,
      input[type='submit']:hover,
      input[type='submit']:focus,
      input[type='button']:hover,
      input[type='button']:focus,
      input[type='reset']:hover,
      input[type='reset']:focus {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.18);
      }

      .btn:active {
        transform: translateY(0);
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.14);
      }

      button:not(.btn-close):not(.navbar-toggler):active,
      input[type='submit']:active,
      input[type='button']:active,
      input[type='reset']:active {
        transform: translateY(0);
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.14);
      }

      .btn:disabled,
      .btn.disabled {
        transform: none !important;
        box-shadow: none !important;
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
        border-color: rgba(59, 130, 246, 0.36);
      }

      .table-hover > tbody > tr {
        transition: background-color 0.18s ease, box-shadow 0.18s ease;
      }

      .table-hover > tbody > tr:hover {
        box-shadow: inset 0 1px 0 rgba(59, 130, 246, 0.04), inset 0 -1px 0 rgba(59, 130, 246, 0.04);
      }

      .fx-reveal {
        opacity: 0;
        filter: saturate(0.92);
      }

      .fx-reveal.fx-visible {
        opacity: 1;
        filter: saturate(1);
        transition: opacity 0.24s ease, filter 0.24s ease;
      }

      @media (prefers-reduced-motion: reduce) {
        body.admin-shell::before,
        body.admin-shell::after,
        .card,
        .table-responsive,
        .modal-content,
        .dropdown-menu,
        .alert,
        .btn,
        button,
        input[type='submit'],
        input[type='button'],
        input[type='reset'],
        .form-control,
        .form-select,
        .input-group-text,
        .app-sidebar .nav-link,
        .table-hover > tbody > tr,
        .fx-reveal,
        .fx-reveal.fx-visible {
          animation: none !important;
          transition: none !important;
          filter: none !important;
          opacity: 1 !important;
        }
      }
    </style>
    @stack('estilos')
    <style>
      /* Vertical actions layout for very small screens */
      @media (max-width: 768px) {
        .actions-col .d-flex {
          flex-direction: column !important;
          gap: .45rem !important;
          align-items: center !important;
          justify-content: center !important;
        }
        .actions-col .btn {
          width: 40px !important;
          height: 40px !important;
          padding: .35rem !important;
          display: inline-flex !important;
          align-items: center !important;
          justify-content: center !important;
        }
        th.actions-col { text-align: center !important; }
        td.actions-col { padding: .25rem .5rem !important; }
      }
    </style>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg admin-shell">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      @hasSection('header')
        @yield('header')
      @else
        @include('plantilla.header')
      @endif
      <!--end::Header-->
      <!--begin::Sidebar-->
      @include('plantilla.menu')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">

          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        @yield('contenido')
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2026&nbsp;
          <a href="#" class="text-decoration-none">DiscMusic</a>.
        </strong>
        Todos los derechos reservados.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
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
      function applyAdminTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
        localStorage.setItem('dz-theme', theme);
        document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
          var icon = button.querySelector('i');
          var label = button.querySelector('[data-theme-label]');
          if (icon) {
            icon.className = theme === 'dark' ? 'bi bi-moon-stars-fill me-1' : 'bi bi-sun-fill me-1';
          }
          if (label) {
            label.textContent = theme === 'dark' ? 'Oscuro' : 'Claro';
          }
        });
      }

      function initAdminVisualFx() {
        var selectors = [
          '.app-content > *',
          '.card',
          '.table-responsive',
          '.alert',
          '.modal-content',
          '.dropdown-menu',
          '.app-footer',
          '.app-content-header',
          '.app-sidebar .nav-item'
        ];

        var elements = Array.from(document.querySelectorAll(selectors.join(',')))
          .filter(function (element, index, list) {
            return element && list.indexOf(element) === index;
          });

        if (!elements.length) {
          return;
        }

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
          return;
        }

        elements.forEach(function (element, index) {
          element.classList.add('fx-reveal');
          element.style.transitionDelay = Math.min(index * 8, 36) + 'ms';
        });

        requestAnimationFrame(function () {
          elements.forEach(function (element) {
            element.classList.add('fx-visible');
          });
        });
      }

      function initAdminHoverDropdowns() {
        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches || typeof bootstrap === 'undefined') {
          return;
        }

        document.querySelectorAll('.dropdown').forEach(function (dropdown) {
          if (dropdown.classList.contains('user-menu')) {
            return;
          }

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

      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: document.documentElement.getAttribute('data-theme') === 'dark' ? 'os-theme-dark' : 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        applyAdminTheme(document.documentElement.getAttribute('data-theme') || 'light');
        initAdminVisualFx();
        initAdminHoverDropdowns();

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

        document.addEventListener('click', function (event) {
          var toggle = event.target.closest('[data-theme-toggle]');
          if (!toggle) {
            return;
          }

          event.preventDefault();
          event.stopPropagation();

          /* Cooldown: ignora disparos rápidos (doble clic, tecla retenida, hold) */
          if (window.__dzAdminThemeToggleLocked) {
            return;
          }
          window.__dzAdminThemeToggleLocked = true;
          setTimeout(function () {
            window.__dzAdminThemeToggleLocked = false;
          }, 700);

          var currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
          applyAdminTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });

        // Sidebar mobile toggle
        document.querySelectorAll('[data-sidebar-toggle]').forEach(function(btn){
          btn.addEventListener('click', function(ev){
            ev.preventDefault();
            document.body.classList.toggle('sidebar-open');
          });
        });

        var sidebarBackdrop = document.getElementById('sidebarBackdrop');
        if (sidebarBackdrop) {
          sidebarBackdrop.addEventListener('click', function(){
            document.body.classList.remove('sidebar-open');
          });
        }

        // Close sidebar on escape
        document.addEventListener('keydown', function(e){
          if (e.key === 'Escape') {
            document.body.classList.remove('sidebar-open');
          }
        });
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
    @stack('modals')
    @stack('scripts')
  </body>
  <!--end::Body-->
</html>
