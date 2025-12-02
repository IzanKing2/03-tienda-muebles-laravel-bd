<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Arrays de datos realistas para muebles
        $tipos = ['Mesa', 'Silla', 'Cama', 'Armario', 'Escritorio', 'Sofa', 'Mesita', 'Cajonera'];
        $estilos = ['Moderno', 'Clásico', 'Industrial', 'Rustico', 'Minimalista', 'Scandinavo', 'Vanguardista', 'Contemporáneo'];
        $materiales = [
            'Madera de roble maciza',
            'MDF lacado',
            'Metal y vidrio templado',
            'Pino natural',
            'Nogal americano',
            'Acero inoxidable y madera',
            'Contrachapado de abedul',
        ];
        $colores = ['blanco', 'negro', 'gris', 'marrón', 'beige', 'azul', 'verde', 'rojo'];

        $tipo = $this->faker->randomElement($tipos);
        $estilo = $this->faker->randomElement($estilos);
        $material = $this->faker->randomElement($materiales);
        $color = $this->faker->randomElement($colores);

        return [
            'nombre' => "$tipo $estilo de $color",
            'descripcion' => $this->faker->paragraph(3) . ' ' .
                "Perfecta para cualquier espacio. Diseño {$estilo} que combina funcionalidad y estética. " .
                $this->faker->sentence(10),
            'precio' => $this->faker->randomFloat(2, 50, 2000), // Entre 50€ y 2000€
            'stock' => $this->faker->numberBetween(0, 50),
            'materiales' => $material . '. ' . $this->faker->sentence(8),
            'dimensiones' => $this->generarDimensiones($tipo),
            'color_principal' => $color,
            'destacado' => $this->faker->boolean(20), // 20% destacados
            'imagen_principal' => 'productos/placeholder.jpg', // Placeholder por ahora
        ];
    }

    /**
     * Generar dimensiones realistas según el tipo de mueble
     */
    private function generarDimensiones(string $tipo): string
    {
        $dimensiones = [
            'Mesa' => $this->faker->randomElement([
                '120x80x75 cm',
                '160x90x75 cm',
                '200x100x75 cm',
                '140x70x75 cm',
            ]),
            'Silla' => $this->faker->randomElement([
                '45x50x85 cm',
                '50x55x90 cm',
                '42x48x82 cm',
            ]),
            'Sofá' => $this->faker->randomElement([
                '200x90x80 cm',
                '220x95x85 cm',
                '180x85x75 cm',
                '250x100x90 cm',
            ]),
            'Estantería' => $this->faker->randomElement([
                '80x30x180 cm',
                '100x35x200 cm',
                '120x40x210 cm',
            ]),
            'Cama' => $this->faker->randomElement([
                '140x200x100 cm', // Individual
                '150x200x100 cm', // Matrimonio
                '180x200x100 cm', // King
            ]),
            'Armario' => $this->faker->randomElement([
                '120x60x200 cm',
                '150x60x220 cm',
                '200x60x240 cm',
            ]),
            'Escritorio' => $this->faker->randomElement([
                '120x60x75 cm',
                '140x70x75 cm',
                '100x50x75 cm',
            ]),
            'Mesita' => $this->faker->randomElement([
                '40x40x50 cm',
                '50x50x55 cm',
                '45x45x60 cm',
            ]),
            'Cómoda' => $this->faker->randomElement([
                '80x40x90 cm',
                '100x45x100 cm',
                '120x50x95 cm',
            ]),
            'Aparador' => $this->faker->randomElement([
                '140x45x80 cm',
                '160x50x85 cm',
                '180x45x90 cm',
            ]),
        ];

        return $dimensiones[$tipo] ?? '100x50x75 cm';
    }

    /**
     * Estado: producto destacado
     */
    public function destacado()
    {
        return $this->state(function (array $attributes) {
            return [
                'destacado' => true,
            ];
        });
    }

    /**
     * Estado: producto sin stock
     */
    public function sinStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => 0,
            ];
        });
    }

    /**
     * Estado: producto con mucho stock
     */
    public function muchoStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => $this->faker->numberBetween(100, 500),
            ];
        });
    }
}
