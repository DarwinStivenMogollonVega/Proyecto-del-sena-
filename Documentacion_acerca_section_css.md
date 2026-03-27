# Documentación de acerca-section.css

A continuación se presenta el contenido completo del archivo `acerca-section.css` junto con una explicación pedagógica por bloques, para facilitar el aprendizaje y comprensión de los estilos aplicados a la sección Acerca.

---

## Código original

```css
/* acerca-section.css: Estilos personalizados para la vista Acerca con soporte de temas */

/* =====================
     Variables globales y sistema de temas para Acerca (unificado)
     ===================== */
:root {
    --color-bg: #fff8f3;
    --color-card: #fff;
    --color-border: #e5e7eb;
    --color-text: #2d2d2d;
    --color-heading: #c46310; /* Naranja vibrante para headings y enlaces */
    --color-subtle: #475569;
    --color-primary: #c46310;
    --color-nav-link: var(--color-heading);
}
html[data-theme='dark'], .dark {
    --color-bg: #23272e;
    --color-card: #18181b;
    --color-border: #3a2415;
    --color-text: #f3e9e0;
    --color-heading: #ffcc70; /* Amarillo dorado para headings y enlaces en dark */
    --color-subtle: #cbd5e1;
    --color-primary: #fdf0e4;
    --color-nav-link: var(--color-heading);
}
html[data-theme='light'], .light {
    --color-bg: #fff8f3;
    --color-card: #fff;
    --color-border: #e5e7eb;
    --color-text: #23272e;
    --color-heading: #c46310; /* Naranja vibrante para headings y enlaces en light */
    --color-subtle: #475569;
    --color-primary: #fdf0e4;
    --color-nav-link: var(--color-heading);
}
```

**Explicación:**
- Variables CSS para colores de fondo, tarjetas, bordes, textos y acentos.
- Permite cambiar entre modo claro y oscuro de forma centralizada.
- Facilita la coherencia visual y la personalización de la sección.

---

```css
/* Unificar color de enlaces del navbar para modo claro y oscuro en acerca */
.navbar .nav-link,
.navbar .nav-cta-btn,
.navbar .dropdown-cta-btn,
.navbar .cart-cta-btn,
.navbar .nav-cta-text {
    color: var(--color-nav-link) !important;
}
html[data-theme='dark'] .navbar .nav-link,
html[data-theme='dark'] .navbar .nav-cta-btn,
html[data-theme='dark'] .navbar .dropdown-cta-btn,
html[data-theme='dark'] .navbar .cart-cta-btn,
html[data-theme='dark'] .navbar .nav-cta-text {
    color: var(--color-nav-link) !important;
}
```

**Explicación:**
- Unifica el color de los enlaces y botones del navbar para ambos temas.
- Usa la variable para mantener consistencia visual.

---

```css
.about-hero,
.about-hero h1,
.about-hero p,
.about-card,
.about-card h5,
.about-card p,
.about-block,
.about-block h4,
.about-block p,
.about-highlight {
    color: var(--color-text);
}
.about-hero h1,
.about-card h5,
.about-block h4 {
    color: var(--color-heading);
}
.about-card p,
.about-block p {
    color: var(--color-subtle);
}
.about-highlight {
    color: var(--color-primary);
    background: rgba(245, 158, 11, 0.13);
}
.about-card {
    background: var(--color-card);
    border: 1px solid var(--color-border);
}
.about-block {
    background: var(--color-bg);
    border: 1px solid var(--color-border);
}
```

**Explicación:**
- Aplica los colores definidos por variables a los textos y fondos principales de la sección Acerca.
- Mejora la legibilidad y mantiene la coherencia visual.

---

```css
/* Utilidades visuales unificadas para paneles */
.panel-bg-light { background: var(--color-card); }
.panel-title-primary { color: var(--color-primary); font-weight: 600; }
.panel-title-success { color: var(--color-success); font-weight: 600; }
.panel-title-warning { color: var(--color-warning, #f59e42); font-weight: 600; }
.panel-badge-primary { background: var(--color-primary); color: #fff; }
.panel-badge-success { background: var(--color-success); color: #fff; }
.panel-badge-warning { background: var(--color-warning, #f59e42); color: #fff; }
.panel-badge-muted { background: var(--color-subtle); color: #fff; }
```

**Explicación:**
- Utilidades para paneles: colores de fondo, títulos y badges para mantener consistencia visual y semántica.
- Permite destacar información relevante en paneles y tarjetas.

---

```css
/* Estilos de logos importados del index-section.css */
.store-hero-brand { ... }
.logo { ... }
.logo.logo-light { ... }
.logo.logo-dark { ... }
html[data-theme='dark'] .logo.logo-light { ... }
html[data-theme='dark'] .logo.logo-dark { ... }
html[data-theme='dark'] .logo-dark { ... }
html[data-theme='dark'] .logo-light { ... }
@media (max-width: 600px) { ... }
.hero-title { ... }
```

**Explicación:**
- Estilos para los logos y marcas, adaptando tamaño y visibilidad según el modo de tema y el tamaño de pantalla.
- Mejora la experiencia visual y la adaptabilidad.

---

```css
.about-hero { ... }
.about-hero img.logo-acerca { ... }
.about-hero h1 { ... }
.about-hero p { ... }
html[data-theme='dark'] .about-hero p { ... }
```

**Explicación:**
- Fondo decorativo, bordes redondeados, padding y sombra para la sección hero.
- Ajustes de color y tamaño para títulos y párrafos, con variantes para modo oscuro.

---

```css
.about-card { ... }
html[data-theme='dark'] .about-card { ... }
.about-card:hover { ... }
.about-card h5 { ... }
html[data-theme='dark'] .about-card h5 { ... }
.about-card p { ... }
html[data-theme='dark'] .about-card p { ... }
```

**Explicación:**
- Tarjetas informativas con fondo, borde y sombra, adaptadas a ambos temas.
- Efecto hover para resaltar la tarjeta.
- Ajustes de color y tamaño para títulos y párrafos.

---

```css
.about-block { ... }
.about-block h4 { ... }
html[data-theme='dark'] .about-block h4 { ... }
.about-block p { ... }
html[data-theme='dark'] .about-block p { ... }
.mb-2 { ... }
```

**Explicación:**
- Bloques de contenido con fondo decorativo, bordes redondeados y sombra.
- Ajustes de color y tamaño para títulos y párrafos, con variantes para modo oscuro.
- Clase utilitaria para margen inferior.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?