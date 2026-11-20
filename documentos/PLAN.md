# PLAN — Gestor Documental Chorombo Bajo

> Plan de trabajo para construir la plataforma descrita en [BRIEF.md](BRIEF.md). El diseño del frontend está en [DESIGN.md](DESIGN.md).
> Stack: **Laravel + PHP + MySQL**.
> Las fechas van en semanas relativas; deben ajustarse al calendario del curso **[A definir: fechas de los Entregables N°2 y N°3]**.
> Los responsables son una propuesta según el rol de cada integrante **[A confirmar con el equipo]**.

---

## 1. Hitos

| Hito | Contenido | Estado / fecha |
|---|---|---|
| Entregable N°1 — Diagnóstico | Problemáticas, ficha de requerimientos, MER, flujo, simulación | Entregado (01-11-2026) |
| H1 — Entorno listo | Proyecto Laravel funcionando con MySQL y Git | Fin semana 1 |
| H2 — Base del sistema | Inicio de sesión, 5 roles, base de datos completa, datos de prueba | Fin semana 2 |
| Entregable N°2 — Diseño de solución | Análisis de soluciones + diseño validado + evidencia de la base funcionando | **[A definir]** (propuesto: fin semana 3) |
| H3 — Núcleo documental | Carga, descarga protegida, bitácora y papelera funcionando | Fin semana 3 |
| H4 — Módulos completos | HU-02 a HU-06 implementadas | Fin semana 6 |
| H5 — Búsqueda y auditoría | HU-07 y HU-08 implementadas | Fin semana 7 |
| H6 — Validación | Pruebas automáticas + prueba de usabilidad con la directora y los futuros usuarios | Fin semana 8 |
| Entregable N°3 — Solución final | Plataforma desplegada, manuales, informe final | **[A definir]** (propuesto: fin semana 9) |

## 2. Equipo y responsabilidades

| Integrante | Rol | Foco en el plan |
|---|---|---|
| Matías Martínez | Líder | Coordinación, contacto con la directora, cronograma, informes y entregables |
| Ignacio Billeke | Desarrollador | Entorno, arquitectura, base de datos, implementación de módulos |
| Natalia Jaime | Analista | Validación de requerimientos, casos de prueba, trazabilidad HU ↔ funcionalidad, manual de usuario |

Todos programan módulos a partir de la Fase 4 para cumplir los plazos.

---

## 3. Fases

### Fase 0 — Preparación del entorno (semana 1)

**Situación detectada:** en este equipo no hay PHP, Composer, MySQL, Node ni Git instalados (revisado el 17-11-2026).

Toda instalación de esta fase y de las siguientes se rige por `CLAUDE.md`: se consulta antes al equipo y se lee la documentación oficial de la versión que se instalará.

- [x] Instalar PHP y Composer de forma manual (20-11-2026): PHP 8.5.12 x64 NTS y Composer 2.11.2 en `C:\Users\ignac\php`, con SHA-256 verificado; detalle en `descargas/LEEME.md`, fuera del repositorio.
- [ ] Instalar **MySQL Community Server 8.4 LTS**.
- [ ] Instalar **Node.js LTS** (requisito de pnpm y Vite).
- [ ] Instalar **pnpm** como gestor de paquetes de JavaScript, previa lectura de su documentación oficial y aprobación (sección 5).
- [x] Instalar Git 2.56.1 e inicializar el repositorio local en `gestor-documental/`, rama `main`, con un primer commit (20-11-2026).
- [ ] Crear el repositorio remoto (GitHub privado o similar) y subir el proyecto.
- [x] Crear el proyecto con la **última versión estable de Laravel** (20-11-2026): Laravel Framework 13.43.0 (esqueleto `laravel/laravel` 13.x) sobre PHP 8.5.12, sin kit de inicio, con PHPUnit y `.env` configurado para MySQL (`gestor_documental`). Registrar versiones en el BRIEF.
- [ ] Crear la base de datos `gestor_documental` en MySQL y configurar `.env`.
- [ ] Configurar idioma `es`, zona horaria `America/Santiago` y formato de fecha chileno.
- [x] Estructura del repositorio: carpeta `gestor-documental/` (raíz del repositorio), con el código Laravel en su raíz y `documentos/` para la documentación (creada el 18-11-2026).
- [ ] Tomar las decisiones técnicas de la sección 5.

**Criterio de término:** los 3 integrantes pueden clonar el repositorio, ejecutar `php artisan serve` y ver la página de inicio conectada a MySQL.

### Fase 1 — Validación con la directora (en paralelo, semanas 1 a 3)

Ya se hizo una entrevista (resultados en el Avance 1 del 08-11-2026 y en el BRIEF). Falta:

- [ ] Llevar a la reunión del miércoles las preguntas de la sección 15 del BRIEF, empezando por las 5 prioritarias.
- [ ] **Semana 1 (plazo máximo: fin de la semana 2):** cerrar la correspondencia entre perfiles y cargos reales (Inspectoría General, Coordinación Académica).
- [ ] Confirmar las 8 HU y su prioridad, y si Convivencia (expedientes y protocolos) necesita historias de usuario nuevas.
- [ ] Completar la línea base: el tiempo de búsqueda ya se tiene (5–10 min); falta el volumen de documentos al mes.
- [ ] Actualizar el BRIEF con las respuestas y quitar los **[A validar]** resueltos.

**Criterio de término:** el BRIEF no tiene pendientes que bloqueen módulos (ver sección 6).

### Fase 2 — Base del sistema (semana 2) · HU-01

- [ ] Migraciones en este orden: `roles` → `users` (o `usuarios`, según la decisión de la sección 5) → `funcionarios` → `apoderados` → `estudiantes` → `documentos` → `correspondencias` → `permisos_administrativos` → `citaciones` → `acuerdos_apoderados` → `reuniones_comunales` → `compromisos` → `bitacoras`.
- [ ] Restricción única en `correspondencias`: (`clase`, `folio`, `anio_escolar`).
- [ ] Modelos Eloquent con sus relaciones según el MER.
- [ ] Seeders: 5 roles (con nombres editables, porque pueden cambiar a los cargos reales), 1 usuario de prueba por rol y datos **ficticios** de funcionarios, apoderados y estudiantes.
- [ ] Inicio y cierre de sesión, y bloqueo de usuarios inactivos.
- [ ] Middleware de rol y `Policies` de Laravel por módulo.
- [ ] Documento `documentos/MATRIZ_PERMISOS.md`: rol × módulo × acción (ver, crear, editar, descargar, eliminar, aprobar). Partir de la matriz preliminar del BRIEF §5 (la misma de `simulacion.html`) y ajustarla con las respuestas de la directora.
- [ ] Gestión de usuarios (solo Administración): crear, editar, asignar rol, activar o desactivar.
- [ ] Menú y panel de inicio que muestran solo los módulos permitidos para cada rol.
- [x] Bocetos de las pantallas principales (DESIGN.md §8), elaborados el 18-11-2026 (carpeta `Bocetos/`, fuera del repositorio).
- [ ] Validar los bocetos con la directora y al menos dos futuros usuarios.

**Criterio de término:** cada uno de los 5 usuarios de prueba entra y ve solo sus módulos; un rol sin permiso que intenta entrar por URL recibe un error 403.

### Fase 3 — Núcleo documental (semana 3)

Lo que comparten todos los módulos se construye una sola vez:

- [ ] Servicio de archivos: valida PDF/Word de hasta 15 MB y guarda en un **disco privado** (`storage/app/private`), con nombre generado por el sistema.
- [ ] Descarga controlada: el archivo se entrega solo a través de un controlador que primero revisa la Policy; nunca por URL pública.
- [ ] Servicio de bitácora: registra usuario, acción, documento y fecha/hora en cada subida, edición, descarga, eliminación y acceso denegado.
- [ ] Borrado lógico con `SoftDeletes` usando la columna `eliminado_en` (`const DELETED_AT = 'eliminado_en'`).
- [ ] Confirmación antes de eliminar.
- [ ] Marca de **confidencial** en `documentos` y regla de visibilidad asociada.
- [ ] Plantilla base en Blade: layout, mensajes de error y éxito en español, formularios reutilizables, según [DESIGN.md](DESIGN.md).

**Criterio de término:** se puede subir, descargar y eliminar un documento de prueba, y las tres acciones aparecen en la tabla `bitacoras`.

### Fase 4 — Módulos de negocio (semanas 4 a 6)

Cada módulo incluye listado, formulario de carga, detalle, edición, descarga y sus pruebas. El orden sigue la prioridad del BRIEF §7: primero lo de prioridad Alta y lo que la directora marcó como prioritario (Convivencia).

| Semana | Módulo | HU | Prioridad | Puntos críticos |
|---|---|---|---|---|
| 4 | Correspondencia oficial | HU-02 | Alta | Foliación automática correlativa anual (confirmada por la directora); números reservados; alerta de folio duplicado por clase y año escolar |
| 4 | Permisos administrativos | HU-03 | Alta | Flujo Pendiente de V°B° → Aprobado/Rechazado; quién aprueba **[A validar]**; alerta de pendientes; días usados y **disponibles** por funcionario (incluye medias jornadas) |
| 5 | Acuerdos con apoderados / Convivencia | HU-05 | **Alta (prioridad de la directora)** | Siempre confidencial; solo Convivencia y Dirección; búsqueda por nombre o RUN; posible ampliación a expedientes y protocolos **[A validar]** |
| 5 | Citaciones a apoderados | HU-04 | Por determinar | Motivo y estado; adjuntar colilla firmada; cambio de estado con registro en bitácora |
| 6 | Reuniones comunales | HU-06 | Por determinar | Tipo de red; compromisos con fecha límite y estado; visible para los 5 roles. Si falta tiempo, es el primer candidato a recortar |
| 6 | Mantenedores | — | — | Funcionarios, estudiantes y apoderados (quién los administra: **[A validar]**). Hasta la semana 6, los módulos usan los datos ficticios de los seeders |

- [ ] Validar el formato del RUN chileno (dígito verificador) en estudiantes, apoderados y funcionarios.

**Criterio de término:** se cumplen todos los criterios de aceptación de HU-02 a HU-06 del BRIEF.

### Fase 5 — Búsqueda y auditoría (semana 7) · HU-07, HU-08

- [ ] Buscador general con filtros: tipo, rango de fechas, rol emisor, estado, remitente y estudiante.
- [ ] Búsqueda de texto por título y asunto (cubre la búsqueda "por tema o referencia" que pidió la directora).
- [ ] Los resultados respetan la matriz de permisos (nadie ve lo que no puede abrir).
- [ ] Paginación de resultados.
- [ ] Vista de bitácora para Administración y Dirección, con filtros por usuario, acción y fecha.
- [ ] Papelera: listar y restaurar documentos eliminados (solo Administración). La directora pidió poder recuperar documentos eliminados por error. La restauración también queda registrada en la bitácora.

**Criterio de término:** un documento de prueba se encuentra en menos de 1 minuto (hoy toma 5–10) y cada acción realizada aparece en la bitácora.

### Fase 6 — Pruebas y validación (semana 8)

- [ ] Pruebas automáticas (PHPUnit o Pest, incluidos en Laravel), al menos una por criterio de aceptación.
- [ ] Reutilizar como casos de prueba las reglas de negocio de `simulacion.html` (carpeta `Evidencias técnicas/`, fuera del repositorio).
- [ ] Pruebas de seguridad:
  - Acceso por URL directa sin permiso.
  - Descarga de archivos ajenos.
  - Subida de archivos con extensión falsa.
  - Protección CSRF.
  - Inyección SQL y XSS en formularios.
- [ ] Revisión de cumplimiento en protección de datos personales: Ley 19.628 y **Ley 21.719**. Al 18-11-2026, la Ley 21.719 entra en vigencia el **1 de diciembre de 2026** ([BCN](https://www.bcn.cl/balance-legislativo/detalle/ficha_LEY_21719_2024-12-13)). Hay un proyecto que la posterga hasta 2027 (Boletín 18.623-07, aprobado por el Senado el 28-10-2026 y en trámite), así que hay que confirmar su estado antes de esta fase.
- [ ] Prueba de usabilidad con la directora **y los futuros usuarios**, usando datos ficticios y las tareas definidas en DESIGN §8 (sin ayuda); registrar dónde dudan.
- [ ] Corregir las observaciones.
- [ ] Actualizar los criterios de éxito (sección 13 del BRIEF).

**Criterio de término:** todas las pruebas automáticas pasan y la directora aprueba el recorrido de prueba.

### Fase 7 — Despliegue y entrega (semana 9)

- [ ] Definir el hosting con la directora o la Corporación Municipal (bajo costo, con HTTPS).
- [ ] Desplegar en producción: `.env` de producción, `APP_DEBUG=false` y almacenamiento privado.
- [ ] Respaldos automáticos de la base de datos y de los archivos, con una prueba de restauración.
- [ ] Crear los usuarios reales del equipo directivo (las contraseñas las definen ellos).
- [ ] Entregar:
  - Manual de usuario por rol: breve, con capturas paso a paso y en lenguaje claro.
  - Manual técnico (instalación, respaldo y restauración).
  - Capacitación práctica por rol: cada persona registra y busca sus propios documentos de ejemplo.
  - Acompañamiento durante las primeras semanas de uso (canal de consultas y una visita de seguimiento) **[A definir con el equipo]**.
- [ ] Informe final y presentación del Entregable N°3.

**Criterio de término:** el equipo directivo usa la plataforma con sus propias cuentas.

---

## 4. Estructura técnica propuesta

```
app/
  Models/            Rol, User, Documento, Correspondencia, PermisoAdministrativo,
                     Funcionario, Estudiante, Apoderado, Citacion, AcuerdoApoderado,
                     ReunionComunal, Compromiso, Bitacora
  Policies/          Una Policy por módulo (reglas de la matriz de permisos)
  Http/Controllers/  Un controlador por módulo + DescargaController + BuscadorController
  Http/Requests/     Validaciones de formularios (archivo, folio, RUN, fechas)
  Http/Middleware/   VerificarRol
  Services/          ArchivoService, BitacoraService, FolioService
database/
  migrations/  seeders/  factories/
resources/views/     Vistas Blade por módulo + layout base
routes/web.php       Rutas agrupadas por módulo con middleware de rol
tests/Feature/       Pruebas por HU
```

## 5. Decisiones técnicas a tomar en la Fase 0

| Decisión | Opciones | Recomendación |
|---|---|---|
| Entorno local | (a) Laravel Herd gratuito + MySQL Community Server + Git; (b) `php.new` (Herd Lite) + MySQL Community Server + Node.js LTS + Git; (c) XAMPP; (d) Laragon | Opciones válidas: **(a)** y **(b)**, ambas de la [documentación oficial de Laravel 13](https://laravel.com/docs/installation) y gratuitas. Herd gratuito incluye PHP, Composer, Laravel y Node, pero **no MySQL** (solo en Herd Pro, de pago), así que MySQL se instala aparte. **Descartadas:** XAMPP (trae MariaDB, no MySQL) y Laragon 7 o superior (ya no es completamente gratuito, [laragon.org/docs/faq](https://laragon.org/docs/faq)). Revisado el 18-11-2026. ~~Decidido (18-11-2026): opción (a)~~. **Cambio de decisión (20-11-2026): instalación manual** de PHP 8.5.12 (zip oficial de php.net) y Composer 2.11.2 (`composer.phar` oficial), sin Herd: no requiere permisos de administrador, no instala servicios ni modifica archivos del sistema, y se desinstala borrando una carpeta. Se completa con MySQL Community Server 8.4 LTS, Node.js LTS, pnpm y Git, cada uno con su aprobación. No se usó PHP 8.6.0 (publicado el 19-11-2026) por estar fuera de la política de soporte de Laravel 13 |
| Tabla de usuarios | `users` (Laravel) / `usuarios` (MER) | **`users`** con `rol_id` y `activo` agregados: mantiene la compatibilidad con la autenticación nativa de Laravel. Actualizar el MER y el BRIEF |
| Autenticación | Kit de inicio oficial de Laravel / inicio de sesión propio | Inicio de sesión propio y simple con el `Auth` de Laravel si el kit incluye más de lo necesario |
| Frontend | Blade + Tailwind (Vite) / Blade + Bootstrap | **Blade + Tailwind**: forma parte de la configuración inicial de Laravel (confirmar en la documentación de la versión instalada). Requiere Node y la instalación de dependencias de JavaScript con pnpm, sujeta a aprobación |
| Gestor de paquetes de JavaScript | npm (incluido con Node) / pnpm | **Decidido (18-11-2026): pnpm.** Se usa en lugar de npm para instalar las dependencias del frontend y ejecutar Vite (`pnpm install`, `pnpm run dev`, `pnpm run build`). Su instalación se rige por las reglas 2 y 3 de `CLAUDE.md`: antes de instalarlo se lee la [documentación oficial de pnpm](https://pnpm.io/installation) y se confirma el método compatible con la versión de Node.js LTS que se instale. Se versiona `pnpm-lock.yaml` y no se versiona `package-lock.json` |
| Roles | Tabla propia + Policies / paquete externo | **Tabla propia + Policies**: son pocos roles (5, con nombres editables) |
| Pruebas | PHPUnit / Pest | La que traiga por defecto la versión de Laravel instalada |

## 6. Pendientes de validación y qué bloquean

Ninguno impide empezar: las Fases 0, 2 y 3 se pueden hacer sin respuestas de la directora.

| Pendiente (BRIEF §15) | Bloquea | Plazo para tener la respuesta |
|---|---|---|
| Perfiles vs. cargos reales (Inspectoría General, Coordinación Académica) | Nombres de roles y matriz de permisos | Antes de terminar la semana 2 (mientras tanto, roles editables en tabla) |
| Quién da el V°B°, flujo completo o solo registro, visibilidad del solicitante | Diseño de HU-03 | Antes de la semana 4 |
| Reserva de números de oficio | Foliación de HU-02 | Antes de la semana 4 |
| Alcance de Convivencia (expedientes, protocolos) | HU-05 y posibles HU nuevas | Antes de la semana 5 |
| Quién puede eliminar documentos | Policy de eliminación | Antes de la semana 3 |
| Citaciones: solo almacenar o emitir y hacer seguimiento | Alcance de HU-04 | Antes de la semana 5 |
| ¿Se aceptan `.ppt`/`.pptx`? | Regla de archivos en HU-06 | Antes de la semana 6 |
| ¿Quién mantiene funcionarios, estudiantes y apoderados? | Mantenedores y permisos (HU-03 a HU-05) | Antes de la semana 4 |
| ¿UTP ve acuerdos pedagógicos? | Policy de HU-05 | Antes de la semana 5 |
| Días de permiso por funcionario | Resumen de HU-03 | Antes de la semana 4 |
| ¿Incluir paso de lista? | Alcance (hoy fuera) | Antes de la semana 3 |
| Tratamiento de "tú" o "usted" en la interfaz (DESIGN §7) | Textos de la plantilla base | Antes de la semana 3 |
| Escáner disponible, fotos de celular y archivo histórico (BRIEF §15, pregunta 18) | Formatos aceptados y capacitación | Antes de la semana 4 |
| Hosting y equipos | Fase 7 | Antes de la semana 7 |
| Línea base: volumen mensual (el tiempo de búsqueda ya se tiene) | Metas de los criterios de éxito | Antes de la semana 8 |

## 7. Riesgos

| Riesgo | Impacto | Mitigación |
|---|---|---|
| Entorno no instalado en los equipos | Retrasa el inicio | Fase 0 con guía de instalación común; resolverlo en la semana 1 |
| Herramientas que pasan a ser de pago (ej.: Laragon 7 o superior) | Costos no previstos o incumplimiento de licencias | Revisar la licencia en la documentación oficial antes de instalar (CLAUDE.md, reglas 2 y 3); usar solo software libre y gratuito |
| Disponibilidad de la directora (solo miércoles) | Validaciones tardías | Preguntas preparadas y priorizadas por lo que bloquean (sección 6) |
| Sin hosting definido | No se puede entregar en producción | Plantear opciones de bajo costo desde la semana 3; respaldo: demo local |
| Datos sensibles de menores | Riesgo legal y ético | Solo datos ficticios en desarrollo; archivos privados; pruebas de acceso |
| Crecimiento del alcance (paso de lista, etc.) | Atraso de módulos | Todo lo nuevo entra como "fuera de alcance" salvo acuerdo explícito |
| Equipo pequeño y plazos académicos | Módulos incompletos | Orden por prioridad: núcleo, HU-01/02/03 y Convivencia (HU-05) primero; HU-06 es lo primero que se recorta |
| Los perfiles de la ficha no coinciden con los cargos reales | Rehacer permisos | Roles en tabla editable y permisos centralizados en Policies; cerrar la correspondencia en la semana 1 (plazo máximo: semana 2) |
| Usuarios sin experiencia digital (todo era en papel) | No adoptan la plataforma y vuelven a las carpetas | Diseño simple (DESIGN.md), bocetos y pruebas con los usuarios reales, capacitación práctica y acompañamiento inicial |

## 8. Forma de trabajo

- **Git:** rama `main` estable; una rama por módulo (`hu-02-correspondencia`, etc.); se integra con pull request revisado por otro integrante.
- **Reunión de equipo semanal:** avance, bloqueos y tareas de la semana siguiente.
- **Reunión con la directora:** miércoles 17:00–19:00, con una agenda corta enviada antes.
- **Registro de trabajo mensual:** actualizar el entregable con las evidencias de cada fase (capturas, pruebas y commits).
- **Definición de terminado (para cada módulo):**
  1. Cumple los criterios de aceptación de su HU.
  2. Respeta la matriz de permisos.
  3. Registra en bitácora.
  4. Tiene pruebas automáticas que pasan.
  5. Fue revisado por otro integrante.
