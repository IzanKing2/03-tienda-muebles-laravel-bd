<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{

    protected $model = Categoria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = [
            ['nombre' => 'Salón', 'descripcion' => 'Muebles para el salón: sofas, mesas, estanterias, etc.'],
            ['nombre' => 'Dormitorio', 'descripcion' => 'Muebles para el dormitorio: camas, armarios, etc.'],
            ['nombre' => 'Comedor', 'descripcion' => 'Muebles para el comedor: mesas, sillas, etc.'],
            ['nombre' => 'Oficina', 'descripcion' => 'Muebles para la oficina: mesas, sillas, etc.'],
            ['nombre' => 'Baño', 'descripcion' => 'Muebles para el baño: baños, etc.'],
            ['nombre' => 'Jardin', 'descripcion' => 'Muebles para el jardin: jardines, etc.'],
        ];

        $categoria = $this->faker->randomElement($categorias);

        return [
            'nombre' => $categoria['nombre'],
            'descripcion' => $categoria['descripcion'],
        ];
    }
}
