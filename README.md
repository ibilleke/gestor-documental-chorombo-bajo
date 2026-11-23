# Gestor Documental Chorombo Bajo

Plataforma web de gestión documental para el equipo directivo de la **Escuela Básica G733 Chorombo Bajo** (María Pinto). Permite registrar, consultar y resguardar de forma ordenada los documentos que hoy se administran en papel: memos, oficios, permisos administrativos, citaciones y acuerdos con apoderados, y documentos de reuniones comunales.

Además, se contempla un acceso acotado para docentes y un portal en el que cada apoderado consulta solo la información de sus propios pupilos (en validación con la dirección del establecimiento).

Proyecto desarrollado en el marco de la asignatura Clínicas Tecnológicas del Instituto Profesional San Sebastián.

> **Estado:** Fase 2 (base del sistema, HU-01). Entorno de desarrollo completo (Fase 0). Implementados: roles, permisos, usuarios e inicio y cierre de sesión. Los módulos documentales aún no están implementados.

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
| Vistas | Blade + Tailwind CSS 4 |
| Node.js | 26 LTS |
| Gestor de paquetes de JavaScript | pnpm 12 |
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

4. Iniciar MySQL (si no está instalado como servicio, en una terminal aparte que debe quedar abierta):

   ```powershell
   mysqld --console
   ```

5. Crear las bases de datos de desarrollo y de pruebas, y completar en `.env` el usuario y la contraseña de MySQL (`DB_USERNAME` y `DB_PASSWORD`):

   ```sql
   CREATE DATABASE gestor_documental CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
   CREATE DATABASE gestor_documental_test CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
   ```

6. Ejecutar las migraciones y cargar los datos base (roles y permisos) y los usuarios ficticios de prueba. La contraseña de esos usuarios está en `database/seeders/UsuarioPruebaSeeder.php`; nunca se cargan en producción:

   ```powershell
   php artisan migrate --seed
   ```

7. Instalar las dependencias del frontend y compilarlas (durante el desarrollo, `pnpm run dev` las recompila al guardar cambios):

   ```powershell
   pnpm install
   pnpm run build
   ```

8. Iniciar el servidor de desarrollo y abrir `http://localhost:8000`, que lleva a la pantalla de inicio de sesión:

   ```powershell
   php artisan serve
   ```

## Pruebas

```powershell
php artisan test
```

Cada funcionalidad incluye pruebas unitarias (`tests/Unit`) y de funcionalidad (`tests/Feature`) asociadas a los criterios de aceptación de su historia de usuario. Las pruebas usan una base de datos MySQL separada, `gestor_documental_test` (configurada en `phpunit.xml`), y nunca la base de desarrollo. MySQL debe estar iniciado para ejecutarlas.

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
