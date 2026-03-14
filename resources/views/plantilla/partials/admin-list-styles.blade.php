<style>
    .admin-page-shell {
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-title: #0f172a;
        --admin-muted: #64748b;
    }

    .admin-page-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--admin-title);
        margin: 0;
    }

    .admin-page-subtitle {
        color: var(--admin-muted);
        margin: 0.2rem 0 0;
        font-size: 0.92rem;
    }

    .admin-list-card {
        border: 1px solid var(--admin-border);
        border-radius: 1rem;
        background: var(--admin-surface);
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .admin-list-card .card-header {
        border-bottom: 1px solid var(--admin-border);
        background: linear-gradient(120deg, #f8fafc, #fff7ed);
        padding: 1rem 1.1rem;
    }

    .admin-list-card .card-body {
        padding: 1.1rem;
    }

    .admin-toolbar {
        border: 1px solid var(--admin-border);
        border-radius: 0.9rem;
        background: #f8fafc;
        padding: 0.85rem;
    }

    .admin-table {
        margin-bottom: 0;
    }

    .admin-table thead th {
        text-transform: uppercase;
        font-size: 0.76rem;
        letter-spacing: 0.04em;
        color: var(--admin-muted);
        font-weight: 700;
        border-bottom-width: 1px;
        white-space: nowrap;
    }

    .admin-table tbody td {
        vertical-align: middle;
    }

    .admin-action-btn {
        border-radius: 0.55rem;
    }

    html[data-theme='dark'] .admin-page-shell {
        --admin-surface: #0f172a;
        --admin-border: #2b3a52;
        --admin-title: #f8fafc;
        --admin-muted: #b7c3d5;
    }

    html[data-theme='dark'] .admin-list-card .card-header {
        background: linear-gradient(120deg, #111b2e, #1b273a);
        border-bottom-color: #2b3a52;
    }

    html[data-theme='dark'] .admin-toolbar {
        background: #111b2e;
        border-color: #2b3a52;
    }

    html[data-theme='dark'] .admin-table thead th {
        color: #cbd5e1;
        border-bottom-color: #334155;
    }

    html[data-theme='dark'] .admin-table tbody tr:hover > * {
        background-color: #182336 !important;
    }
</style>
