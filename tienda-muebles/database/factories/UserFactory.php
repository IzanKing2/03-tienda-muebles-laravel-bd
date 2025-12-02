<?php

namespace Database\Factories;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtenemos el rol Cliente
        $rolCliente = Rol::where('nombre', 'Cliente')->first();

        // Si no existe, lo creamos
        if (!$rolCliente) {
            $rolCliente = Rol::factory()->cliente()->create();
        }

        return [
            'rol_id' => $rolCliente->id,
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'intentos_fallidos' => 0,
            'bloqueado_hasta' => null,
        ];
    }

    /**
     * Estado: usaurio administrador
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            $rolAdmin = Rol::where('nombre', 'Administrador')->first();

            if (!$rolAdmin) {
                $rolAdmin = Rol::factory()->admin()->create();
            }

            return [
                'rol_id' => $rolAdmin->id,
                'nombre' => 'Admin',
                'apellidos' => 'Sistema',
                'email' => 'admin@tiendamuebles.com',
            ];
        });
    }

    /**
     * Estado: usuario Gestor
     */
    public function gestor()
    {
        return $this->state(function (array $attributes) {
            $rolGestor = Rol::where('nombre', 'Gestor')->first();

            if (!$rolGestor) {
                $rolGestor = Rol::factory()->gestor()->create();
            }

            return [
                'rol_id' => $rolGestor->id,
            ];
        });
    }

    /**
     * Estado: usuario Cliente
     */
    public function cliente()
    {
        return $this->state(function (array $attributes) {
            $rolCliente = Rol::where('nombre', 'Cliente')->first();

            if (!$rolCliente) {
                $rolCliente = Rol::factory()->cliente()->create();
            }

            return [
                'rol_id' => $rolCliente->id,
            ];
        });
    }

    /**
     * Estado: usuario Bloqueado
     */
    public function bloqueado()
    {
        return $this->state(function (array $attributes) {
            return [
                'intentos_fallidos' => 3,
                'bloqueado_hasta' => now()->addMinutes(2),
            ];
        });
    }

    /**
     * Estado: usuario con email específico
     */
    public function conEmail(string $email)
    {
        return $this->state(function (array $attributes) use ($email) {
            return [
                'email' => $email,
            ];
        });
    }

    /**
     * Estado: usuario con contraseña específica
     */
    public function conPassword(string $password)
    {
        return $this->state(function (array $attributes) use ($password) {
            return [
                'password' => $password,
            ];
        });
    }


}
