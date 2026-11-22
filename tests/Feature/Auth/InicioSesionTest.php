<?php

namespace Tests\Feature\Auth;

use App\Http\Requests\IniciarSesionRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InicioSesionTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pantalla_de_inicio_de_sesion_se_muestra_a_un_invitado(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Iniciar sesión')
            ->assertSee('Correo electrónico');
    }

    public function test_la_raiz_redirige_al_inicio_de_sesion_si_no_hay_sesion(): void
    {
        $this->followingRedirects()->get('/')->assertSee('Gestor Documental');
        $this->get('/panel')->assertRedirect(route('login'));
    }

    public function test_un_usuario_activo_inicia_sesion_con_credenciales_correctas(): void
    {
        $usuario = User::factory()->create();

        $this->post(route('login.store'), ['email' => $usuario->email, 'password' => 'password'])
            ->assertRedirect(route('panel'));

        $this->assertAuthenticatedAs($usuario);
    }

    public function test_la_sesion_se_regenera_al_iniciar_sesion(): void
    {
        $usuario = User::factory()->create();
        $this->startSession();
        $idAnterior = session()->getId();

        $this->post(route('login.store'), ['email' => $usuario->email, 'password' => 'password']);

        $this->assertNotSame($idAnterior, session()->getId());
    }

    public function test_una_contrasena_incorrecta_muestra_un_error_generico(): void
    {
        $usuario = User::factory()->create();

        $this->from(route('login'))
            ->post(route('login.store'), ['email' => $usuario->email, 'password' => 'incorrecta'])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email' => 'Correo o contraseña incorrectos.']);

        $this->assertGuest();
    }

    public function test_un_correo_inexistente_muestra_el_mismo_error_generico(): void
    {
        $this->post(route('login.store'), ['email' => 'noexiste@ejemplo.cl', 'password' => 'password'])
            ->assertSessionHasErrors(['email' => 'Correo o contraseña incorrectos.']);

        $this->assertGuest();
    }

    public function test_los_campos_son_obligatorios(): void
    {
        $this->post(route('login.store'), [])
            ->assertSessionHasErrors([
                'email' => 'El campo correo electrónico es obligatorio.',
                'password' => 'El campo contraseña es obligatorio.',
            ]);
    }

    public function test_un_usuario_desactivado_no_puede_iniciar_sesion(): void
    {
        $usuario = User::factory()->inactivo()->create();

        $this->post(route('login.store'), ['email' => $usuario->email, 'password' => 'password'])
            ->assertSessionHasErrors(['email' => __('auth.inactivo')]);

        $this->assertGuest();
    }

    public function test_se_bloquea_tras_superar_el_maximo_de_intentos(): void
    {
        $usuario = User::factory()->create();

        for ($i = 0; $i < IniciarSesionRequest::MAXIMO_INTENTOS; $i++) {
            $this->post(route('login.store'), ['email' => $usuario->email, 'password' => 'incorrecta']);
        }

        // Ni siquiera la contraseña correcta funciona mientras dura el bloqueo
        $respuesta = $this->post(route('login.store'), ['email' => $usuario->email, 'password' => 'password']);

        $respuesta->assertSessionHasErrors('email');
        $this->assertStringContainsString('Se superó el número de intentos', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_un_usuario_con_sesion_no_ve_la_pantalla_de_inicio_de_sesion(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('login'))
            ->assertRedirect(route('panel'));
    }

    public function test_el_panel_muestra_al_usuario_y_sus_roles(): void
    {
        $usuario = User::factory()->create(['name' => 'Persona Ficticia']);
        $usuario->roles()->attach(Rol::factory()->create(['nombre' => 'Secretaría']));

        $this->actingAs($usuario)
            ->get(route('panel'))
            ->assertOk()
            ->assertSee('Persona Ficticia')
            ->assertSee('Secretaría');
    }

    public function test_un_usuario_cierra_sesion(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_cerrar_sesion_requiere_haber_iniciado_sesion(): void
    {
        $this->post(route('logout'))->assertRedirect(route('login'));
    }
}
