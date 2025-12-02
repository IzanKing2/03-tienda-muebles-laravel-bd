<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existen roles para no duplicar
        if (Rol::count() > 0) {
            $this->command->info('Los roles ya existen, saltando...');
            return;
        }

        // Crear los 3 roles fijos
        Rol::create(['nombre' => 'Administrador']);
        Rol::create(['nombre' => 'Gestor']);
        Rol::create(['nombre' => 'Cliente']);

        $this->command->info('✅ Roles creados: Administrador, Gestor, Cliente');
    }
}

