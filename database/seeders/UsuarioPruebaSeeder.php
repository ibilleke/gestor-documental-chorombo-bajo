<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Usuarios ficticios para desarrollo y pruebas: uno por rol base y uno con dos roles.
 * Nunca se ejecuta en producción (ver DatabaseSeeder).
 */
class UsuarioPruebaSeeder extends Seeder
{
    /**
     * Contraseña común de los usuarios de prueba. Solo para el entorno local.
     */
    public const CLAVE_PRUEBA = 'Chorombo-Prueba-2026';

    /**
     * Correo => [nombre ficticio, roles].
     *
     * @var array<string, array{0: string, 1: list<string>}>
     */
    public const USUARIOS = [
        'direccion@ejemplo.cl' => ['Usuario Dirección', ['Dirección']],
        'administracion@ejemplo.cl' => ['Usuario Administración', ['Administración']],
        'secretaria@ejemplo.cl' => ['Usuario Secretaría', ['Secretaría']],
        'utp@ejemplo.cl' => ['Usuario UTP', ['Jefatura de UTP']],
        'convivencia@ejemplo.cl' => ['Usuario Convivencia', ['Convivencia Escolar']],
        'docente@ejemplo.cl' => ['Usuario Docente', ['Docente']],
        'apoderado@ejemplo.cl' => ['Usuario Apoderado', ['Apoderado']],
        'utp.convivencia@ejemplo.cl' => ['Usuario UTP y Convivencia', ['Jefatura de UTP', 'Convivencia Escolar']],
    ];

    public function run(): void
    {
        $roles = Rol::pluck('id', 'nombre');

        foreach (self::USUARIOS as $correo => [$nombre, $nombresRoles]) {
            $usuario = User::updateOrCreate(
                ['email' => $correo],
                ['name' => $nombre, 'password' => self::CLAVE_PRUEBA, 'activo' => true],
            );

            $usuario->roles()->sync($roles->only($nombresRoles)->values());
        }
    }
}
