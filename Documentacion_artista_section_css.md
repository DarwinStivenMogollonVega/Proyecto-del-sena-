# Documentación de artista-section.css

A continuación se presenta el contenido completo del archivo `artista-section.css` junto con una explicación pedagógica por bloques, para facilitar el aprendizaje y comprensión de los estilos aplicados a la sección de artista.

---

## Código original

```css
/* =====================
   Variables de color base para texto accesible (artista)
   ===================== */
/* =====================
   Variables globales para artista (panel de control, coherencia visual)
   ===================== */
:root {
  --color-bg: #f8fafc;
  --color-card: #fff;
  --color-border: #e5e7eb;
  --color-text: #23272e;
  --color-heading: #1e293b;
  --color-subtle: #64748b;
  --color-primary: #2563eb;
  --color-success: #22c55e;
}
html[data-theme='dark'], .dark {
  --color-bg: #181c23;
  --color-card: #232c3b;
  --color-border: #232c3b;
  --color-text: #f1f5f9;
  --color-heading: #f3f4f6;
  --color-subtle: #94a3b8;
  --color-primary: #60a5fa;
  --color-success: #22d3ee;
}
html[data-theme='light'], .light {
  --color-bg: #f8fafc;
  --color-card: #fff;
  --color-border: #e5e7eb;
  --color-text: #23272e;
  --color-heading: #1e293b;
  --color-subtle: #64748b;
  --color-primary: #2563eb;
  --color-success: #22c55e;
}
```

**Explicación:**
- Variables CSS para colores base, títulos, bordes y acentos, adaptables a modo claro/oscuro.
- Permite coherencia visual y fácil personalización de temas.

---

```css
/* =====================
   Estilos de texto accesible para artista
   ===================== */
.artista-hero,
.artista-hero h1,
.artista-hero .hero-subtitle {
  color: var(--dz-text-main);
}
.artista-hero h1 {
  color: var(--dz-text-heading);
}
.artista-hero .hero-subtitle {
  color: var(--dz-text-subtle);
}
```

**Explicación:**
- Aplica los colores definidos por variables a los textos principales de la sección hero del artista.
- Mejora la legibilidad y mantiene la coherencia visual.

---

```css
/* Utilidades para títulos y fondos (reemplazo de Bootstrap text-*, bg-light) */
.artista-title-primary { color: var(--color-primary) !important; }
.artista-title-success { color: #22c55e !important; }
.artista-title-warning { color: #fbbf24 !important; }
```

**Explicación:**
- Clases utilitarias para aplicar colores de acento a títulos según el contexto (primario, éxito, advertencia).

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
.artista-card {
  background: var(--dz-card-bg);
  border: 1px solid var(--dz-card-border);
  border-radius: 1rem;
  color: var(--dz-text-main);
  box-shadow: 0 10px 24px rgba(46, 18, 6, 0.06);
}
```

**Explicación:**
- Tarjeta principal de artista: fondo y borde definidos por variables, bordes redondeados y sombra suave.
- Mejora la separación visual y la estética general.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?