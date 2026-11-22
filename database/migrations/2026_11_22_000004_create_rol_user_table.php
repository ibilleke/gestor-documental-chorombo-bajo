<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rol_user', function (Blueprint $table) {
            // No se puede eliminar un rol mientras tenga usuarios asignados
            $table->foreignId('rol_id')->constrained(table: 'roles')->restrictOnDelete();
            $table->foreignId('user_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['rol_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol_user');
    }
};
