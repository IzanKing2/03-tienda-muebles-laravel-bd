<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Rol::where('nombre', 'Administrador')->first()->id;

        // Creo 1 usuario administrador para pruebas
        $user = User::create([
            "nombre" => "Admin",
            "apellidos" => "Administrador",
            "email" => "admin@admin.com",
            "password" => Hash::make("1234"),
            "rol_id" => $role_admin,
        ]);
        $this->command->info('✅ Usuario administrador creado');

        // Creamos 2 usuarios gestores
        User::factory()->gestor()->count(2)->create();
        $this->command->info('✅ Usuarios gestores creados');

        // Creamos 10 usuarios clientes
        User::factory()->cliente()->count(10)->create();
        $this->command->info('✅ Usuarios clientes creados');

        $role_cliente = Rol::where('nombre', 'Cliente')->first()->id;
        // Creo 1 usuario cliente para pruebas
        $user = User::create([
            "nombre" => "Cliente",
            "apellidos" => "Cliente",
            "email" => "cliente@cliente.com",
            "password" => Hash::make("1234"),
            "rol_id" => $role_cliente,
        ]);
        $this->command->info('✅ Usuario cliente creado');
    }
}
