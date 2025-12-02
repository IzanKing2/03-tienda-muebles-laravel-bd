<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Galeria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeria>
 */
class GaleriaFactory extends Factory
{

    protected $model = Galeria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(), // Crea un producto automaticamente
        ];
    }

    /**
     * Estado: galería para un producto específico
     */
    public function paraProducto(Producto $producto)
    {
        return $this->state(function (array $attributes) use ($producto) {
            return [
                'producto_id' => $producto->id,
            ];
        });
    }
}
