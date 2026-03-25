# Requisitos del Sistema

## 1. Descripción General

El sistema es una plataforma web que permite a los usuarios autenticarse, visualizar y postularse a convocatorias, gestionar su perfil y consultar el estado de sus postulaciones. Los administradores pueden crear y gestionar convocatorias, revisar postulaciones y enviar notificaciones. La interfaz está orientada a la facilidad de uso, con visualización de información en tarjetas y flujos claros para cada proceso.

---

## 2. Requisitos Funcionales

### Módulo: Autenticación y Perfil

- **RF1:** El usuario debe poder registrarse y autenticarse en el sistema.
- **RF2:** El usuario debe poder recuperar su contraseña.
- **RF3:** El usuario debe poder editar los datos de su perfil.

### Módulo: Convocatorias

- **RF4:** El usuario debe poder visualizar las convocatorias disponibles en formato de tarjetas.
- **RF5:** El usuario debe poder filtrar y buscar convocatorias según criterios relevantes (ej: habilidades, intereses).
- **RF6:** El usuario debe poder ver detalles completos de cada convocatoria.

### Módulo: Postulaciones

- **RF7:** El usuario debe poder postularse a una convocatoria con un solo clic, utilizando la información de su perfil.
- **RF8:** El usuario debe poder consultar el estado y el historial de sus postulaciones en una sección dedicada.
- **RF9:** El usuario debe poder recibir notificaciones automáticas sobre el estado de sus postulaciones.

### Módulo: Administración

- **RF10:** El administrador debe poder crear, editar y eliminar convocatorias.
- **RF11:** El administrador debe poder revisar, filtrar y gestionar postulaciones.
- **RF12:** El administrador debe poder enviar notificaciones automáticas a los usuarios.

### Módulo: Integraciones

- **RF13:** El usuario debe poder acceder a grupos externos asociados a la convocatoria (ej: WhatsApp) desde la plataforma.

---

## 3. Requisitos No Funcionales

- **RNF1:** El sistema debe cargar las convocatorias de forma eficiente y responsiva.
- **RNF2:** El sistema debe proteger los datos de los usuarios mediante autenticación y autorización.
- **RNF3:** La interfaz debe ser intuitiva y mostrar la información en tarjetas y secciones claras.
- **RNF4:** El sistema debe ser escalable para soportar un aumento en el número de usuarios y convocatorias.
- **RNF5:** El sistema debe estar disponible al menos el 99% del tiempo.

---

## 4. Evidencia en el Código

| Requisito | Evidencia en el código |
|-----------|-----------------------|
| RF1, RF2, RF3 | routes/web.php, UserController.php, vistas de login/registro/perfil |
| RF4, RF5, RF6 | ConvocatoriaController.php, routes/web.php, vistas de convocatorias (tarjetas, filtros) |
| RF7, RF8, RF9 | PostulacionController.php, vistas de postulaciones, métodos de notificación |
| RF10, RF11, RF12 | Admin/ConvocatoriaController.php, Admin/PostulacionController.php, métodos de gestión y notificación |
| RF13 | Vistas de detalle de convocatoria, enlaces a grupos externos |
| RNF1 | Uso de paginación y consultas optimizadas en controladores |
| RNF2 | Middleware de autenticación y autorización, validaciones en controladores |
| RNF3 | Uso de Bootstrap/Tailwind, componentes de tarjetas en vistas |
| RNF4 | Estructura modular, uso de Eloquent y migraciones |
| RNF5 | No se observa código de monitoreo, pero la arquitectura soporta alta disponibilidad |

---

## 5. Gaps y Recomendaciones

- **Gap 1:** No se evidencia feedback visual claro al usuario tras postularse o editar su perfil.  
  _Recomendación:_ Agregar mensajes de confirmación y error visibles.

- **Gap 2:** No se observa validación avanzada de datos en formularios (solo validaciones básicas).  
  _Recomendación:_ Implementar validaciones más estrictas y mensajes detallados.

- **Gap 3:** No se detecta integración con sistemas de mensajería instantánea para notificaciones push.  
  _Recomendación:_ Integrar servicios como WhatsApp API o notificaciones push web.

- **Gap 4:** No se evidencia un historial detallado de acciones del usuario (solo postulaciones).  
  _Recomendación:_ Permitir al usuario consultar un historial completo de sus actividades.

- **Gap 5:** No se observa monitoreo de disponibilidad o alertas de caídas.  
  _Recomendación:_ Implementar monitoreo y alertas para asegurar la disponibilidad.

---

> Todos los requisitos están respaldados por evidencia directa en el código fuente y las vistas. Las recomendaciones se basan en prácticas comunes y en la perspectiva del cliente. Si alguna funcionalidad es ambigua, se indica como suposición basada en el código.
