<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Producto;
use App\Models\Carrito;

class CarritoSeeder extends Seeder
{
    public function run(): void
    {
        // Tomar 2-3 usuarios aleatorios (si hay menos, usará los existentes)
        $users = User::inRandomOrder()->take(3)->get();

        if ($users->isEmpty()) {
            $this->command->info('No hay usuarios para asignar carritos.');
            return;
        }

        // Determinar clave foránea en la tabla carritos
        $fkUser = Schema::hasColumn('carritos', 'user_id') ? 'user_id' :
                  (Schema::hasColumn('carritos', 'usuario_id') ? 'usuario_id' : null);

        foreach ($users as $user) {
            // Crear carrito: insert directo para evitar problemas con fillable
            $carritoData = [];
            if ($fkUser) $carritoData[$fkUser] = $user->id;
            $carritoData['created_at'] = now();
            $carritoData['updated_at'] = now();

            $carritoId = DB::table('carritos')->insertGetId($carritoData);

            // Intentar obtener el modelo Eloquent del carrito
            $carritoModel = Carrito::find($carritoId);

            // Seleccionar 1-4 productos aleatorios para este carrito
            $productos = Producto::inRandomOrder()->take(rand(1, 4))->get();
            foreach ($productos as $prod) {
                $cantidad = rand(1, 3);
                // intentar obtener precio del producto (ajusta si usas otro campo)
                $precio = $prod->precio ?? $prod->price ?? 0;

                // Si el modelo Carrito dispone de la relación items(), usarla
                if ($carritoModel && method_exists($carritoModel, 'items')) {
                    $carritoModel->items()->create([
                        'producto_id' => $prod->id,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                    ]);
                } else {
                    // Insert directo en la tabla carrito_items (nombres comunes)
                    $item = [
                        'carrito_id' => $carritoId,
                        'producto_id' => $prod->id,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Asegurar columnas existentes antes de insertar para evitar errores
                    $cols = Schema::getColumnListing('carrito_items');
                    $insert = array_intersect_key($item, array_flip($cols));

                    DB::table('carrito_items')->insert($insert);
                }
            }
        }

        $this->command->info('Carritos de prueba creados.');
    }
}
