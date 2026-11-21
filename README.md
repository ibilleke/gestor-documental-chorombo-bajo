# Gestor Documental Chorombo Bajo

Plataforma web de gestión documental para el equipo directivo de la **Escuela Básica G733 Chorombo Bajo** (María Pinto). Permite registrar, consultar y resguardar de forma ordenada los documentos que hoy se administran en papel: memos, oficios, permisos administrativos, citaciones y acuerdos con apoderados, y documentos de reuniones comunales.

Además, se contempla un acceso acotado para docentes y un portal en el que cada apoderado consulta solo la información de sus propios pupilos (en validación con la dirección del establecimiento).

Proyecto desarrollado en el marco de la asignatura Clínicas Tecnológicas del Instituto Profesional San Sebastián.

> **Estado:** Fase 0 (preparación del entorno). El repositorio contiene el esqueleto base de Laravel y la documentación del proyecto; los módulos aún no están implementados.

## Módulos previstos

| Historia de usuario | Módulo |
|---|---|
| HU-01 | Usuarios, roles configurables y permisos |
| HU-02 | Correspondencia (memos y oficios) |
| HU-03 | Permisos administrativos |
| HU-04 | Citaciones |
| HU-05 | Acuerdos con apoderados (confidencial) |
| HU-06 | Reuniones comunales |
| HU-07 | Buscador |
| HU-08 | Bitácora y papelera |
| HU-09 | Portal de apoderados (en validación) |

El detalle de cada historia, sus criterios de aceptación y las reglas de negocio está en [documentos/BRIEF.md](documentos/BRIEF.md).

## Tecnologías

| Componente | Versión |
|---|---|
| PHP | 8.5 |
| Laravel | 13 |
| MySQL | 8.4 LTS |
| Vistas | Blade |
| Gestor de paquetes de JavaScript | pnpm |
| Pruebas | PHPUnit |

## Requisitos

- PHP 8.5 con las extensiones `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_mysql` y `zip` activadas, además de las que PHP incluye por defecto.
- Composer 2.
- MySQL Community Server 8.4 LTS.
- Node.js LTS y pnpm (para compilar los estilos del frontend).
- Git.

## Instalación local

1. Clonar el repositorio y entrar en la carpeta del proyecto.
2. Instalar las dependencias de PHP:

   ```powershell
   composer install
   ```

3. Crear el archivo de configuración local a partir del ejemplo y generar la clave de la aplicación:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

4. Crear en MySQL la base de datos `gestor_documental` y completar en `.env` el usuario y la contraseña de MySQL (`DB_USERNAME` y `DB_PASSWORD`).
5. Ejecutar las migraciones:

   ```powershell
   php artisan migrate
   ```

6. Instalar las dependencias del frontend y compilarlas:

   ```powershell
   pnpm install
   pnpm run build
   ```

7. Iniciar el servidor de desarrollo y abrir `http://localhost:8000`:

   ```powershell
   php artisan serve
   ```

## Pruebas

```powershell
php artisan test
```

Cada funcionalidad incluye pruebas unitarias (`tests/Unit`) y de funcionalidad (`tests/Feature`) asociadas a los criterios de aceptación de su historia de usuario. Las pruebas usarán una base de datos MySQL separada, `gestor_documental_test`, y nunca la base de desarrollo (configuración pendiente hasta instalar MySQL).

## Documentación

| Documento | Contenido |
|---|---|
| [documentos/BRIEF.md](documentos/BRIEF.md) | Contexto, roles, alcance, historias de usuario, reglas de negocio y modelo de datos |
| [documentos/PLAN.md](documentos/PLAN.md) | Fases, cronograma, decisiones técnicas, pendientes y riesgos |
| [documentos/DESIGN.md](documentos/DESIGN.md) | Diseño de la interfaz: usuarios, pantallas, componentes, estilo y textos |

## Seguridad y protección de datos

- Durante el desarrollo se utilizan **exclusivamente datos ficticios**. No se cargan datos reales de estudiantes, apoderados ni funcionarios.
- El archivo `.env` y cualquier credencial quedan fuera del repositorio.
- El acceso se controla por roles y permisos (RBAC) con las funciones nativas de Laravel: todo lo que no está autorizado se niega. Los roles delicados solo se asignan con aprobación de Dirección, y un apoderado solo accede a la información de sus propios pupilos.
- Los archivos adjuntos se almacenan en un disco privado y solo se entregan a través de un controlador que verifica los permisos del usuario.
- Toda acción sobre un documento queda registrada en la bitácora, y la eliminación es lógica, con posibilidad de restauración.
- La información de estudiantes y apoderados se trata como sensible, conforme a la Ley 19.628 y la Ley 21.719.

## Licencia

Pendiente de definir con la institución.
