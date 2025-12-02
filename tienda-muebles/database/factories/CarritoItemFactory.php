<?php

namespace Database\Factories;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarritoItem>
 */
class CarritoItemFactory extends Factory
{

    protected $model = CarritoItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtenemos un producto al azar
        $producto = Producto::inRandomOrder()->first();

        // Si no hay productos, creamos uno
        if (!$producto) {
            $producto = Producto::factory()->create();
        }

        return [
            'carrito_id' => Carrito::factory(), // Se creará automáticamente
            'producto_id' => $producto->id,
            'cantidad' => $this->faker->numberBetween(1, 5),
            'precio_unitario' => $producto->precio, // Usar el precio actual del producto
        ];
    }

    /**
     * Estado: item con producto específico
     */
    public function paraProducto(Producto $producto)
    {
        return $this->state(function (array $attributes) use ($producto) {
            return [
                'producto_id' => $producto->id,
                'precio_unitario' => $producto->precio,
            ];
        });
    }

    /**
     * Estado: item con carrito específico
     */
    public function paraCarrito(Carrito $carrito)
    {
        return $this->state(function (array $attributes) use ($carrito) {
            return [
                'carrito_id' => $carrito->id,
            ];
        });
    }

    /**
     * Estado: item con cantidad específica
     */
    public function conCantidad(int $cantidad)
    {
        return $this->state(function (array $attributes) use ($cantidad) {
            return [
                'cantidad' => $cantidad,
            ];
        });
    }
}
