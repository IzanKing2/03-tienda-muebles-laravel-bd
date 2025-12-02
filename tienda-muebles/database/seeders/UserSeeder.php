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
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@tienda.com'],
            ['name' => 'Administrador', 'password' => Hash::make('admin123')]
        );
        $admin->assignRole('Admin');

        // 2 Gestores
        for ($i = 1; $i <= 2; $i++) {
            $email = "gestor{$i}@tienda.com";
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => "Gestor {$i}", 'password' => Hash::make('gestor123')]
            );
            $user->assignRole('Gestor');
        }

        // 8 Clientes (Siendo un total de 11)
        for ($i = 1; $i <= 8; $i++) {
            $email = "cliente{$i}@tienda.com";
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => "Cliente {$i}", 'password' => Hash::make('cliente123')]
            );
            $user->assignRole('Cliente');
        }
    }
}
