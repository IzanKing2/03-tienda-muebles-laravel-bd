<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rol>
 */
class RolFactory extends Factory
{
    protected $model = Rol::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Cliente', // Por defecto crea rol Cliente
        ];
    }

    /**
     * Estado: rol de Administrador
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'Administrador',
            ];
        });
    }

    /**
     * Estado: rol de Gestor
     */
    public function gestor()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'Gestor',
            ];
        });
    }

    /**
     * Estado: rol de Cliente
     */
    public function cliente()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'Cliente',
            ];
        });
    }
}
