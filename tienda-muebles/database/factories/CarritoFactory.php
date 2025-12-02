<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Carrito;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carrito>
 */
class CarritoFactory extends Factory
{

    protected $model = Carrito::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(), // Crea un usuario automaticamente
            'sesion_id' => 'cart_' . Str::random(32),
        ];
    }

    /**
     * Estado: carrito sin usuario (invitado)
     */
    public function invitado()
    {
        return $this->state(function (array $attributes) {
            return [
                'usuario_id' => null,
            ];
        });
    }

    /**
     * Estado: para un usuario específico
     */
    public function paraUsuario(User $usuario)
    {
        return $this->state(function (array $attributes) use ($usuario) {
            return [
                'usuario_id' => $usuario->id,
            ];
        });
    }

    /**
     * Estado: con sesión específica
     */
    public function conSesion(string $sesionId)
    {
        return $this->state(function (array $attributes) use ($sesionId) {
            return [
                'sesion_id' => $sesionId,
            ];
        });
    }
}
