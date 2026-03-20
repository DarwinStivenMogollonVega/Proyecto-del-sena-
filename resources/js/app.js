import './bootstrap';

// Modo oscuro/claro: alternar y guardar preferencia
window.toggleTheme = function() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
};

// Al cargar, aplicar preferencia guardada
(function() {
    const saved = localStorage.getItem('theme');
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
    }
})();
