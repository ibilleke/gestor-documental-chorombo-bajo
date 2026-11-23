# PLAN — Gestor Documental Chorombo Bajo

> Plan de trabajo para construir la plataforma descrita en [BRIEF.md](BRIEF.md). El diseño del frontend está en [DESIGN.md](DESIGN.md).
> Stack: **Laravel + PHP + MySQL**.
> Las fechas van en semanas relativas; deben ajustarse al calendario del curso **[A definir: fecha del Entregable N°3]**.
> Los responsables son una propuesta según el rol de cada integrante **[A confirmar con el equipo]**.

---

## 1. Hitos

| Hito | Contenido | Estado / fecha |
|---|---|---|
| Entregable N°1 — Diagnóstico | Problemáticas, ficha de requerimientos, MER, flujo, simulación | Entregado (01-11-2026) |
| H1 — Entorno listo | Proyecto Laravel funcionando con MySQL y Git | Fin semana 1 |
| H2 — Base del sistema | Inicio de sesión, roles configurables (7 roles base), base de datos completa, datos de prueba | Fin semana 2 |
| Entregable N°2 — Diseño de solución | Análisis de soluciones por problemática, bocetos, decisiones técnicas y evidencia del entorno | Entregado (22-11-2026) |
| H3 — Núcleo documental | Carga, descarga protegida, bitácora y papelera funcionando | Fin semana 3 |
| H4 — Módulos completos | HU-02 a HU-06 implementadas, y HU-09 si alcanza el tiempo | Fin semana 6 |
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
- [x] Instalar **MySQL Community Server 8.4 LTS** (21-11-2026): versión 8.4.13 desde el ZIP oficial, sin instalador ni servicio de Windows, en `C:\Users\ignac\mysql` (PATH del usuario), con MD5 verificado. Escucha solo en `127.0.0.1:3306`, con `utf8mb4`. Se inicia con `mysqld --console`. Detalle en `descargas/LEEME.md`.
- [x] Instalar **Node.js LTS** (requisito de pnpm y Vite) (21-11-2026): Node.js 26.13.1 LTS "Lithium" con npm 11.20.0, instalación normal con el MSI oficial en `C:\Program Files\nodejs` (SHA-256 y firma digital verificados), sin las herramientas para módulos nativos. Detalle en `descargas/LEEME.md`.
- [x] Instalar **pnpm** como gestor de paquetes de JavaScript, previa lectura de su documentación oficial y aprobación (sección 5) (22-11-2026): pnpm 12.21.0 con `npm install -g pnpm@12.21.0`, método recomendado en Windows por [pnpm.io/installation](https://pnpm.io/installation); compatible con Node.js 26. `pnpm install` ejecutado el 22-11-2026 (88 paquetes: Vite 7.3.8, Tailwind CSS 4.3.5, `laravel-vite-plugin` 2.1.0) y `pnpm run build` sin errores. Se versionan `pnpm-lock.yaml` y `pnpm-workspace.yaml`; este último autoriza solo el script de instalación de `esbuild` (`allowBuilds`), que pnpm 12 bloquea por defecto ([pnpm.io/settings/build](https://pnpm.io/settings/build)).
- [x] Instalar Git 2.56.1 e inicializar el repositorio local en `gestor-documental/`, rama `main` (20-11-2026).
- [x] Crear el repositorio remoto privado en GitHub (`ibilleke/gestor-documental-chorombo-bajo`) y subir el proyecto, tras revisar dos veces que no contenga variables de entorno ni datos sensibles (20-11-2026).
- [x] Crear el proyecto con la **última versión estable de Laravel** (20-11-2026): Laravel Framework 13.43.0 (esqueleto `laravel/laravel` 13.x) sobre PHP 8.5.12, sin kit de inicio, con PHPUnit y `.env` configurado para MySQL (`gestor_documental`). Registrar versiones en el BRIEF.
- [x] Crear la base de datos `gestor_documental` en MySQL y configurar `.env` (21-11-2026): se crearon `gestor_documental` (desarrollo) y `gestor_documental_test` (pruebas), ambas `utf8mb4_0900_ai_ci`. Laravel conecta (`php artisan db:show`). Migraciones iniciales de Laravel ejecutadas el 22-11-2026 (`users`, `cache`, `jobs`, `sessions`).
- [x] Configurar idioma `es`, zona horaria `America/Santiago` y formato de fecha chileno (22-11-2026): `APP_LOCALE=es` (respaldo `en`), `APP_FAKER_LOCALE=es_ES` (Faker no tiene `es_CL`), `timezone` en `config/app.php` y traducciones propias en `lang/es/` (`validation`, `auth`, `passwords`, `pagination`), redactadas en forma impersonal hasta definir "tú" o "usted". Fechas en las vistas con `d-m-Y` y `H:i` (DESIGN §7). Cubierto por `tests/Feature/ConfiguracionRegionalTest.php`.
- [x] Estructura del repositorio: carpeta `gestor-documental/` (raíz del repositorio), con el código Laravel en su raíz y `documentos/` para la documentación (creada el 18-11-2026).
- [x] Tomar las decisiones técnicas de la sección 5 (última: autenticación, 22-11-2026).

- [x] Elegir el set de iconos (22-11-2026): ver sección 5.
- [x] Actualizar el MER con el modelo vigente (22-11-2026): `Evidencias técnicas/mer-v2.html`, fuera del repositorio.

**Criterio de término:** ~~los 3 integrantes pueden clonar el repositorio, ejecutar `php artisan serve` y ver la página de inicio conectada a MySQL.~~ **Cambio (22-11-2026):** el desarrollo queda a cargo de una sola persona, así que el criterio es que el proyecto se levante en el equipo de desarrollo con `php artisan serve`, conectado a MySQL, con toda la suite de pruebas aprobada y los pasos de instalación documentados en el `README.md`. **Cumplido el 22-11-2026.**

### Fase 1 — Validación con la directora (en paralelo, semanas 1 a 3)

Ya se hizo una entrevista (resultados en el Avance 1 del 08-11-2026 y en el BRIEF). Falta:

- [ ] Llevar a la reunión del miércoles las preguntas de la sección 15 del BRIEF, empezando por las 6 prioritarias (la 6 trata sobre docentes y apoderados).
- [ ] **Semana 1 (plazo máximo: fin de la semana 2):** cerrar la correspondencia entre perfiles y cargos reales (Inspectoría General, Coordinación Académica).
- [ ] Confirmar las 9 HU (incluida HU-09, portal de apoderados) y su prioridad, y si Convivencia (expedientes y protocolos) necesita historias de usuario nuevas.
- [ ] Completar la línea base: el tiempo de búsqueda ya se tiene (5–10 min); falta el volumen de documentos al mes.
- [ ] Actualizar el BRIEF con las respuestas y quitar los **[A validar]** resueltos.

**Criterio de término:** el BRIEF no tiene pendientes que bloqueen módulos (ver sección 6).

### Fase 2 — Base del sistema (semana 2) · HU-01

- [ ] Migraciones en este orden: `roles` → `permisos` → `permiso_rol` → `users` (columna `activo`) → `rol_user` → `solicitudes_rol` → `funcionarios` → `apoderados` (con `user_id` opcional) → `estudiantes` → `solicitudes_documento` → `documentos` → `correspondencias` → `permisos_administrativos` → `citaciones` → `acuerdos_apoderados` → `reuniones_comunales` → `compromisos` → `bitacoras`.
- [ ] Restricción única en `correspondencias`: (`clase`, `folio`, `anio_escolar`).
- [ ] Modelos Eloquent con sus relaciones según el MER.
- [ ] Seeders: 7 roles base (5 del equipo directivo, Docente y Apoderado, con nombres editables, porque pueden cambiar a los cargos reales), los permisos de la matriz con su marca `sensible` y su asignación a cada rol, 1 usuario de prueba por rol, 1 usuario de prueba con dos roles, 1 apoderado de prueba con dos pupilos y datos **ficticios** de funcionarios, apoderados y estudiantes.
- [x] Inicio y cierre de sesión, y bloqueo de usuarios inactivos (22-11-2026): `SesionController` y `IniciarSesionRequest` (5 intentos por minuto por correo e IP), rutas `/iniciar-sesion`, `/cerrar-sesion` y `/panel`, plantillas `x-layouts.guest` y `x-layouts.app`. Falta el mensaje de cuenta pendiente de aprobación, que depende de `solicitudes_rol`.
- Avance del 22-11-2026: migraciones `roles`, `permisos`, `permiso_rol`, `rol_user` y columna `activo` en `users`; modelos `Rol`, `Permiso` y `User` con sus relaciones y `Rol::esDelicado()`; seeders `PermisoSeeder` (catálogo preliminar de 34 permisos), `RolSeeder` (7 roles base) y `UsuarioPruebaSeeder` (un usuario por rol y uno con dos roles, solo en `local` y `testing`). Pruebas en `tests/Feature/Auth/InicioSesionTest.php`, `tests/Feature/RolesYPermisosTest.php` y `tests/Unit/RolTest.php`.
- [ ] Método `User::tienePermiso()` (suma de los permisos de todos los roles del usuario, guardada en caché durante la solicitud), Gates que lo consultan y `Policies` de Laravel por módulo. Las rutas se protegen con el middleware nativo `can`; no se crea un middleware de rol.
- [ ] Documento `documentos/MATRIZ_PERMISOS.md`: rol × módulo × acción (ver, crear, editar, descargar, eliminar, aprobar), con el nombre de cada permiso en formato `modulo.accion` (por ejemplo, `correspondencia.crear`). Partir de la matriz preliminar del BRIEF §5 (la misma de `simulacion.html`) y ajustarla con las respuestas de la directora.
- [ ] Gestión de usuarios (Administración y Dirección): crear, editar, activar o desactivar, con uno o más roles (mínimo uno, validado con un Form Request).
- [ ] Configuración de roles (solo Dirección, permiso `roles.configurar`): crear y modificar roles, elegir sus permisos y marcarlos como delicados. Un rol con un permiso sensible queda marcado como delicado siempre y no se puede desmarcar.
- [ ] Asignación de roles (BRIEF §5): Dirección asigna y retira cualquier rol directamente. Administración asigna y retira directamente los roles no delicados; para los delicados genera una solicitud en `solicitudes_rol`, que se aplica solo cuando Dirección la aprueba. Todo cambio en los propios roles de quien no es Dirección requiere aprobación. Un usuario nuevo con un rol delicado queda inactivo hasta esa aprobación y no puede activarse antes. Nadie resuelve su propia solicitud. No se puede retirar el rol Dirección ni desactivar al último usuario activo con ese rol. Todo queda en la bitácora, en registros que solo ve Dirección. El diseño de la pantalla de aprobación rápida se define antes de implementarla (DESIGN §5).
- [ ] Menú y panel de inicio que muestran solo los módulos permitidos para cada rol.
- [x] Bocetos de las pantallas principales (DESIGN.md §8), elaborados el 18-11-2026 (carpeta `Bocetos/`, fuera del repositorio).
- [ ] Validar los bocetos con la directora y al menos dos futuros usuarios.

**Criterio de término:** cada uno de los usuarios de prueba entra y ve solo sus módulos; el usuario con dos roles ve la suma de los módulos de ambos; un rol sin permiso que intenta entrar por URL recibe un error 403; un usuario inactivo no puede iniciar sesión; un rol delicado solicitado por Administración no se aplica hasta que Dirección lo aprueba; un rol no delicado asignado por Administración se aplica de inmediato; los registros de gestión de roles solo los ve Dirección.

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
| 6 | Reuniones comunales | HU-06 | Por determinar | Tipo de red; compromisos con fecha límite y estado; visible para los 5 roles del equipo directivo. Si falta tiempo, es candidato a recortar junto con HU-09 |
| 6 (al final) | Portal de apoderados | HU-09 | Media | El apoderado ve solo a sus pupilos (Policy que verifica el vínculo apoderado ↔ estudiante, también por URL); datos del estudiante, citaciones, acuerdos firmados **[A validar]** y solicitud de documentos con estado. Mensualidades fuera hasta que la directora las confirme **[A validar]**. Revisar antes la posible duplicación con Lirmi Familia. Junto con Reuniones comunales, es el primer candidato a pasar a una segunda versión |
| 6 | Mantenedores | — | — | Funcionarios, estudiantes y apoderados (quién los administra: **[A validar]**). Hasta la semana 6, los módulos usan los datos ficticios de los seeders |

- [ ] Validar el formato del RUN chileno (dígito verificador) en estudiantes, apoderados y funcionarios.

**Criterio de término:** se cumplen todos los criterios de aceptación de HU-02 a HU-06 del BRIEF y, si se implementa en esta versión, los de HU-09 (incluida la prueba de que un apoderado no puede ver a un estudiante que no es su pupilo).

### Fase 5 — Búsqueda y auditoría (semana 7) · HU-07, HU-08

- [ ] Buscador general con filtros: tipo, rango de fechas, rol emisor, estado, remitente y estudiante.
- [ ] Búsqueda de texto por título y asunto (cubre la búsqueda "por tema o referencia" que pidió la directora).
- [ ] Los resultados respetan la matriz de permisos (nadie ve lo que no puede abrir).
- [ ] Paginación de resultados.
- [ ] Vista de bitácora para Administración y Dirección, con filtros por usuario, acción y fecha. Los registros de gestión de roles solo se muestran a Dirección.
- [ ] Papelera: listar y restaurar documentos eliminados (solo Administración). La directora pidió poder recuperar documentos eliminados por error. La restauración también queda registrada en la bitácora.

**Criterio de término:** un documento de prueba se encuentra en menos de 1 minuto (hoy toma 5–10) y cada acción realizada aparece en la bitácora.

### Fase 6 — Pruebas y validación (semana 8)

- [ ] Revisión final de las pruebas automáticas (PHPUnit). Las pruebas se escriben en cada fase junto con su funcionalidad (regla 12 de `CLAUDE.md`); aquí se verifica que exista al menos una por criterio de aceptación y que toda la suite pase.
- [ ] Reutilizar como casos de prueba las reglas de negocio de `simulacion.html` (carpeta `Evidencias técnicas/`, fuera del repositorio).
- [ ] Pruebas de seguridad:
  - Acceso por URL directa sin permiso.
  - Escalamiento de privilegios: un usuario que intenta asignarse roles o permisos que no le corresponden, aplicar un rol sin aprobación de Dirección, aprobar su propia solicitud o activar un usuario sin rol aprobado.
  - Último usuario de Dirección: no se le puede retirar el rol ni desactivar.
  - Apoderado: no puede ver datos de un estudiante que no es su pupilo, ni por el menú ni por URL.
  - Administración: no puede asignar un rol delicado sin aprobación, configurar roles, vincular su propia cuenta como apoderado ni ver los registros de gestión de roles.
  - Configuración de roles: un rol con un permiso sensible no se puede desmarcar como delicado.
  - Usuario desactivado: no inicia sesión.
  - Usuario sin roles: el formulario lo rechaza; si existiera por otra vía (por ejemplo, directo en la base de datos), no accede a ningún módulo.
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
- [ ] Crear los usuarios reales del equipo directivo (las contraseñas las definen ellos). Las cuentas de docentes y apoderados se crean según el procedimiento que se defina con la directora (BRIEF §15, pregunta 6).
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
  Models/            Rol, Permiso, User, Documento, Correspondencia, PermisoAdministrativo,
                     Funcionario, Estudiante, Apoderado, Citacion, AcuerdoApoderado,
                     ReunionComunal, Compromiso, Bitacora, SolicitudRol, SolicitudDocumento
  Policies/          Una Policy por módulo (reglas de la matriz de permisos)
  Http/Controllers/  Un controlador por módulo + DescargaController + BuscadorController
  Http/Requests/     Validaciones de formularios (archivo, folio, RUN, fechas)
  Services/          ArchivoService, BitacoraService, FolioService
database/
  migrations/  seeders/  factories/
resources/views/     Vistas Blade por módulo + layout base
routes/web.php       Rutas agrupadas por módulo, protegidas con el middleware nativo `can`
tests/Unit/          Pruebas de lógica aislada (permisos, reglas de negocio)
tests/Feature/       Pruebas por HU (rutas, permisos por rol, bitácora, archivos)
```

## 5. Decisiones técnicas a tomar en la Fase 0

| Decisión | Opciones | Recomendación |
|---|---|---|
| Entorno local | (a) Laravel Herd gratuito + MySQL Community Server + Git; (b) `php.new` (Herd Lite) + MySQL Community Server + Node.js LTS + Git; (c) XAMPP; (d) Laragon | Opciones válidas: **(a)** y **(b)**, ambas de la [documentación oficial de Laravel 13](https://laravel.com/docs/installation) y gratuitas. Herd gratuito incluye PHP, Composer, Laravel y Node, pero **no MySQL** (solo en Herd Pro, de pago), así que MySQL se instala aparte. **Descartadas:** XAMPP (trae MariaDB, no MySQL) y Laragon 7 o superior (ya no es completamente gratuito, [laragon.org/docs/faq](https://laragon.org/docs/faq)). Revisado el 18-11-2026. ~~Decidido (18-11-2026): opción (a)~~. **Cambio de decisión (20-11-2026): instalación manual** de PHP 8.5.12 (zip oficial de php.net) y Composer 2.11.2 (`composer.phar` oficial), sin Herd: no requiere permisos de administrador, no instala servicios ni modifica archivos del sistema, y se desinstala borrando una carpeta. Se completa con MySQL Community Server 8.4 LTS, Node.js LTS, pnpm y Git, cada uno con su aprobación. **MySQL (21-11-2026): ZIP manual** de 8.4.13 en lugar del MSI, por el mismo criterio (sin administrador ni servicio de Windows); a cambio, el servidor no arranca con Windows y se inicia con `mysqld --console`. No se usó PHP 8.6.0 (publicado el 19-11-2026) por estar fuera de la política de soporte de Laravel 13 |
| Tabla de usuarios | `users` (Laravel) / `usuarios` (MER) | **Decidido (21-11-2026): `users`** con la columna `activo` agregada y los roles en la tabla `rol_user`. Mantiene la compatibilidad con la autenticación nativa de Laravel (proveedor, restablecimiento de contraseñas y sesiones), según la [documentación de autenticación](https://laravel.com/docs/13.x/authentication). BRIEF actualizado; MER actualizado el 22-11-2026 en `mer-v2.html` (el `mer.html` del Avance 1 se conserva como evidencia entregada) |
| Iconos | SVG de Heroicons copiados como componentes Blade propios / paquete `blade-ui-kit/blade-heroicons` 2.7.0 / sin iconos | **Decidido (22-11-2026): SVG propios.** Se copian desde [heroicons.com](https://heroicons.com) (Heroicons v2.2.0, licencia MIT, [repositorio](https://github.com/tailwindlabs/heroicons)) solo los iconos que se usen, dentro de un componente Blade propio, a medida que se necesiten, conservando el aviso de licencia MIT. No agrega dependencias. Se descartó `blade-heroicons` (declara Laravel 13, pero suma 2 paquetes de Composer y una caché de iconos) |
| Autenticación | Kit de inicio oficial de Laravel / Laravel Fortify / inicio de sesión propio | **Decidido (22-11-2026): inicio de sesión propio** con `Auth::attempt` y vistas Blade, según [Laravel 13: Authentication](https://laravel.com/docs/13.x/authentication) (sección "Manually Authenticating Users"): regenerar la sesión al iniciar, invalidarla y regenerar el token CSRF al cerrar, middleware `auth`/`guest`, límite de 5 intentos por minuto con `RateLimiter` y rechazo de usuarios con `activo = false`. Sin autorregistro: las cuentas las crea Administración (HU-01). El restablecimiento de contraseña lo hace Administración mientras no haya correo configurado. Descartados: los [kits de inicio de Laravel 13](https://laravel.com/docs/13.x/starter-kits) (solo React, Vue, Svelte y Livewire con Flux UI, para proyectos nuevos y con registro público) y [Fortify](https://laravel.com/docs/13.x/fortify) (agrega una dependencia y funciones que no se usan; queda como opción si se necesita 2FA o restablecimiento por correo) |
| Frontend | Blade + Tailwind (Vite) / Blade + Bootstrap | **Decidido (21-11-2026): Blade + Tailwind CSS 4.** Viene configurado en el proyecto creado con Laravel 13 (`tailwindcss` y `@tailwindcss/vite` ^4.0.0 en `package.json`, plugin en `vite.config.js` e `@import 'tailwindcss'` en `resources/css/app.css`), por lo que no agrega dependencias nuevas. Se descartó Bootstrap. Falta instalar Node.js LTS y pnpm y ejecutar `pnpm install`, cada paso con su aprobación |
| Gestor de paquetes de JavaScript | npm (incluido con Node) / pnpm | **Decidido (18-11-2026): pnpm.** Se usa en lugar de npm para instalar las dependencias del frontend y ejecutar Vite (`pnpm install`, `pnpm run dev`, `pnpm run build`). Su instalación se rige por las reglas 2 y 3 de `CLAUDE.md`: antes de instalarlo se lee la [documentación oficial de pnpm](https://pnpm.io/installation) y se confirma el método compatible con la versión de Node.js LTS que se instale. Se versiona `pnpm-lock.yaml` y no se versiona `package-lock.json` |
| Roles | Tabla propia + Policies / paquete externo | **Decidido (21-11-2026): RBAC nativo** con tablas `roles`, `permisos`, `permiso_rol` y `rol_user` (varios roles por usuario), más Policies que revisan condiciones del documento. El código verifica permisos, no roles, y se niega por defecto ([OWASP Authorization Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Authorization_Cheat_Sheet.html), [Laravel 13: Authorization](https://laravel.com/docs/13.x/authorization)). Se descartó `spatie/laravel-permission` 8.5.0 (compatible con Laravel 13, licencia MIT) porque agrega una dependencia y funciones que no se necesitan; queda como opción si la plataforma llega a atender varias escuelas |
| Pruebas | PHPUnit / Pest | **PHPUnit** (incluido en el proyecto). **Decidido (21-11-2026):** las pruebas usan una base MySQL separada, `gestor_documental_test`, para comportarse igual que la producción. Base creada el 21-11-2026 y configurada en `phpunit.xml` el 22-11-2026 (en reemplazo de SQLite en memoria) |
| Zona horaria de almacenamiento | `America/Santiago` / UTC con conversión al mostrar | **Decidido (22-11-2026): `America/Santiago`** en `config/app.php`. Una sola escuela en Chile: se guarda y muestra en hora local sin conversiones. Riesgo aceptado: en el cambio de hora de abril una hora se repite, lo que solo afecta el orden de la bitácora en esa hora |
| Traducción al español | Archivos propios / paquete Laravel-Lang | **Decidido (22-11-2026): archivos propios** publicados con `php artisan lang:publish` y traducidos en `lang/es/` ([Laravel 13: Localization](https://laravel.com/docs/13.x/localization)). Sin dependencias y con control del tono formal |
| Rol emisor de un documento | Guardar el rol con que se registró / derivarlo del usuario | **Decidido (21-11-2026): guardarlo** en `documentos` (columna `rol_id`, junto a `user_id` de quien lo registró). Se asigna solo si el usuario tiene un único rol habilitado para ese tipo; si tiene varios, elige en el formulario. El Form Request valida que el rol elegido pertenezca al usuario y pueda cargar ese tipo |

## 6. Pendientes de validación y qué bloquean

Ninguno impide empezar: las Fases 0, 2 y 3 se pueden hacer sin respuestas de la directora.

| Pendiente (BRIEF §15) | Bloquea | Plazo para tener la respuesta |
|---|---|---|
| Perfiles vs. cargos reales (Inspectoría General, Coordinación Académica) | Nombres de roles y matriz de permisos | Antes de terminar la semana 2 (mientras tanto, roles editables en tabla) |
| Quién da el V°B°, flujo completo o solo registro, visibilidad del solicitante | Diseño de HU-03 | Antes de la semana 4 |
| Reserva de números de oficio | Foliación de HU-02 | Antes de la semana 4 |
| Alcance de Convivencia (expedientes, protocolos) | HU-05 y posibles HU nuevas | Antes de la semana 5 |
| Quién puede eliminar documentos | Policy de eliminación | Antes de la semana 3 |
| ¿Quién, además de Administración, puede solicitar asignaciones de rol (por ejemplo, Recursos Humanos)? | Permiso `roles.solicitar` (HU-01) | Antes de terminar la semana 2 (mientras tanto, solo Administración) |
| ¿Vincular una cuenta con un apoderado requiere aprobación de Dirección? | Gestión de apoderados (HU-09) | Antes de la semana 6 (mientras tanto, sin aprobación y con registro reservado) |
| Citaciones: solo almacenar o emitir y hacer seguimiento | Alcance de HU-04 | Antes de la semana 5 |
| ¿Se aceptan `.ppt`/`.pptx`? | Regla de archivos en HU-06 | Antes de la semana 6 |
| ¿Quién mantiene funcionarios, estudiantes y apoderados? | Mantenedores y permisos (HU-03 a HU-05) | Antes de la semana 4 |
| ¿UTP ve acuerdos pedagógicos? | Policy de HU-05 | Antes de la semana 5 |
| Docentes y apoderados: permisos del docente, qué ve el apoderado, solicitudes de documentos, mensualidades, duplicación con Lirmi Familia y entrega de cuentas (BRIEF §15, pregunta 6) | Rol Docente y HU-09 | Antes de la semana 6 (el rol Docente existe sin permisos mientras tanto) |
| Días de permiso por funcionario | Resumen de HU-03 | Antes de la semana 4 |
| ¿Incluir paso de lista? | Alcance (hoy fuera) | Antes de la semana 3 |
| Tratamiento de "tú" o "usted" en la interfaz (DESIGN §7) | Textos de la plantilla base | Antes de la semana 3 |
| Escáner disponible, fotos de celular y archivo histórico (BRIEF §15, pregunta 19) | Formatos aceptados y capacitación | Antes de la semana 4 |
| Hosting y equipos | Fase 7 | Antes de la semana 7 |
| Línea base: volumen mensual (el tiempo de búsqueda ya se tiene) | Metas de los criterios de éxito | Antes de la semana 8 |

## 7. Riesgos

| Riesgo | Impacto | Mitigación |
|---|---|---|
| Entorno no instalado en los equipos | Retrasa el inicio | **Resuelto (22-11-2026):** entorno instalado y verificado; pasos en el `README.md` |
| Desarrollo a cargo de una sola persona (desde el 22-11-2026) | Menos capacidad para cumplir el cronograma | Priorizar las HU de prioridad alta (HU-01, HU-02, HU-03, HU-05 y HU-07) y dejar para el final las de prioridad media o por determinar |
| Herramientas que pasan a ser de pago (ej.: Laragon 7 o superior) | Costos no previstos o incumplimiento de licencias | Revisar la licencia en la documentación oficial antes de instalar (CLAUDE.md, reglas 2 y 3); usar solo software libre y gratuito |
| Disponibilidad de la directora (solo miércoles) | Validaciones tardías | Preguntas preparadas y priorizadas por lo que bloquean (sección 6) |
| Sin hosting definido | No se puede entregar en producción | Plantear opciones de bajo costo desde la semana 3; respaldo: demo local |
| Datos sensibles de menores | Riesgo legal y ético | Solo datos ficticios en desarrollo; archivos privados; pruebas de acceso |
| Apoderados (usuarios externos) acceden a datos de menores | Exposición de datos de otros estudiantes; mayor exigencia de la Ley 21.719 | Policy que verifica el vínculo apoderado ↔ estudiante; pruebas de acceso por URL; registro de cada consulta en la bitácora; revisión legal en la Fase 6 |
| El cambio de alcance (docentes y apoderados) no alcanza en 9 semanas | Retrasa los módulos de prioridad alta | HU-09 va al final de la Fase 4 y puede pasar a una segunda versión; el RBAC de la Fase 2 ya deja preparados los roles y el vínculo |
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
