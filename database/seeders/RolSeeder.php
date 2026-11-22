<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

/**
 * Los 7 roles base (BRIEF §5) con su asignación preliminar de permisos [A validar].
 * Debe ejecutarse después de PermisoSeeder.
 */
class RolSeeder extends Seeder
{
    /**
     * Nombre => [descripción, permisos]. El valor '*' asigna todo el catálogo.
     *
     * @var array<string, array{0: string, 1: list<string>|string}>
     */
    public const ROLES_BASE = [
        'Dirección' => ['Supervisión transversal y aprobación institucional', '*'],
        'Administración' => ['Gestión operativa y técnica de la plataforma', [
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar',
            'roles.asignar_no_delicados', 'roles.solicitar',
            'permisos_administrativos.ver', 'permisos_administrativos.crear', 'permisos_administrativos.editar',
            'reuniones.ver', 'bitacora.ver', 'papelera.ver', 'papelera.restaurar',
        ]],
        'Secretaría' => ['Correspondencia oficial y citaciones', [
            'correspondencia.ver', 'correspondencia.crear', 'correspondencia.editar',
            'citaciones.ver', 'citaciones.crear', 'citaciones.editar',
            'permisos_administrativos.crear', 'reuniones.ver',
        ]],
        'Jefatura de UTP' => ['Gestión técnico-pedagógica', [
            'correspondencia.ver', 'permisos_administrativos.crear',
            'reuniones.ver', 'reuniones.crear', 'reuniones.editar',
        ]],
        'Convivencia Escolar' => ['Casos de convivencia y apoderados', [
            'citaciones.ver', 'citaciones.crear', 'citaciones.editar',
            'acuerdos.ver', 'acuerdos.crear', 'acuerdos.editar',
            'permisos_administrativos.crear', 'reuniones.ver',
        ]],
        // Sin permisos mientras la directora no los defina [A validar]
        'Docente' => ['Profesores que no integran el equipo directivo', []],
        'Apoderado' => ['Padres, madres o tutores', [
            'portal.ver_pupilos', 'portal.solicitar_documentos',
        ]],
    ];

    public function run(): void
    {
        $catalogo = Permiso::pluck('id', 'nombre');

        foreach (self::ROLES_BASE as $nombre => [$descripcion, $permisos]) {
            $rol = Rol::updateOrCreate(['nombre' => $nombre], ['descripcion' => $descripcion]);

            $ids = $permisos === '*' ? $catalogo->values() : $catalogo->only($permisos)->values();
            $rol->permisos()->sync($ids);

            // Un rol con un permiso sensible queda marcado como delicado
            $rol->load('permisos');
            $rol->update(['delicado' => $rol->esDelicado()]);
        }
    }
}
