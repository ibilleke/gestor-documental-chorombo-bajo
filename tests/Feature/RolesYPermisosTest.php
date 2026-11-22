<?php

namespace Tests\Feature;

use App\Models\Permiso;
use App\Models\Rol;
use App\Models\User;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolSeeder;
use Database\Seeders\UsuarioPruebaSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolesYPermisosTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_usuario_puede_tener_varios_roles(): void
    {
        $usuario = User::factory()->create();
        $roles = Rol::factory()->count(2)->create();

        $usuario->roles()->attach($roles);

        $this->assertCount(2, $usuario->fresh()->roles);
    }

    public function test_un_rol_agrupa_permisos(): void
    {
        $rol = Rol::factory()->create();
        $rol->permisos()->attach(Permiso::factory()->count(3)->create());

        $this->assertCount(3, $rol->fresh()->permisos);
    }

    public function test_no_se_puede_eliminar_un_rol_con_usuarios_asignados(): void
    {
        $rol = Rol::factory()->create();
        User::factory()->create()->roles()->attach($rol);

        $this->expectException(QueryException::class);

        $rol->delete();
    }

    public function test_el_nombre_del_rol_es_unico(): void
    {
        Rol::factory()->create(['nombre' => 'Secretaría']);

        $this->expectException(QueryException::class);

        Rol::factory()->create(['nombre' => 'Secretaría']);
    }

    public function test_los_seeders_cargan_los_siete_roles_base(): void
    {
        $this->seed([PermisoSeeder::class, RolSeeder::class]);

        $this->assertSame(
            array_keys(RolSeeder::ROLES_BASE),
            Rol::orderBy('id')->pluck('nombre')->all()
        );
        $this->assertSame(count(PermisoSeeder::CATALOGO), Permiso::count());
    }

    public function test_son_delicados_direccion_administracion_y_convivencia(): void
    {
        $this->seed([PermisoSeeder::class, RolSeeder::class]);

        $this->assertEqualsCanonicalizing(
            ['Dirección', 'Administración', 'Convivencia Escolar'],
            Rol::where('delicado', true)->pluck('nombre')->all()
        );
    }

    public function test_direccion_tiene_todo_el_catalogo_y_docente_ningun_permiso(): void
    {
        $this->seed([PermisoSeeder::class, RolSeeder::class]);

        $this->assertSame(Permiso::count(), Rol::firstWhere('nombre', 'Dirección')->permisos()->count());
        $this->assertSame(0, Rol::firstWhere('nombre', 'Docente')->permisos()->count());
    }

    public function test_todos_los_usuarios_de_prueba_tienen_al_menos_un_rol(): void
    {
        $this->seed();

        $this->assertSame(count(UsuarioPruebaSeeder::USUARIOS), User::count());
        $this->assertSame(0, User::doesntHave('roles')->count());
        $this->assertSame(2, User::firstWhere('email', 'utp.convivencia@ejemplo.cl')->roles()->count());
    }

    public function test_los_seeders_se_pueden_ejecutar_dos_veces_sin_duplicar(): void
    {
        $this->seed();
        $this->seed();

        $this->assertSame(count(RolSeeder::ROLES_BASE), Rol::count());
        $this->assertSame(count(UsuarioPruebaSeeder::USUARIOS), User::count());
    }
}
