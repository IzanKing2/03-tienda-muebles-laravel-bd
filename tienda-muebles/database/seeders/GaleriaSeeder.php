<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Producto;
use App\Models\Galeria;
use App\Models\Imagen;

class GaleriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = Producto::all();

        foreach ($productos as $producto) {
            // Crear o recuperar galería vinculada al producto.
            if (method_exists($producto, 'galerias')) {
                $galeria = $producto->galerias()->firstOrCreate(
                    ['nombre' => 'Galería de ' . $producto->nombre],
                    ['nombre' => 'Galería de ' . $producto->nombre]
                );
            } else {
                $galeria = Galeria::firstOrCreate(
                    ['producto_id' => $producto->id],
                    ['nombre' => 'Galería de ' . $producto->nombre]
                );
            }

            // Crear entre 3 y 5 imágenes por galería
            $count = rand(3, 5);
            for ($i = 1; $i <= $count; $i++) {
                $ruta = 'productos/' . $producto->id . '/' . Str::slug($producto->nombre) . "-img{$i}.jpg";

                if (isset($galeria) && method_exists($galeria, 'imagenes')) {
                    $galeria->imagenes()->firstOrCreate(
                        ['ruta' => $ruta],
                        ['ruta' => $ruta, 'orden' => $i]
                    );
                } else {
                    // Si no existe la relación, usar el modelo Imagen directamente
                    Imagen::firstOrCreate(
                        ['galeria_id' => $galeria->id ?? null, 'ruta' => $ruta],
                        ['galeria_id' => $galeria->id ?? null, 'ruta' => $ruta, 'orden' => $i]
                    );
                }
            }
        }
    }
}
