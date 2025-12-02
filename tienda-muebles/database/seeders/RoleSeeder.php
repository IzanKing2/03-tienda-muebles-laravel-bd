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
        Rol::firstOrCreate(['nombre' => 'Admin']);
        Rol::firstOrCreate(['nombre' => 'Gestor']);
        Rol::firstOrCreate(['nombre' => 'Cliente']);
    }
}

