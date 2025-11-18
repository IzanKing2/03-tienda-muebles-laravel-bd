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
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();

            // Relación con carritos
            $table->foreignId('carrito_id')
                ->constrained('carritos')
                ->onDelete('cascade'); // Si se borra el carrito, se borran sus items

            // Relación con productos
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->onDelete('cascade'); // Si se borra un producto, se borra del carrito

            // Cantidad de unidades
            $table->integer('cantidad')->default(1);

            // Precio unitario en el momento de añadir
            $table->decimal('precio_unitario', 10, 2);

            $table->timestamps();

            // Índices
            $table->index('carrito_id');
            $table->index('producto_id');

            // Un producto solo puede estar UNA vez en el mismo carrito
            // (se aumenta la cantidad, no se duplica)
            $table->unique(['carrito_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
