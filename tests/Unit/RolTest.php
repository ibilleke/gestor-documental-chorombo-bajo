<?php

namespace Tests\Unit;

use App\Models\Permiso;
use App\Models\Rol;
use PHPUnit\Framework\TestCase;

class RolTest extends TestCase
{
    private function rolCon(bool $marcaManual, array $sensibles): Rol
    {
        $rol = new Rol(['nombre' => 'Rol ficticio', 'delicado' => $marcaManual]);
        $permisos = array_map(fn (bool $sensible) => new Permiso(['nombre' => 'modulo.ver', 'sensible' => $sensible]), $sensibles);

        return $rol->setRelation('permisos', collect($permisos));
    }

    public function test_un_rol_sin_permisos_sensibles_ni_marca_no_es_delicado(): void
    {
        $this->assertFalse($this->rolCon(false, [false, false])->esDelicado());
    }

    public function test_un_rol_con_un_permiso_sensible_es_delicado(): void
    {
        $this->assertTrue($this->rolCon(false, [false, true])->esDelicado());
    }

    public function test_un_rol_marcado_por_direccion_es_delicado_aunque_no_tenga_permisos_sensibles(): void
    {
        $this->assertTrue($this->rolCon(true, [])->esDelicado());
    }
}
