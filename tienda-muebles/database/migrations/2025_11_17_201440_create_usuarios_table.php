<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();

            // Relación con roles
            // foreignId('rol_id'): crea columna rol_id
            // constrained('roles'): crea la foreign key hacia la tabla roles
            // onDelete('restrict'): no permite borrar un rol si tiene usuarios asignados
            $table->foreignId('rol_id')->constrained('roles')->onDelete('restrict');

            // Datos personales
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('email', 150)->unique();
            $table->string('password');

            // Control de login
            $table->integer('intentos_fallidos')->default(0); // Contador de intentos fallidos -> limite 3
            $table->timestamp('blequeado_hasta')->nullable(); // Tiempo de bloqueo aplicado

            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index('email');
            $table->index(['blequeado_hasta', 'intentos_fallidos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
