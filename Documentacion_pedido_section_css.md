# Documentación de pedido-section.css

A continuación se presenta el contenido completo del archivo `pedido-section.css` junto con una explicación pedagógica línea por línea o por bloques, para facilitar el aprendizaje y comprensión de los estilos aplicados a la sección de pedidos/carrito.

---

## Código original

```css
/* =====================
     Variables de color base para texto accesible (pedido)
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
- Variables CSS para colores principales de texto, encabezados y texto sutil.
- Permite cambiar el tema visual (claro/oscuro) de forma centralizada usando variables.
- Facilita la accesibilidad y coherencia visual en toda la sección.

---

```css
/* =====================
     Estilos de texto accesible para pedido
     ===================== */
.cart-hero,
.cart-hero h1,
.cart-hero .subtitle {
    color: var(--dz-text-main);
}
.cart-hero h1 {
    color: var(--dz-text-heading);
}
.cart-hero .subtitle {
    color: var(--dz-text-subtle);
}
```

**Explicación:**
- Aplica los colores definidos por variables a los textos principales de la sección hero del carrito/pedido.
- Mejora la legibilidad y mantiene la coherencia visual.

---

```css
/* =====================
     Fin sistema de temas para pedido
     ===================== */
```

**Explicación:**
- Marca el fin del bloque de variables y sistema de temas.

---

```css
/* === Botones adaptados para modo claro (pedido) === */
.cart-shell .btn-warning { ... }
.cart-shell .btn-warning:hover { ... }
.cart-shell .btn-outline-light { ... }
.cart-shell .btn-outline-light:hover { ... }
.cart-shell .btn-outline-danger { ... }
.cart-shell .btn-outline-danger:hover { ... }
```

**Explicación:**
- Estilos personalizados para los botones del carrito: colores, bordes, sombras y transiciones.
- Diferentes variantes para advertencia, claro y peligro.
- Mejora la experiencia visual y la accesibilidad.

---

```css
/* Modo oscuro: mantener contraste */
html[data-theme='dark'] .cart-shell .btn-warning { ... }
html[data-theme='dark'] .cart-shell .btn-warning:hover { ... }
html[data-theme='dark'] .cart-shell .btn-outline-light { ... }
html[data-theme='dark'] .cart-shell .btn-outline-light:hover { ... }
html[data-theme='dark'] .cart-shell .btn-outline-danger { ... }
html[data-theme='dark'] .cart-shell .btn-outline-danger:hover { ... }
```

**Explicación:**
- Ajusta los estilos de los botones para modo oscuro, asegurando contraste y legibilidad.

---

```css
/* Estilo visual moderno para el contenedor del carrito */
.cart-shell { ... }
```

**Explicación:**
- Contenedor principal del carrito con fondo oscuro, bordes redondeados y sombra.
- Mejora la separación visual y la estética general.

---

```css
/* pedido-section.css: Migración de estilos desde pedido.blade.php */
```

**Explicación:**
- Indica que los estilos fueron migrados desde la vista Blade correspondiente.

---

```css
.cart-wrap { ... }
.cart-hero { ... }
.cart-hero h2 { ... }
.cart-hero p { ... }
.cart-shell { ... }
.cart-table-head { ... }
.cart-table-head strong { ... }
.cart-row { ... }
.cart-row:last-child { ... }
.cart-thumb { ... }
.cart-product-name { ... }
.cart-product-code { ... }
```

**Explicación:**
- `.cart-wrap`: Espaciado superior e inferior para la sección del carrito.
- `.cart-hero`: Fondo, borde, color y sombra para destacar la cabecera del carrito.
- `.cart-hero h2`: Título grande y destacado.
- `.cart-hero p`: Texto secundario con color sutil.
- `.cart-shell`: Fondo, borde y sombra para el contenedor principal.
- `.cart-table-head`: Encabezado de la tabla del carrito, con fondo y separación.
- `.cart-table-head strong`: Texto en mayúsculas, pequeño y con color sutil.
- `.cart-row`: Fila de la tabla del carrito, con padding y borde inferior.
- `.cart-row:last-child`: Elimina el borde de la última fila.
- `.cart-thumb`: Imagen del producto en el carrito, tamaño fijo, bordes redondeados y fondo blanco.
- `.cart-product-name`: Nombre del producto, grande y destacado.
- `.cart-product-code`: Código del producto, color sutil y tamaño pequeño.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?