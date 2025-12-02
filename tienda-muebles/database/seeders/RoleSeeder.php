<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Gestor']);
        Role::firstOrCreate(['name' => 'Cliente']);
    }
}


//Hay problemas con las migraciones. Al hacer rolers fijos de admins , gestor y cliente, no se crea
// correcctamente y hay que arreglarlo. No lo pide el enunciado, pero si me organizo por el plan hecho
// por Izan , debería de añadirlo.

