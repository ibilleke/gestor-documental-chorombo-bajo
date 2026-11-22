<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermisoSeeder::class,
            RolSeeder::class,
        ]);

        // Los usuarios ficticios solo se cargan en desarrollo y pruebas
        if (app()->environment(['local', 'testing'])) {
            $this->call(UsuarioPruebaSeeder::class);
        }
    }
}
