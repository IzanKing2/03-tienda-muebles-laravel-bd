<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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


//Hay problemas con las migraciones. Al hacer rolers fijos de admins , gestor y cliente, no se crea
// correcctamente y hay que arreglarlo. No lo pide el enunciado, pero si me organizo por el plan hecho
// por Izan , debería de añadirlo.

