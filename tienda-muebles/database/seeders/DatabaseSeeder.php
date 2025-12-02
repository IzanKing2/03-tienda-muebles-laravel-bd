<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========= ROLES =========
        $this->call(RoleSeeder::class);

        // ========= USUARIOS =========
        $this->call(UserSeeder::class);

        // ========= PRODUCTOS =========
        $this->call(ProductoSeeder::class);

        // ========= CATEGORIAS =========
        $this->call(CategoriaSeeder::class);



        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
