<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ConfiguracionRegionalTest extends TestCase
{
    public function test_la_zona_horaria_es_la_de_chile(): void
    {
        $this->assertSame('America/Santiago', config('app.timezone'));
        $this->assertSame('America/Santiago', date_default_timezone_get());
    }

    public function test_el_idioma_de_la_aplicacion_es_espanol(): void
    {
        $this->assertSame('es', app()->getLocale());
    }

    public function test_los_mensajes_de_validacion_estan_en_espanol(): void
    {
        $validador = Validator::make(['email' => ''], ['email' => 'required']);

        $this->assertSame(
            'El campo correo electrónico es obligatorio.',
            $validador->errors()->first('email')
        );
    }

    public function test_las_fechas_se_muestran_en_espanol_y_formato_chileno(): void
    {
        $fecha = Carbon::create(2026, 3, 5, 14, 30);

        $this->assertSame('05-03-2026 14:30', $fecha->format('d-m-Y H:i'));
        $this->assertSame('jueves 5 de marzo', $fecha->translatedFormat('l j \d\e F'));
    }

    public function test_las_pruebas_usan_la_base_de_datos_de_pruebas(): void
    {
        $this->assertSame('mysql', DB::connection()->getDriverName());
        $this->assertSame('gestor_documental_test', DB::connection()->getDatabaseName());
    }
}
