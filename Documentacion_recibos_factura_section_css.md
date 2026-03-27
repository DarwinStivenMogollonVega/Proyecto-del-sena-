# Documentación de recibos-factura-section.css

A continuación se presenta el contenido completo del archivo `recibos-factura-section.css` junto con una explicación pedagógica línea por línea o por bloques, para facilitar el aprendizaje y comprensión de los estilos aplicados a la sección de recibos y facturas.

---

## Código original

```css
/* =====================
     Variables de color base para texto accesible (recibos factura)
     ===================== */
:root {
    --dz-text-main: #2d2d2d;
    --dz-text-heading: #7c2d12;
    --dz-text-subtle: #475569;
}
html[data-theme='dark'], .dark {
    --dz-text-main: #f3e9e0;
    --dz-text-heading: #fbbf24;
    --dz-text-subtle: #cbd5e1;
}
html[data-theme='light'], .light {
    --dz-text-main: #23272e;
    --dz-text-heading: #b45309;
    --dz-text-subtle: #475569;
}
```

**Explicación:**
- Se definen variables CSS para los colores principales de texto, encabezados y texto sutil.
- Permite cambiar el tema visual (claro/oscuro) de forma centralizada usando variables.
- Facilita la accesibilidad y coherencia visual en toda la sección.

---

```css
/* =====================
     Estilos de texto accesible para recibos factura
     ===================== */
.invoice-hero,
.invoice-hero h1,
.invoice-hero .subtitle {
    color: var(--dz-text-main);
}
.invoice-hero h1 {
    color: var(--dz-text-heading);
}
.invoice-hero .subtitle {
    color: var(--dz-text-subtle);
}
```

**Explicación:**
- Aplica los colores definidos por variables a los textos principales de la sección hero de la factura.
- Mejora la legibilidad y mantiene la coherencia visual.

---

```css
/* =====================
     Fin sistema de temas para recibos factura
     ===================== */
/* recibos-factura-section.css: Migración de estilos desde recibos_factura.blade.php */
```

**Explicación:**
- Marca el fin del bloque de variables y sistema de temas.
- Indica que los estilos fueron migrados desde la vista Blade correspondiente.

---

```css
.invoice-page {
    background:
        radial-gradient(circle at 10% 8%, rgba(245, 158, 11, 0.12), transparent 32%),
        radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.08), transparent 30%),
        linear-gradient(180deg, rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0));
    border-radius: 1rem;
    padding-bottom: 2rem;
}
```

**Explicación:**
- Define el fondo de la página de factura con gradientes para dar profundidad y color.
- Bordes redondeados y padding inferior para separar visualmente la sección.

---

```css
.invoice-hero {
    margin-top: 1.5rem;
    border-radius: 1rem;
    color: #fff;
    padding: 1.8rem;
    background:
        radial-gradient(circle at 12% 20%, rgba(245, 158, 11, 0.35), transparent 42%),
        radial-gradient(circle at 82% 15%, rgba(59, 130, 246, 0.22), transparent 35%),
        linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
    box-shadow: 0 18px 38px rgba(15, 23, 42, 0.24);
}
```

**Explicación:**
- Estilo destacado para el encabezado de la factura (hero): fondo con gradientes, sombra, bordes redondeados y padding.
- El color de texto es blanco para contraste.

---

```css
.invoice-card {
    background: var(--dz-surface);
    border: 1px solid var(--dz-border);
    border-radius: 1rem;
    box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
}
```

**Explicación:**
- Tarjeta de factura con fondo y borde definidos por variables, bordes redondeados y sombra suave.

---

```css
.invoice-kpi {
    padding: 1rem;
    min-height: 110px;
}
.invoice-kpi .label {
    color: var(--dz-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-size: 0.75rem;
    font-weight: 700;
}
.invoice-kpi .value {
    color: var(--dz-heading);
    font-size: 1.45rem;
    font-weight: 700;
    line-height: 1.15;
}
```

**Explicación:**
- Estilos para indicadores clave (KPI) de la factura: padding, altura mínima, y estilos diferenciados para etiquetas y valores.
- Uso de variables para colores y tipografía para jerarquía visual.

---

```css
.invoice-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.invoice-table thead th {
    text-transform: uppercase;
    font-size: 0.74rem;
    letter-spacing: 0.04em;
    color: var(--dz-muted);
    font-weight: 700;
    white-space: nowrap;
    background: var(--dz-page-grad-1);
}
.invoice-table td {
    white-space: nowrap;
    vertical-align: middle;
}
```

**Explicación:**
- Permite que la tabla de la factura sea desplazable horizontalmente en móviles.
- Encabezados con fondo, texto en mayúsculas y colores sutiles para claridad.
- Celdas alineadas verticalmente y sin saltos de línea.

---

```css
html[data-theme='dark'] .invoice-page {
    background:
        radial-gradient(circle at 10% 8%, rgba(245, 158, 11, 0.15), transparent 32%),
        radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.13), transparent 30%),
        linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
}
```

**Explicación:**
- Ajusta el fondo de la página de factura para modo oscuro, usando gradientes más oscuros y opacos para mejor contraste.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?