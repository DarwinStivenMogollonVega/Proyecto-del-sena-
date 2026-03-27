# Documentación de perfil-section.css

A continuación se presenta el contenido completo del archivo `perfil-section.css` junto con una explicación pedagógica línea por línea o por bloques, para facilitar el aprendizaje y comprensión de los estilos aplicados a la sección de perfil de usuario.

---

## Código original

```css
/* =====================
     Variables de color base para texto accesible (perfil)
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
     Estilos de texto accesible para perfil
     ===================== */
.profile-hero,
.profile-hero h1,
.profile-hero .subtitle {
    color: var(--dz-text-main);
}
.profile-hero h1 {
    color: var(--dz-text-heading);
}
.profile-hero .subtitle {
    color: var(--dz-text-subtle);
}
```

**Explicación:**
- Aplica los colores definidos por variables a los textos principales de la sección hero del perfil.
- Mejora la legibilidad y mantiene la coherencia visual.

---

```css
/* =====================
     Fin sistema de temas para perfil
     ===================== */
/* perfil-section.css: Migración de estilos desde perfil.blade.php */
```

**Explicación:**
- Marca el fin del bloque de variables y sistema de temas.
- Indica que los estilos fueron migrados desde la vista Blade correspondiente.

---

```css
.profile-page {
    background: radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.12), transparent 30%), radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.09), transparent 28%), linear-gradient(180deg, rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0));
    border-radius: 1rem;
    padding-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
```

**Explicación:**
- Define el fondo de la página de perfil con gradientes para dar profundidad y color.
- Bordes redondeados, padding inferior, y control de overflow para separar visualmente la sección y evitar desbordes.

---

```css
.profile-hero {
    margin-top: 1.5rem;
    border-radius: 1rem;
    color: #fff;
    padding: 2rem;
    background: radial-gradient(circle at 14% 20%, rgba(245, 158, 11, 0.35), transparent 42%), radial-gradient(circle at 82% 15%, rgba(59, 130, 246, 0.2), transparent 35%), linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
    box-shadow: 0 18px 38px rgba(15, 23, 42, 0.24);
    position: relative;
    overflow: hidden;
}
```

**Explicación:**
- Estilo destacado para el encabezado de la sección de perfil (hero): fondo con gradientes, sombra, bordes redondeados y padding.
- El color de texto es blanco para contraste.
- Control de overflow y posición relativa para efectos visuales.

---

```css
.profile-title-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.8rem;
    background: rgba(255, 255, 255, 0.18);
    margin-right: 0.6rem;
}
```

**Explicación:**
- Icono decorativo junto al título del perfil: centrado, tamaño fijo, fondo translúcido y bordes redondeados.
- Mejora la estética y la jerarquía visual del encabezado.

---

```css
.profile-card {
    background: var(--dz-surface);
    border: 1px solid var(--dz-border);
    border-radius: 1rem;
}
```

**Explicación:**
- Tarjeta de información del perfil con fondo y borde definidos por variables, y bordes redondeados.
- Permite coherencia visual y adaptación a temas claro/oscuro.

---

¿Te gustaría que explique alguna clase, selector o bloque específico con mayor profundidad?