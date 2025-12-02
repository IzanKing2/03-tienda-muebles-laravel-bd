<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios (puede ser NULL para invitados)
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade'); // Si se borra el usuario se borran sus carritos

            // SesionId único por pestaña/navegador
            $table->string('sesion_id', 100)->unique();

            $table->timestamps();

            // Índices para búsquedas rápidas
            $table->index('usuario_id');
            $table->index('sesion_id');
            $table->index(['usuario_id', 'sesion_id']); // Búsqueda combinada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
