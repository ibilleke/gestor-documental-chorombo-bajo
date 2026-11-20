# BRIEF — Gestor Documental Chorombo Bajo

> Documento base para el desarrollo. Resume qué se construye, para quién, con qué reglas y con qué tecnología.
> Fuentes: Ficha VcM Actor Externo, Ficha A.I. Requerimientos (HU-01 a HU-08), Informe de Avance (19-10-2026), Informe formal del taller — Avance 1 (versión final, 08-11-2026, **incluye la entrevista con la directora**) y evidencias técnicas (MER, diagrama de flujo y simulación).
> Cuando la entrevista contradice o precisa a las fichas, prevalece la entrevista.
> Los puntos marcados **[A validar]** deben confirmarse con la directora antes de darlos por cerrados.

---

## 1. Resumen del proyecto

| Campo | Detalle |
|---|---|
| Nombre | Gestor Documental Chorombo Bajo |
| Cliente | Escuela Básica G733 Chorombo Bajo (María Pinto, Región Metropolitana) |
| Contraparte | Directora del establecimiento |
| Tipo de solución | Plataforma web de gestión documental con acceso por roles (RBAC) |
| Usuarios | Equipo directivo: 5 perfiles; en la primera implementación, unas 6 personas (5 del equipo de gestión + 1 de Secretaría) |
| Contexto académico | Clínicas Tecnológicas / Taller de Integración — Técnico Analista Programador, IP San Sebastián |
| Docente | Stephania Videla Mendoza (en el Informe de Avance aparece "Sthephania": confirmar ortografía) |
| Equipo | Matías Martínez (Líder), Ignacio Billeke (Desarrollador), Natalia Jaime (Analista) |
| Reuniones con contraparte | Miércoles, 17:00 – 19:00 |

## 2. Contexto

La escuela es un establecimiento público pequeño (208 estudiantes según la ficha VcM; la directora mencionó 209 en la entrevista **[A validar]**; prekínder a 8° básico), administrado por la Corporación Municipal de María Pinto. El equipo directivo gestiona documentación interna y externa (DAEM/SLEP, redes comunales, Mesa Comunal de Convivencia, Superintendencia de Educación).

Situación actual (confirmada en la entrevista):
- Gran parte de la documentación administrativa es **física**, en carpetas y archivadores; los antecedentes de años anteriores se guardan en archivos separados.
- Como todo se ha llevado en papel, los usuarios **no tienen experiencia con programas de gestión documental** (antecedente aportado por el equipo del proyecto). La plataforma debe ser muy amigable y fácil de entender (ver [DESIGN.md](DESIGN.md), "Punto de partida").
- La escuela usa **Lirmi Familia** para matrícula, calificaciones y accidentes escolares, pero no tiene un sistema integral de gestión documental. La plataforma es "una idea nueva".
- La documentación se reparte entre Dirección, Inspectoría General, Coordinación Académica, Secretaría y Convivencia Escolar.
- Procesos manuales (ej.: paso de lista).
- No hay sistemas ni servidores a los que dar acceso, no hay protocolos de seguridad de la información y no hay credenciales de administración para entregar al proyecto. Equipos computacionales y conectividad disponibles **[A validar]**.
- Restricción presupuestaria: no hay presupuesto para adquirir software, por lo que la solución debe ser de **bajo costo y sin licencias pagadas**.

## 3. Problema

El equipo directivo no tiene un lugar común para almacenar y consultar su documentación oficial.

Confirmado en la entrevista:
- Ha habido **extravío y duplicación** de documentos.
- Buscar un documento importante toma hoy entre **5 y 10 minutos** (estimación de la directora; es la línea base).
- La necesidad **prioritaria** es sistematizar la documentación de **Convivencia Escolar**: expedientes, entrevistas y protocolos, algunos de los cuales pueden requerir intervención de organismos externos.
- Pendiente: el volumen documental mensual **[A validar]**.

Problemas detectados:

1. **Información dispersa**: cuesta encontrar un documento cuando se necesita.
2. **Sin trazabilidad**: no se sabe quién creó, modificó o eliminó un documento.
3. **Riesgo de confidencialidad**: acuerdos y casos de convivencia con datos sensibles de estudiantes y apoderados sin control de acceso.
4. **Permisos administrativos sin control**: no hay estado de cada solicitud ni días acumulados por funcionario.
5. **Correspondencia sin control de folio**: posibles folios duplicados o perdidos en memos y oficios.
6. **Seguimiento débil de citaciones**: no se registra si el apoderado asistió, faltó o fue reprogramado.

## 4. Objetivo

Desarrollar una plataforma web que centralice la documentación del equipo directivo, permitiendo **cargar, clasificar, buscar y auditar** documentos según el rol de cada integrante, protegiendo la información sensible y sin costos de licencias.

## 5. Usuarios y roles (RBAC)

| Rol | Responsabilidad | Permisos principales |
|---|---|---|
| **Dirección** | Supervisión transversal y aprobación institucional | Carga, lectura, descarga, aprobación y supervisión de **todos** los módulos. Aprueba/rechaza permisos administrativos. |
| **Administración** | Gestión operativa y técnica de la plataforma | Crea usuarios y asigna roles, configuración, respaldos, papelera/auditoría. Gestiona permisos administrativos. |
| **Secretaría** | Correspondencia oficial y citaciones | Carga, edición y foliación de memos, oficios y citaciones. |
| **Jefatura de UTP** | Gestión técnico-pedagógica | Documentos pedagógicos, reuniones comunales técnicas, memos/oficios generales. |
| **Convivencia Escolar** | Casos de convivencia y apoderados | Carga y lectura de acuerdos con apoderados, citaciones y casos de convivencia (confidencial). |

Fuera del alcance como usuarios: apoderados, estudiantes y docentes que no integran el equipo directivo.

Nota: los "documentos pedagógicos" de UTP y los "casos de convivencia" vienen de la ficha, pero no están entre los 6 tipos de documento del alcance. Si se incluyen, falta definirlo **[A validar]** (relacionado con la pregunta 4 de la sección 15).

> **Importante: los perfiles no coinciden con los cargos reales [A validar].** En la entrevista aparecieron **Inspectoría General** y **Coordinación Académica**, que no existen en la ficha. Según la directora, Dirección, Inspectoría General y Coordinación Académica tienen acceso amplio a la documentación. Hay que definir con ella cómo se relacionan estos cargos con Administración y UTP. Por eso los roles se guardarán en una tabla editable y no en el código.

### Matriz preliminar de carga y consulta

Es una propuesta del equipo (Avance 1, probada en la simulación), no una definición de la escuela **[A validar]**.

| Rol | Puede cargar | Puede consultar |
|---|---|---|
| Dirección | Todos los tipos | Todos los tipos, incluidos los confidenciales |
| Administración | Permisos administrativos (además gestiona usuarios, roles, configuración y respaldos) | Permisos, reuniones comunales y papelera |
| Secretaría | Memos, oficios, citaciones y permisos | Memos, oficios, citaciones y reuniones comunales |
| Jefatura de UTP | Reuniones comunales y permisos | Memos, oficios y reuniones comunales |
| Convivencia Escolar | Citaciones, acuerdos y permisos | Citaciones, acuerdos (confidenciales) y reuniones comunales |

Supuestos de esta matriz que hay que confirmar:
- Dirección otorga el V°B° de los permisos; Administración los registra y controla.
- Cualquier integrante puede solicitar un permiso. Falta definir si puede ver el estado de su propia solicitud.
- Un documento lo puede eliminar quien lo cargó o Dirección.
- UTP **no** ve acuerdos en esta versión.

## 6. Alcance

### Incluye (primera versión)
- Autenticación y control de acceso por los 5 roles.
- Carga, registro, clasificación, consulta y descarga de **6 tipos de documento**:
  memos, oficios, citaciones, acuerdos con apoderados, documentos de reuniones comunales y permisos administrativos.
- Buscador con filtros.
- Bitácora de auditoría y papelera de documentos eliminados.

### No incluye (por ahora)
- Acceso para apoderados, estudiantes o docentes.
- Firma electrónica avanzada.
- Integración con sistemas del Mineduc u otras plataformas.
- Registro de asistencia / paso de lista **[A validar con la directora]**.
- Digitalización del archivo histórico en papel (escanear y cargar los documentos de años anteriores). La plataforma permitirá hacerlo, pero el escaneo masivo no es parte del proyecto **[A validar]**.

## 7. Módulos e historias de usuario

La prioridad viene de la matriz de necesidades del Avance 1, actualizada después de la entrevista. Es provisional **[A validar]**.

| # | Módulo | Qué resuelve | HU | Prioridad |
|---|---|---|---|---|
| 1 | Usuarios y roles | Cada integrante accede solo a lo que corresponde a su función | HU-01 | Alta |
| 2 | Correspondencia oficial | Memos y oficios con folio correlativo anual y alerta de folio duplicado | HU-02 | Alta |
| 3 | Permisos administrativos | Solicitudes con estado y días usados/disponibles por funcionario | HU-03 | Alta |
| 4 | Citaciones a apoderados | Registro con motivo, estudiante y estado de asistencia | HU-04 | Por determinar |
| 5 | Acuerdos con apoderados / Convivencia | Actas confidenciales (Convivencia y Dirección) | HU-05 | **Alta (prioridad de la directora)** |
| 6 | Reuniones comunales | Minutas y orientaciones por tipo de red, con compromisos y plazos | HU-06 | Por determinar (la directora prioriza los procesos internos) |
| 7 | Búsqueda y auditoría | Filtros multinivel y bitácora de quién hizo qué y cuándo | HU-07, HU-08 | Búsqueda: Alta · Bitácora: por determinar |

### Detalle de criterios por HU

**HU-01 — Perfiles y permisos**
- Crear usuarios y asociarlos a uno de los 5 roles.
- Permisos según la tabla de la sección 5.

**HU-02 — Memos y oficios**
- Campos: folio/N° correlativo, clase (Memo/Oficio), fecha, emisor, destinatario, materia/asunto + archivo adjunto.
- El documento queda almacenado, indexado y visible para los roles con lectura.
- **Alerta si se repite el folio en el mismo año escolar**. Según el MER, la unicidad es por clase + folio + año escolar (un memo y un oficio pueden tener el mismo número).
- Entrevista: se confirmó la **foliación automática y correlativa anual** de los oficios, con tratamiento de **números reservados** (por ejemplo, para documentación confidencial). Falta definir cómo funciona la reserva **[A validar]**.

**HU-03 — Permisos administrativos**
- Campos: funcionario, fecha inicio, fecha término, días o medias jornadas, respaldo firmado.
- Estados: `Pendiente de V°B°` → `Aprobado` | `Rechazado`.
- Alerta visual / notificación interna a Dirección y Administración por solicitudes pendientes.
- Resumen acumulado de días tomados por funcionario en el año.
- Entrevista: se confirmó la necesidad de ver los **días disponibles** por funcionario, lo que requiere conocer los días que corresponden a cada uno al año. Falta definir si solo se registran permisos ya autorizados o si también se solicitan y aprueban en la plataforma **[A validar]**.

**HU-04 — Citaciones**
- Campos: RUN/nombre del estudiante, apoderado, funcionario que cita, fecha/hora, motivo (`Conductual`, `Pedagógico`, `Administrativo`).
- Adjuntar citación firmada o colilla de recepción.
- Estados: `Programada`, `Asistió`, `No asistió / Justificada`, `Reprogramada`.
- Falta definir si solo se almacenan las citaciones o si también se emiten y se les hace seguimiento desde la plataforma **[A validar]**.

**HU-05 — Acuerdos con apoderados**
- Siempre categorizados como **Confidencial**.
- Lectura restringida a Convivencia Escolar y Dirección (UTP opcional si el compromiso es pedagógico **[A validar]**).
- Búsqueda rápida por nombre o RUN del estudiante.
- Entrevista: Convivencia maneja también **expedientes, entrevistas y protocolos**, y su sistematización es la prioridad de la directora. Falta verificar si HU-05 basta o si se necesitan historias de usuario nuevas **[A validar]**.

**HU-06 — Reuniones comunales**
- Material: minutas, orientaciones técnicas y presentaciones de reuniones comunales o de microcentro.
- Tipo de red: `Red de UTP`, `Reunión de Directores`, `Mesa Comunal de Convivencia`, `DAEM/SLEP General`.
- Registro de compromisos con fecha límite y estado.
- Todos los roles directivos pueden consultar y descargar.

**HU-07 — Buscador**
- Filtros: tipo de documento, rango de fechas, rol emisor, estado.
- Búsqueda de texto por título o palabras clave del asunto.
- La historia también pide buscar por remitente y por estudiante (nombre o RUN).
- Entrevista: se confirmó la búsqueda por **fecha, tema o referencia**.
- Los resultados respetan la matriz de roles: nadie ve en el buscador documentos que no puede abrir.

**HU-08 — Bitácora**
- Registro automático de: usuario, acción (subir, editar, descargar, eliminar), documento y fecha/hora. El diagrama de flujo agrega también los accesos denegados.
- Pueden ver la bitácora: Administración y Dirección. Para Administración, los documentos confidenciales aparecen sin título (propuesta del equipo, ver DESIGN §5.6) **[A validar]**.
- Eliminación con confirmación; los documentos van a una **papelera** (borrado lógico) accesible solo por Administración.
- Entrevista: se identificó la necesidad de **recuperar documentos eliminados por error**, así que la papelera debe permitir restaurarlos. La restauración también queda en la bitácora (propuesta del equipo).

## 8. Reglas de negocio clave

1. **Archivos permitidos**: PDF o Word (`.pdf`, `.doc`, `.docx`), máximo **15 MB**. Conflicto con HU-06, que menciona "presentaciones": definir si se aceptan `.ppt`/`.pptx` **[A validar]**.
2. **Folio único** por clase (memo/oficio), folio y año escolar.
3. **Confidencialidad**: los acuerdos con apoderados (y, si se incorporan, los expedientes de Convivencia) solo son visibles para Dirección y Convivencia Escolar. Las citaciones no son confidenciales: también las ve Secretaría, según la matriz de la sección 5. Los criterios para guardar la documentación reservada siguen pendientes **[A validar]**.
4. **Permiso administrativo aprobado** suma días al acumulado anual del funcionario; uno rechazado no.
5. **Toda acción** sobre un documento queda en bitácora, incluidos los intentos de acceso denegado.
6. **Borrado lógico** (`eliminado_en`); no se eliminan archivos físicamente desde la interfaz de usuario. Puede eliminar quien cargó el documento o Dirección (supuesto) **[A validar]**.
7. La visibilidad de cada documento se determina por la **matriz de roles** (sección 5).

## 9. Flujo principal (registro y consulta de un documento)

1. **Acceso**: el usuario inicia sesión → se cargan su rol y módulos permitidos → elige tipo de documento → si el rol no puede cargar ese tipo: acceso denegado + bitácora.
2. **Validación**: completa metadatos y adjunta archivo → valida formato/tamaño → si es memo u oficio, valida folio duplicado → define visibilidad (confidencial o según matriz de roles).
3. **Registro**: guarda e indexa → registra en bitácora → si es permiso administrativo, queda pendiente de V°B° y alerta a Dirección/Administración → Dirección aprueba o rechaza (supuesto **[A validar]**) → queda disponible en el buscador.

Diagrama completo: `flujo.html` (carpeta `Evidencias técnicas/`, fuera del repositorio).

## 10. Modelo de datos (preliminar)

Entidades del MER (`mer.html`, carpeta `Evidencias técnicas/`, fuera del repositorio). El MER usa nombres en singular (`DOCUMENTO`, `BITACORA`…); aquí se muestran como tablas en plural, según la convención de Laravel:

| Entidad | Propósito |
|---|---|
| `roles` | Los 5 roles del sistema |
| `usuarios` | Integrantes del equipo directivo (rol, email único, contraseña hasheada, activo). Propuesta: usar la tabla `users` de Laravel con estos campos (ver PLAN §5) |
| `documentos` | Tabla base: tipo, título, fecha, ruta del archivo, tamaño, confidencial, eliminado_en |
| `bitacoras` | Usuario, documento, acción, fecha/hora |
| `correspondencias` | Detalle de memo/oficio (1:1 con documento). Único: clase + folio + año escolar |
| `funcionarios` | Personal que solicita permisos (RUN único) |
| `permisos_administrativos` | Funcionario, fechas, días, estado |
| `estudiantes` | RUN único, nombre, curso, apoderado |
| `apoderados` | RUN único, nombre, teléfono |
| `citaciones` | Documento, estudiante, usuario que cita, fecha/hora, motivo, estado |
| `acuerdos_apoderados` | Documento, estudiante, ámbito, fecha de firma |
| `reuniones_comunales` | Documento, tipo de red, fecha |
| `compromisos` | Reunión, descripción, fecha límite, estado |

## 11. Stack tecnológico

**Stack confirmado: Laravel + PHP + MySQL.** No se usarán otros frameworks ni motores de base de datos.
(El Avance 1 todavía dice que la selección de tecnologías "deberá evaluarse"; actualizar ese texto en el próximo informe.)

| Capa | Tecnología |
|---|---|
| Framework | **Laravel** |
| Lenguaje | **PHP** |
| Base de datos | **MySQL** |
| Autenticación | Sistema de autenticación de Laravel (contraseñas con hash) |
| Almacenamiento de archivos | Sistema de archivos de Laravel (`storage/`, disco privado, sin URLs públicas) |
| Licencias | Solo herramientas de código abierto (costo $0 en licencias) |

Frontend: Blade (confirmado) + Tailwind CSS (propuesto; se confirma en la Fase 0 según PLAN §5). Gestor de paquetes de JavaScript: pnpm (decidido). El diseño de pantallas y componentes está en [DESIGN.md](DESIGN.md).

Entorno de desarrollo (actualizado el 20-11-2026, PLAN §5): instalación manual de PHP y Composer, sin Herd, con Git 2.56.1; pendientes: MySQL Community Server 8.4 LTS, Node.js LTS y pnpm. Versiones instaladas: **Laravel Framework 13.43.0**, **PHP 8.5.12** y Composer 2.11.2.

Pendiente de definir **[A validar]**: hosting (servidor de la Corporación Municipal u otro), estrategia de respaldos.

## 12. Requisitos no funcionales

- **Seguridad**: RBAC en cada ruta y acción; archivos servidos solo a través de la aplicación tras verificar permisos; protección CSRF; validación de entradas.
- **Privacidad**: datos de estudiantes y apoderados tratados como sensibles.
- **Usabilidad**: interfaz muy simple en español, pensada para personas que hasta hoy trabajan solo en papel: lenguaje profesional y claro (sin jerga informática), pasos guiados, botones grandes con texto y ayuda en cada pantalla (detalle en DESIGN.md).
- **Rendimiento**: encontrar un documento con el buscador en menos de 1 minuto, frente a los 5–10 minutos de hoy (meta propuesta por el equipo **[A validar]**).
- **Costo**: sin licencias pagadas; despliegue de bajo costo.
- **Mantenibilidad**: código ordenado según convenciones de Laravel, migraciones y seeders versionados.

## 13. Criterios de éxito

Las metas numéricas son una propuesta del equipo y se ajustarán con la directora a partir de una línea base real.

- [ ] Los 5 roles inician sesión y solo ven los módulos que les corresponden.
- [ ] Los 6 tipos de documento se pueden cargar, clasificar y descargar.
- [ ] Un documento se encuentra con el buscador en menos de 1 minuto.
- [ ] El sistema impide repetir un folio dentro del mismo año escolar.
- [ ] Toda acción de subir, editar, descargar o eliminar queda en bitácora con usuario, fecha y hora.
- [ ] Los acuerdos con apoderados no son visibles para roles sin autorización.
- [ ] La solución no requiere pago de licencias.
- [ ] Después de la capacitación, cada usuario puede registrar y encontrar un documento **sin ayuda** (propuesta del equipo).
- [ ] La directora valida la plataforma y el equipo directivo la usa en su trabajo diario.

## 14. Restricciones y supuestos

- Sin presupuesto para adquirir software.
- La escuela no tiene infraestructura ni credenciales que entregar: el equipo de desarrollo define el entorno.
- Las pruebas iniciales se harán con **datos ficticios**; no se cargarán datos reales de estudiantes durante el desarrollo.
- Disponibilidad de la contraparte limitada a los miércoles.

## 15. Preguntas abiertas para la directora

Ya respondidas en la entrevista: cómo se guardan hoy los documentos (archivadores físicos) y cuánto se demora una búsqueda (5–10 min).

**Prioritarias (afectan el diseño de roles y de los primeros módulos):**

1. ¿Cómo se relacionan Inspectoría General y Coordinación Académica con los perfiles Administración y UTP? ¿Qué puede ver y hacer cada cargo?
2. ¿Quién otorga el V°B° de los permisos? ¿Solo se registran permisos ya autorizados o también se solicitan y aprueban en la plataforma? ¿El solicitante ve el estado de su solicitud?
3. ¿Cómo funciona la reserva de números de oficio?
4. Convivencia Escolar: ¿qué contienen los expedientes, entrevistas y protocolos, quién los consulta y basta HU-05 para cubrirlos?
5. ¿Quién puede eliminar documentos?

**Otras:**

6. ¿Cuántos memos, oficios y citaciones se generan al mes?
7. ¿Qué equipos computacionales y conexión a internet hay disponibles?
8. ¿Dónde se alojará la plataforma (servidor de la Corporación Municipal u otro)?
9. ¿El paso de lista debe incluirse en la plataforma?
10. ¿UTP debe ver acuerdos con apoderados cuando son de carácter pedagógico?
11. ¿Cuántos funcionarios hay (docentes y asistentes) para el módulo de permisos?
12. ¿Cuántos días de permiso administrativo corresponden por funcionario al año?
13. ¿Se deben aceptar presentaciones (`.ppt`/`.pptx`) en reuniones comunales, o solo PDF y Word?
14. ¿Quién mantiene el listado de funcionarios, estudiantes y apoderados en la plataforma?
15. ¿Las ocho historias de usuario y su prioridad están aprobadas?
16. Citaciones: ¿solo se almacenan o también se emiten y se les hace seguimiento?
17. ¿La matrícula oficial es de 208 o 209 estudiantes?
18. ¿Hay escáner disponible para digitalizar documentos en papel? ¿Se cargarán documentos de años anteriores?

## 16. Próximos pasos

El detalle por fases, el cronograma, los riesgos y las decisiones técnicas están en [PLAN.md](PLAN.md). En resumen:

1. Crear el proyecto Laravel y configurar la conexión a MySQL.
2. Implementar migraciones y seeders según el modelo de datos (roles y usuarios de prueba).
3. Implementar autenticación y middleware de roles (HU-01).
4. Desarrollar los módulos por prioridad: Correspondencia (HU-02) y Permisos (HU-03) → Acuerdos/Convivencia (HU-05) → Citaciones (HU-04) → Reuniones (HU-06) → Buscador y Bitácora (HU-07, HU-08).
5. Pruebas con datos ficticios y validación con la directora.
