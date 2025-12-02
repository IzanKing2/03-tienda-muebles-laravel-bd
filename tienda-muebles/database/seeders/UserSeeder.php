<?php

namespace Database\Seeders;

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
        // Creamos 1 usuario administrador
        User::factory()->admin()->count(1)->create();
        $this->command->info('✅ Usuario administrador creado');

        // Creamos 2 usuarios gestores
        User::factory()->gestor()->count(2)->create();
        $this->command->info('✅ Usuarios gestores creados');

        // Creamos 10 usuarios clientes
        User::factory()->cliente()->count(10)->create();
        $this->command->info('✅ Usuarios clientes creados');
    }
}
