# Documentación de responsive-section.css

A continuación se incluye el contenido del archivo `responsive-section.css` y una explicación línea por línea o por bloques, con enfoque pedagógico y técnico.

---

## Código original

```css
/* =====================
   Variables de color base para texto accesible (responsive)
   ===================== */
:root {
  --dz-text-main: #2d2d2d;
  --dz-text-heading: #7c2d12;
  --dz-text-subtle: #475569;
  --dz-nav-link: var(--dz-text-heading);
  --dz-nav-link-dark: var(--dz-text-heading);
}
html[data-theme='dark'], .dark {
  --dz-text-main: #f3e9e0;
  --dz-text-heading: #f3e9e0; /* Amarillo dorado, resalta sobre fondo oscuro */
  --dz-text-subtle: #cbd5e1;
  --dz-nav-link: var(--dz-text-heading);
}
html[data-theme='light'], .light {
  --dz-text-main: #23272e;
  --dz-text-heading: #23272e; /* Naranja vibrante, resalta y combina con botones */
  --dz-text-subtle: #475569;
  --dz-nav-link: var(--dz-text-heading);
}
```

**Explicación:**
- Se definen variables CSS para colores de texto y enlaces, adaptables a modo claro/oscuro.
- Permite cambiar el tema visual de toda la web de forma centralizada.

---

```css
.navbar .nav-link,
.navbar .nav-cta-btn,
.navbar .dropdown-cta-btn,
.navbar .cart-cta-btn,
.navbar .nav-cta-text {
  color: var(--dz-nav-link) !important;
}
html[data-theme='dark'] .navbar .nav-link,
html[data-theme='dark'] .navbar .nav-cta-btn,
html[data-theme='dark'] .navbar .dropdown-cta-btn,
html[data-theme='dark'] .navbar .cart-cta-btn,
html[data-theme='dark'] .navbar .nav-cta-text {
  color: var(--dz-nav-link) !important;
}
```

**Explicación:**
- Unifica el color de los enlaces y botones del navbar para ambos temas.
- Usa la variable para mantener consistencia visual.

---

```css
.responsive-hero,
.responsive-hero h1,
.responsive-hero .subtitle {
  color: var(--dz-text-main);
}
.responsive-hero h1 {
  color: var(--dz-text-heading);
}
.responsive-hero .subtitle {
  color: var(--dz-text-subtle);
}
```

**Explicación:**
- Aplica los colores definidos a los textos principales de la sección hero (portada).
- Mejora la legibilidad y mantiene la coherencia visual en todos los dispositivos.

---

```css
.dz-product-card {
  border-radius: 1.2rem;
  box-shadow: 0 4px 24px 0 rgba(44, 36, 16, 0.10), 0 1.5px 8px #c4631012;
  background: #fff;
  border: 1.5px solid #e5e7eb;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: box-shadow 0.18s, transform 0.18s;
  min-height: 420px;
}
.dz-product-card:hover {
  box-shadow: 0 8px 32px 0 rgba(196,99,16,0.18), 0 2px 16px #c4631022;
  transform: translateY(-4px) scale(1.025);
  border-color: #c46310;
}
```

**Explicación:**
- Define el estilo de las tarjetas de producto: bordes redondeados, sombra, fondo blanco, transición suave y altura mínima.
- Al hacer hover, la tarjeta se eleva y resalta el borde.

---

```css
.dz-product-img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  border-top-left-radius: 1.2rem;
  border-top-right-radius: 1.2rem;
  background: #f3e3d1;
  transition: filter 0.18s;
}
.dz-product-card:hover .dz-product-img {
  filter: brightness(0.97) contrast(1.08) drop-shadow(0 2px 8px #c4631022);
}
```

**Explicación:**
- Las imágenes de producto se adaptan al ancho, tienen esquinas redondeadas y fondo de color suave.
- Al pasar el mouse, la imagen se resalta con filtros visuales.

---

```css
.dz-product-title {
  font-size: 1.18rem;
  font-weight: 700;
  color: #a04a00;
  margin: 1rem 0 0.2rem 0;
  text-align: center;
  letter-spacing: 0.01em;
}
.dz-product-price {
  color: #1ca97c;
  font-size: 1.15rem;
  font-weight: 800;
  text-align: center;
  margin-bottom: 0.7rem;
}
```

**Explicación:**
- Define el estilo del título y precio de los productos, centrados y con colores destacados.

---

```css
.dz-product-btn { ... }
.dz-product-btn:hover { ... }
```

**Explicación:**
- Botón de acción para productos: ancho casi completo, fondo naranja, texto blanco, sombra y transición.
- Al hacer hover, cambia el fondo y la sombra para dar feedback visual.

---

```css
@media (max-width: 991.98px) { ... }
@media (max-width: 576px) { ... }
```

**Explicación:**
- Reglas responsivas para adaptar el tamaño de imágenes, tarjetas y textos en tablets y móviles.

---

```css
html[data-theme='dark'] .dz-product-card { ... }
html[data-theme='dark'] .dz-product-title { ... }
html[data-theme='dark'] .dz-product-btn { ... }
html[data-theme='dark'] .dz-product-btn:hover { ... }
```

**Explicación:**
- Cambia el fondo, bordes y colores de las tarjetas y botones en modo oscuro para mejor contraste.

---

```css
.checkout-steps-bg { ... }
html[data-theme='dark'] .checkout-steps-bg { ... }
```

**Explicación:**
- Fondo especial para el paso de checkout, con gradiente y padding, adaptado a ambos temas.

---

```css
.dz-brand-logo.logo-dis-music.dz-logo-custom { ... }
.logo-light { ... }
.logo-dark { ... }
html[data-theme='dark'] .logo-light { ... }
html[data-theme='dark'] .logo-dark { ... }
```

**Explicación:**
- Estilos para el logo: tamaño adaptable y cambio de imagen según el tema (claro/oscuro).

---

```css
/* ======= RESPONSIVE BREAKPOINTS MEJORADOS ======= */
@media (max-width: 1400px) { ... }
@media (min-width: 1401px) and (max-width: 1920px) { ... }
@media (min-width: 1921px) and (max-width: 2560px) { ... }
@media (min-width: 2561px) and (max-width: 3840px) { ... }
@media (min-width: 3841px) { ... }
```

**Explicación:**
- Ajusta paddings, tamaños y gaps de los principales contenedores y elementos según el tamaño de pantalla, para una experiencia óptima en cualquier dispositivo.

---

```css
:root { ... }
```

**Explicación:**
- Variables base para colores, fuentes, bordes, sombras y espaciados reutilizables en todo el sitio.

---

```css
@media (max-width: 576px) { ... }
```

**Explicación:**
- Reglas específicas para móviles: fuentes más pequeñas, paddings reducidos, imágenes y tarjetas adaptadas a pantallas pequeñas.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?