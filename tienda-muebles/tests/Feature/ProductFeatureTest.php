<?php

namespace Tests\Feature;

use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_loads()
    {
        Producto::factory()->count(3)->create();

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('productos');
    }

    public function test_can_create_product()
    {
        $category = \App\Models\Categoria::factory()->create();

        $response = $this->post(route('products.store'), [
            'nombre' => 'Nuevo Producto',
            'descripcion' => 'Descripción del producto',
            'precio' => 100.50,
            'categoria_id' => $category->id,
            'stock' => 10,
            'materiales' => 'Madera',
            'dimensiones' => '100x100',
            'color_principal' => 'Marrón'
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('productos', ['nombre' => 'Nuevo Producto']);
    }

    public function test_can_update_product()
    {
        $product = Producto::factory()->create();
        $category = \App\Models\Categoria::factory()->create();

        $response = $this->put(route('products.update', $product), [
            'nombre' => 'Producto Actualizado',
            'descripcion' => 'Nueva descripción',
            'precio' => 200.00,
            'categoria_id' => $category->id,
            'stock' => 5,
            'materiales' => 'Metal',
            'dimensiones' => '50x50',
            'color_principal' => 'Negro'
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto Actualizado']);
    }

    public function test_can_delete_product()
    {
        $product = Producto::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseMissing('productos', ['id' => $product->id]);
    }
}
