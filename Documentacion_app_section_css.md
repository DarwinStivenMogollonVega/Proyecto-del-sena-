# Documentación de app-section.css

A continuación se presenta el contenido completo del archivo `app-section.css` junto con una explicación pedagógica por bloques, para facilitar el aprendizaje y comprensión de los estilos globales de la aplicación.

---

## Código original

```css
/* app-section.css: Migración de estilos desde app.blade.php */

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
    --dz-link:            #ff7700;
    --dz-accent:          #c4864f;
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
    --dz-link:            #ff6a00;
    --dz-accent:          #c4864f;
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
```

**Explicación:**
- Variables CSS globales para colores, fondos, bordes, sombras y gradientes.
- Permiten cambiar entre modo claro y oscuro de forma centralizada.
- Facilitan la coherencia visual y la personalización de la aplicación.

---

```css
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
```

**Explicación:**
- Define la fuente principal, color de texto y altura mínima del body.
- Usa gradientes y fondos decorativos para dar profundidad y calidez.
- El fondo es fijo y transiciona suavemente al cambiar de tema.

---

```css
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
```

**Explicación:**
- Animación para transiciones de tema: aumenta saturación y brillo brevemente para dar feedback visual al usuario.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?