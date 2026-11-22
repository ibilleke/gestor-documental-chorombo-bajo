<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

/**
 * Catálogo preliminar de permisos (formato modulo.accion), derivado de la matriz
 * del BRIEF §5 y del menú de DESIGN §4. Se ajustará con MATRIZ_PERMISOS.md.
 */
class PermisoSeeder extends Seeder
{
    /**
     * Nombre => [descripción, sensible].
     *
     * @var array<string, array{0: string, 1: bool}>
     */
    public const CATALOGO = [
        'usuarios.ver' => ['Ver usuarios', false],
        'usuarios.crear' => ['Crear usuarios', false],
        'usuarios.editar' => ['Editar, activar y desactivar usuarios', false],
        'roles.configurar' => ['Crear y configurar roles y sus permisos', true],
        'roles.asignar' => ['Asignar y retirar cualquier rol sin aprobación', true],
        'roles.asignar_no_delicados' => ['Asignar y retirar roles no delicados', true],
        'roles.solicitar' => ['Solicitar la asignación o el retiro de roles delicados', true],
        'correspondencia.ver' => ['Consultar memos y oficios', false],
        'correspondencia.crear' => ['Registrar memos y oficios', false],
        'correspondencia.editar' => ['Editar memos y oficios', false],
        'correspondencia.eliminar' => ['Eliminar memos y oficios', false],
        'permisos_administrativos.ver' => ['Consultar permisos administrativos', false],
        'permisos_administrativos.crear' => ['Registrar solicitudes de permiso administrativo', false],
        'permisos_administrativos.editar' => ['Editar permisos administrativos', false],
        'permisos_administrativos.aprobar' => ['Aprobar o rechazar permisos administrativos', true],
        'citaciones.ver' => ['Consultar citaciones', false],
        'citaciones.crear' => ['Registrar citaciones', false],
        'citaciones.editar' => ['Editar citaciones', false],
        'citaciones.eliminar' => ['Eliminar citaciones', false],
        'acuerdos.ver' => ['Consultar acuerdos con apoderados (confidenciales)', true],
        'acuerdos.crear' => ['Registrar acuerdos con apoderados', true],
        'acuerdos.editar' => ['Editar acuerdos con apoderados', true],
        'acuerdos.eliminar' => ['Eliminar acuerdos con apoderados', true],
        'reuniones.ver' => ['Consultar reuniones comunales', false],
        'reuniones.crear' => ['Registrar reuniones comunales', false],
        'reuniones.editar' => ['Editar reuniones comunales y sus compromisos', false],
        'reuniones.eliminar' => ['Eliminar reuniones comunales', false],
        'documentos.ver_confidenciales' => ['Ver documentos confidenciales', true],
        'bitacora.ver' => ['Consultar la bitácora', true],
        'bitacora.ver_reservada' => ['Consultar los registros reservados de gestión de roles', true],
        'papelera.ver' => ['Consultar la papelera', false],
        'papelera.restaurar' => ['Restaurar documentos eliminados', false],
        'portal.ver_pupilos' => ['Consultar los datos de los propios pupilos', false],
        'portal.solicitar_documentos' => ['Solicitar documentos para los propios pupilos', false],
    ];

    public function run(): void
    {
        foreach (self::CATALOGO as $nombre => [$descripcion, $sensible]) {
            Permiso::updateOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $descripcion, 'sensible' => $sensible],
            );
        }
    }
}
