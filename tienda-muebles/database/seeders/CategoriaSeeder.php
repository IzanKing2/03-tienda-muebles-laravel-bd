<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generamos 10 categorías
        Categoria::factory()->count(10)->create();
        $this->command->info('✅ Categorias creadas');
    }
}
