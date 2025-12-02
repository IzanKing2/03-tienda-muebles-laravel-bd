<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Galeria;
use App\Models\Imagen;
use App\Models\Rol;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Roles si no existen
        if (Rol::count() == 0) {
            Rol::factory()->cliente()->create();
            Rol::factory()->admin()->create();
            Rol::factory()->gestor()->create();
        }

        // 2. Crear Usuarios de prueba
        User::factory()->create([
            'nombre' => 'Cliente Demo',
            'email' => 'cliente@demo.com',
            'password' => bcrypt('password'),
            'rol_id' => Rol::where('nombre', 'Cliente')->first()->id,
        ]);

        User::factory()->create([
            'nombre' => 'Admin Demo',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'rol_id' => Rol::where('nombre', 'Administrador')->first()->id,
        ]);

        // 3. Crear Categorías
        $categorias = Categoria::factory()->count(5)->create();

        // 4. Crear Productos y asignarlos a categorías
        Producto::factory()->count(20)->create()->each(function ($producto) use ($categorias) {
            // Asignar 1 o 2 categorías aleatorias
            $producto->categorias()->attach(
                $categorias->random(rand(1, 2))->pluck('id')->toArray()
            );

            // Crear galería e imágenes
            $galeria = Galeria::factory()->paraProducto($producto)->create();

            // Imagen principal
            Imagen::factory()->paraGaleria($galeria)->principal()->create([
                'ruta' => 'productos/placeholder-' . rand(1, 5) . '.jpg'
            ]);

            // Imágenes adicionales
            Imagen::factory()->count(rand(1, 3))->paraGaleria($galeria)->create([
                'ruta' => 'productos/placeholder-' . rand(1, 5) . '.jpg'
            ]);
        });
    }
}
