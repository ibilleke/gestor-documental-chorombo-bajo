# DESIGN — Gestor Documental Chorombo Bajo

> Guía de diseño del frontend: pantallas, navegación, componentes y estilo visual.
> Se basa en [BRIEF.md](BRIEF.md) (roles, módulos y reglas) y [PLAN.md](PLAN.md) (stack).
> Tecnología: **Blade** (motor de plantillas de Laravel) + **Tailwind CSS** (propuesto; se confirma en la Fase 0, PLAN §5). No se usan frameworks de JavaScript; solo JavaScript mínimo donde sea necesario (confirmaciones, vista previa del archivo).
> Lo marcado **[A validar]** debe revisarse con la directora en la prueba de usabilidad.

---

## Punto de partida: los usuarios vienen del papel

> **Esto es lo más importante de este documento.** Hasta hoy, el equipo directivo trabaja **todo en papel**: los documentos se guardan en **carpetas y archivadores físicos**, y los de años anteriores en archivos separados. Fuera de Lirmi Familia (matrícula, calificaciones y accidentes escolares), **no tienen experiencia usando programas de gestión documental**.
>
> Por eso la plataforma tiene que ser **amigable y fácil de entender desde el primer día**. Si una pantalla necesita explicación, está mal diseñada. Ante la duda entre "más completo" y "más simple", se elige **más simple**.

Qué significa esto en la práctica:

| Regla | Cómo se aplica |
|---|---|
| **Lenguaje profesional y claro** | Usar el vocabulario administrativo formal de la escuela: "registrar documento", "adjuntar archivo", "folio", "oficio", "citación", "iniciar sesión". Evitar anglicismos y jerga informática ("upload", "dashboard", "login", "metadatos", "CRUD"). Ejemplos: "Registrar documento" en vez de "Subir archivo" e "Iniciar sesión" en vez de "Login". |
| **Menú por módulos con nombres claros** | Cada opción del menú corresponde a un tipo de documento o proceso: Correspondencia, Permisos administrativos, Citaciones, Acuerdos con apoderados, Reuniones comunales. Con un icono y su nombre siempre visibles. |
| **Una tarea por pantalla** | Cada pantalla sirve para una sola cosa: consultar un módulo, registrar un documento o ver un documento. Sin ventanas sobre ventanas ni menús escondidos. |
| **Registro paso a paso** | El formulario de carga va en **3 pasos numerados**: (1) qué documento es, (2) a quién corresponde, (3) elegir el archivo. Arriba siempre se ve en qué paso se está. |
| **Botones grandes y con texto** | Botones de al menos 44 px de alto, con texto claro ("Registrar documento", "Buscar", "Volver"). No se utilizan iconos sin texto, clic derecho, doble clic ni gestos ocultos. |
| **Ayuda donde se necesita** | Cada campo tiene un ejemplo debajo (ej.: "Ej.: 12.345.678-9"). Cada pantalla tiene una frase corta que dice para qué sirve. |
| **Siempre se puede volver** | Botón "Volver" visible en todas las pantallas. "Cancelar" nunca borra nada sin preguntar. |
| **Confirmaciones claras** | Después de guardar: "El oficio N° 15 fue registrado correctamente en Correspondencia." Antes de eliminar: una pregunta clara y la tranquilidad de que se puede recuperar. |
| **Mensajes de error comprensibles** | Nunca mostrar códigos ni mensajes técnicos. Siempre decir qué pasó y qué hacer: "El archivo es muy grande (18 MB). El máximo es 15 MB. Prueba escaneándolo en menor calidad." |
| **Los documentos en papel se escanean** | Muchos documentos vendrán **escaneados**. La pantalla de carga explica en una línea cómo hacerlo, y se prueba con PDF escaneados reales del tamaño habitual. Si también se aceptarán fotos tomadas con el celular, está pendiente **[A validar]**. |
| **Validación con usuarios reales** | Los bocetos y la prueba de usabilidad se realizan con **las personas que usarán la plataforma**, no solo con la directora. Si un usuario tiene dificultades, se ajusta el diseño. |
| **Capacitación y acompañamiento** | Capacitación práctica por rol, un manual corto con capturas paso a paso y acompañamiento durante las primeras semanas de uso (ver PLAN, Fase 7). |

## 1. Principios

1. **Simple para usuarios que vienen del papel:** pocas opciones por pantalla, textos claros y en español, sin jerga técnica (ver "Punto de partida").
2. **Cada rol ve solo lo suyo:** el menú, los botones y los resultados de búsqueda se arman según los permisos. Nunca se muestra un botón que lleve a un error 403.
3. **Identificación de lo confidencial:** los documentos confidenciales siempre llevan una marca visible.
4. **Nada se pierde sin aviso:** toda eliminación pide confirmación y explica que el documento va a la papelera.
5. **Errores que ayudan:** cada mensaje dice qué pasó y cómo corregirlo (ej.: "El archivo pesa 18 MB. El máximo es 15 MB").
6. **Funciona en los equipos de la escuela:** se diseña para computadores de escritorio y notebooks, y se adapta correctamente a tablets y celulares.

## 2. Estilo visual

### Colores

Tomados de las evidencias técnicas (MER y diagrama de flujo) para mantener una identidad coherente con los informes.

| Uso | Color | Hex |
|---|---|---|
| Primario oscuro (barra lateral, títulos) | Azul marino | `#102B42` |
| Primario (botones, enlaces) | Azul | `#1F4E79` |
| Fondo suave (tarjetas, filas destacadas) | Azul muy claro | `#EAF1F8` |
| Fondo de página | Gris muy claro | `#F7F9FB` |
| Texto principal | Gris oscuro | `#3C3C3B` |
| Advertencia / pendiente | Dorado | Texto `#7A5C00` sobre `#FFF6E0`, borde `#C9A227` |
| Error / rechazado / confidencial | Rojo | `#B03A2E` sobre `#FDECEA` |
| Éxito / aprobado | Verde | `#2E7D32` sobre `#E8F5E9` |

Contraste comprobado con la fórmula WCAG: todas las combinaciones de texto superan 4.5:1 (nivel AA). El dorado `#C9A227` **no** se usa para texto (2.25:1); va solo en bordes e iconos, y el texto usa `#7A5C00` (5.81:1).

Los colores se definen como tema en `tailwind.config` (o en el CSS del tema, según la versión de Tailwind) para no repetir códigos hex en las vistas.

### Tipografía

- Fuente del sistema: `"Segoe UI", Arial, sans-serif`. No se cargan fuentes externas.
- Tamaño base: 16 px. Títulos de página: 24 px. Tablas: 15 px como mínimo, para que se lean sin esfuerzo.

### Iconos

- Un set gratuito de iconos SVG (por ejemplo Heroicons, de los creadores de Tailwind) **[A definir en la Fase 0]**. Su instalación requiere aprobación previa, según `CLAUDE.md`.
- Todo icono va acompañado de texto; no se usan iconos solos para acciones importantes.

### Accesibilidad

- Contraste suficiente entre texto y fondo (nivel AA de WCAG).
- Todos los campos tienen `label` visible.
- Se puede navegar con teclado; el foco se ve claramente.
- Los estados no dependen solo del color: siempre llevan texto (ej.: "Aprobado").

## 3. Estructura general (layout)

```
┌──────────────────────────────────────────────────────────────┐
│ Barra superior: nombre del sistema · buscador rápido ·       │
│ alerta de pendientes · usuario y rol · cerrar sesión         │
├──────────────┬───────────────────────────────────────────────┤
│ Menú lateral │ Migas de pan (Inicio › Correspondencia › ...) │
│ (según rol)  │ Título de la página + botón principal         │
│              │ Mensajes (éxito / error)                      │
│              │ Contenido: filtros + tabla / formulario       │
└──────────────┴───────────────────────────────────────────────┘
```

- Archivo Blade base: `resources/views/layouts/app.blade.php`.
- En pantallas angostas el menú lateral se oculta tras un botón "Menú".
- La pantalla de inicio de sesión usa una plantilla aparte, sin menú: `layouts/guest.blade.php`.

## 4. Menú por rol

Según la matriz preliminar del BRIEF §5 **[A validar: puede cambiar con los cargos reales]**.

| Opción del menú | Dirección | Administración | Secretaría | UTP | Convivencia |
|---|---|---|---|---|---|
| Inicio | ✔ | ✔ | ✔ | ✔ | ✔ |
| Buscador | ✔ | ✔ | ✔ | ✔ | ✔ |
| Correspondencia (memos y oficios) | ✔ | — | ✔ | ✔ (solo consulta) | — |
| Permisos administrativos | ✔ (aprueba **[A validar]**) | ✔ | ✔ (solicita) | ✔ (solicita) | ✔ (solicita) |
| Citaciones | ✔ | — | ✔ | — | ✔ |
| Acuerdos con apoderados 🔒 | ✔ | — | — | — | ✔ |
| Reuniones comunales | ✔ | ✔ | ✔ | ✔ | ✔ |
| Bitácora | ✔ | ✔ | — | — | — |
| Papelera | — | ✔ | — | — | — |
| Usuarios y roles | — | ✔ | — | — | — |
| Funcionarios / Estudiantes / Apoderados | **[A validar: quién los administra]** | | | | |

"Solicita" significa que el rol puede cargar una solicitud de permiso. Si podrá ver el estado de sus propias solicitudes está pendiente **[A validar]**.

## 5. Pantallas

### 5.1 Inicio de sesión
- Campos: correo y contraseña. Botón "Iniciar sesión".
- Error genérico: "Correo o contraseña incorrectos" (no revela cuál de los dos falló).
- Usuario desactivado: "Tu cuenta está desactivada. Contacta a Administración."

### 5.2 Inicio (panel)
Tarjetas según el rol:
- **Dirección / Administración:** permisos pendientes de V°B° (con número) y últimos documentos cargados (solo los que el rol puede ver; para Administración, permisos y reuniones).
- **Secretaría:** próximo folio disponible de memo y de oficio, citaciones programadas para esta semana.
- **Convivencia:** citaciones programadas, últimos acuerdos.
- **UTP:** compromisos de reuniones comunales próximos a vencer.
- Todos: botones grandes "Registrar documento" para los tipos que su rol puede cargar, y "Buscar documento".

### 5.3 Listado de un módulo (patrón común)
- Título + botón principal ("Registrar memo u oficio", "Registrar citación", etc.), visible solo si el rol puede cargar.
- Filtros arriba de la tabla (fecha desde/hasta, estado y los propios del módulo) y un botón "Limpiar filtros". Los filtros secundarios quedan agrupados en "Más filtros" para mantener la pantalla despejada.
- Tabla con: fecha, título o asunto, datos clave del módulo, estado (insignia de color) y solo dos acciones: **Ver** y **Descargar**. Editar y Eliminar están dentro del detalle, para evitar errores por un clic accidental.
- Paginación de 20 filas.
- Sin resultados: "No hay documentos que coincidan con los filtros."

### 5.4 Formulario de carga (patrón común)
- Tres pasos numerados (ver "Punto de partida"): datos del documento, personas asociadas y archivo. Se puede volver al paso anterior sin perder lo escrito. Si el tipo de documento no tiene personas asociadas (por ejemplo, una minuta de reunión), el formulario tiene solo dos pasos.
- Campos obligatorios marcados con `*` y con la palabra "(obligatorio)".
- Archivo: botón grande "Elegir archivo" (arrastrar es opcional, no la única forma), con el texto "PDF o Word, máximo 15 MB" y el nombre y tamaño del archivo elegido antes de enviarlo. Si se aceptan presentaciones en Reuniones comunales, el texto cambia en ese módulo **[A validar]**.
- Errores junto a cada campo, en rojo, y un resumen al inicio del formulario.
- Botones: "Guardar" (primario) y "Cancelar" (secundario).

### 5.5 Detalle de documento
- Datos del documento, estado, quién lo registró y cuándo.
- Botones "Editar" y "Eliminar" aquí (no en la tabla), según los permisos.
- Botón "Descargar" (cada descarga queda en la bitácora; no hace falta avisarlo al usuario).
- Historial del documento (extracto de la bitácora) visible para Dirección y Administración, solo en documentos que el rol puede abrir.

### 5.6 Pantallas por módulo

| Módulo | Elementos específicos |
|---|---|
| **Correspondencia** (HU-02) | Selector Memo/Oficio. Folio sugerido automáticamente con el siguiente número del año; si se repite: alerta "El folio N° X ya existe para oficios de 2026". Manejo de números reservados **[A validar]**. |
| **Permisos** (HU-03) | Funcionario, fechas de inicio y término, días o medias jornadas, respaldo. Resumen por funcionario: días usados / disponibles en el año. Para Dirección: botones "Aprobar" y "Rechazar" en las solicitudes pendientes, con confirmación (quién aprueba **[A validar]**). |
| **Citaciones** (HU-04) | Estudiante (búsqueda por nombre o RUN), apoderado (se completa a partir del estudiante), motivo (Conductual, Pedagógico, Administrativo), fecha y hora. El estado (Asistió, No asistió, etc.) se actualiza desde el detalle de la citación, con un selector y confirmación, igual que las demás ediciones. |
| **Acuerdos** (HU-05) | Franja roja "CONFIDENCIAL" arriba de la pantalla. Búsqueda por nombre o RUN del estudiante. Ámbito y fecha de firma. |
| **Reuniones comunales** (HU-06) | Tipo de red, fecha y documento. Lista de compromisos con fecha límite y estado; los vencidos en rojo y los que vencen en menos de 7 días en dorado (plazo propuesto por el equipo). |
| **Buscador** (HU-07) | Barra de texto + filtros: tipo, rango de fechas, rol emisor, estado, remitente y estudiante. Resultados de todos los tipos en una sola tabla con una insignia del tipo. Solo muestra lo que el rol puede abrir. |
| **Bitácora** (HU-08) | Tabla de solo lectura: fecha y hora, usuario, acción y documento. Filtros por usuario, acción y fechas. Para Administración, los documentos confidenciales aparecen como "Documento confidencial #ID", sin título, porque el título puede incluir el nombre de un estudiante **[A validar]**. |
| **Papelera** (HU-08) | Documentos eliminados, quién y cuándo los eliminó. Botón "Restaurar" con confirmación. Administración puede restaurar los confidenciales, pero no abrirlos ni descargarlos; se muestran igual que en la bitácora **[A validar]**. |
| **Usuarios** (HU-01) | Tabla de usuarios con rol y estado. Formulario de alta y edición. Botón "Activar/Desactivar" (no se borran usuarios). |

## 6. Componentes reutilizables (Blade)

Se crean como componentes en `resources/views/components/` para no repetir código:

| Componente | Uso |
|---|---|
| `<x-boton>` | Variantes: primario, secundario y peligro |
| `<x-alerta>` | Éxito, error, advertencia e información; se cierra con un botón |
| `<x-insignia-estado>` | Pendiente de V°B° (dorado), Aprobado (verde), Rechazado (rojo), Programada, Asistió, etc. |
| `<x-marca-confidencial>` | Candado + texto "Confidencial" en rojo |
| `<x-tabla>` | Encabezados, filas, estado vacío y paginación |
| `<x-filtros>` | Contenedor de filtros con "Buscar" y "Limpiar filtros" |
| `<x-campo>` | Label + input + mensaje de error |
| `<x-adjuntar-archivo>` | Selección de archivo con validación de tipo y tamaño en el navegador (la validación real siempre ocurre en el servidor) |
| `<x-modal-confirmar>` | Confirmación de eliminar, aprobar, rechazar y restaurar |
| `<x-tarjeta-resumen>` | Tarjetas del panel de inicio |

## 7. Textos y mensajes

- Tono profesional, cordial y directo. Tratamiento de "tú" o "usted" **[A validar con la directora]**; los ejemplos de este documento usan "tú" y se ajustarán cuando se decida.
- Glosario de la interfaz: se usa siempre la misma palabra para lo mismo. "Registrar documento" para crear uno nuevo, "Adjuntar archivo" para el PDF o Word, "Módulo" para cada sección del menú y "Documento" para el registro completo.
- Formato de fecha: `dd-mm-aaaa`; hora en 24 h (`14:30`).
- RUN con puntos y guion: `12.345.678-9`.
- Mensajes estándar:
  - Guardado: "El documento fue registrado correctamente en {módulo}."
  - Eliminación (confirmación): "¿Eliminar este documento? Irá a la papelera y Administración podrá restaurarlo."
  - Sin permiso: "No tienes permiso para ver esta página." (página 403 con botón "Volver al inicio")
  - Archivo inválido: "Solo se aceptan archivos PDF o Word de hasta 15 MB."
  - Folio duplicado: "El folio N° {folio} ya existe para {memos/oficios} de {año}."

## 8. Entregables de diseño

- [x] Bocetos de baja fidelidad de las pantallas principales: inicio de sesión, panel de inicio, listado, formulario y buscador (Fase 2). Elaborados el 18-11-2026 en HTML estático, con datos ficticios y desde el rol de Dirección; incluyen además el detalle de documento. Se guardan en la carpeta `Bocetos/` del directorio de trabajo, fuera del repositorio.
- [ ] Validar los bocetos con la directora **y con al menos dos futuros usuarios** antes de construir los módulos (Fase 2).
- [ ] Layout y componentes base en Blade (Fase 3).
- [ ] Prueba de usabilidad con los usuarios reales (Fase 6). Tareas de prueba: registrar un oficio escaneado, encontrar una citación y descargar un documento, **sin ayuda**. Se anota dónde dudan.
- [ ] Manual corto con capturas paso a paso y capacitación práctica por rol (Fase 7).
