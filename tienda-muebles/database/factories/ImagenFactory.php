<?php

namespace Database\Factories;

use App\Models\Galeria;
use App\Models\Imagen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Imagen>
 */
class ImagenFactory extends Factory
{

    protected $model = Imagen::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'galeria_id' => Galeria::factory(), // Crea una galeria automaticamente
            'ruta' => 'productos/placeholder-' . $this->faker->numberBetween(1, 10) . '.jpg',
            'es_principal' => false,
            'orden' => $this->faker->numberBetween(1, 5),
        ];
    }

    /**
     * Estado: imagen principal
     */
    public function principal()
    {
        return $this->state(function (array $attributes) {
            return [
                'es_principal' => true,
                'orden' => 1,
            ];
        });
    }

    /**
     * Estado: para una galería específica
     */
    public function paraGaleria(Galeria $galeria)
    {
        return $this->state(function (array $attributes) use ($galeria) {
            return [
                'galeria_id' => $galeria->id,
            ];
        });
    }

    /**
     * Estado: con orden específico
     */
    public function conOrden(int $orden)
    {
        return $this->state(function (array $attributes) use ($orden) {
            return [
                'orden' => $orden,
            ];
        });
    }
}
