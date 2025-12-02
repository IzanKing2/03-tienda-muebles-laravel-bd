<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Sofá Malmö', 'descripcion' => 'Sofá 3 plazas tapizado en tejido gris.', 'precio' => 499.99, 'stock' => 10, 'categorias' => ['Salón']],
            ['nombre' => 'Silla Oslo', 'descripcion' => 'Silla de diseño escandinavo en madera clara.', 'precio' => 79.90, 'stock' => 30, 'categorias' => ['Comedor', 'Oficina']],
            ['nombre' => 'Mesa Bergen', 'descripcion' => 'Mesa de comedor extensible para 6-8 personas.', 'precio' => 349.00, 'stock' => 5, 'categorias' => ['Comedor']],
            ['nombre' => 'Cama Helsinki', 'descripcion' => 'Cama doble con cabecero tapizado.', 'precio' => 399.50, 'stock' => 7, 'categorias' => ['Dormitorio']],
            ['nombre' => 'Armario Kielder', 'descripcion' => 'Armario modular con puertas correderas.', 'precio' => 599.00, 'stock' => 3, 'categorias' => ['Dormitorio', 'Almacenamiento']],
            ['nombre' => 'Escritorio Reykjavik', 'descripcion' => 'Escritorio compacto con cajonera.', 'precio' => 129.99, 'stock' => 12, 'categorias' => ['Oficina']],
            ['nombre' => 'Cuna Lille', 'descripcion' => 'Cuna ajustable para bebés.', 'precio' => 199.00, 'stock' => 6, 'categorias' => ['Infantil']],
            ['nombre' => 'Tumbona Palermo', 'descripcion' => 'Tumbona para exterior resistente a la intemperie.', 'precio' => 149.90, 'stock' => 8, 'categorias' => ['Exterior']],
            ['nombre' => 'Lámpara Nórdica', 'descripcion' => 'Lámpara de pie con pantalla textil.', 'precio' => 59.50, 'stock' => 20, 'categorias' => ['Iluminación']],
            ['nombre' => 'Estantería Oslo', 'descripcion' => 'Estantería metálica modular.', 'precio' => 89.00, 'stock' => 15, 'categorias' => ['Almacenamiento', 'Oficina']],
            ['nombre' => 'Aparador Lyon', 'descripcion' => 'Aparador bajo para salón/comedor.', 'precio' => 219.00, 'stock' => 4, 'categorias' => ['Salón', 'Comedor']],
            ['nombre' => 'Cómoda Siena', 'descripcion' => 'Cómoda de 4 cajones en madera natural.', 'precio' => 179.00, 'stock' => 9, 'categorias' => ['Dormitorio']],
            ['nombre' => 'Mesa Auxiliar Capri', 'descripcion' => 'Mesa auxiliar redonda para salón.', 'precio' => 39.90, 'stock' => 25, 'categorias' => ['Salón']],
            ['nombre' => 'Sofá Cama Verona', 'descripcion' => 'Sofá convertible en cama individual.', 'precio' => 289.00, 'stock' => 6, 'categorias' => ['Salón', 'Dormitorio']],
            ['nombre' => 'Colchón Comfi', 'descripcion' => 'Colchón viscoelástico 90x190.', 'precio' => 179.99, 'stock' => 14, 'categorias' => ['Dormitorio']],
            ['nombre' => 'Perchero Milano', 'descripcion' => 'Perchero de pie para entrada.', 'precio' => 29.90, 'stock' => 30, 'categorias' => ['Almacenamiento']],
        ];

        foreach ($productos as $p) {
            $producto = Producto::firstOrCreate(
                ['nombre' => $p['nombre']],
                [
                    'descripcion' => $p['descripcion'],
                    'precio' => $p['precio'],
                    'stock' => $p['stock'],
                    'slug' => Str::slug($p['nombre']) . '-' . Str::random(6),
                ]
            );

            // Relacionar con categorías existentes por nombre
            if (!empty($p['categorias'])) {
                $catIds = [];
                foreach ($p['categorias'] as $cnombre) {
                    $cat = Categoria::where('nombre', $cnombre)->first();
                    if ($cat) {
                        $catIds[] = $cat->id;
                    }
                }
                if (!empty($catIds) && method_exists($producto, 'categorias')) {
                    $producto->categorias()->syncWithoutDetaching($catIds);
                } elseif (!empty($catIds)) {
                    // si no existe la relación Eloquent, insertar en pivot directamente
                    foreach ($catIds as $cid) {
                        \DB::table('categoria_producto')->insertOrIgnore([
                            'categoria_id' => $cid,
                            'producto_id' => $producto->id,
                        ]);
                    }
                }
            }
        }
    }
}
