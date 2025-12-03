<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->admin()->create();
        $category = Categoria::factory()->create();

        $response = $this->actingAs($admin)->get(route('products.create'));
        $response->assertStatus(200);

        $productData = [
            'nombre' => 'Producto Admin',
            'descripcion' => 'Creado por admin',
            'precio' => 150.00,
            'categoria_id' => $category->id,
            'stock' => 20,
            'materiales' => 'Roble',
            'dimensiones' => '200x200',
            'color_principal' => 'Blanco'
        ];

        $response = $this->actingAs($admin)->post(route('products.store'), $productData);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto Admin']);
    }

    public function test_admin_can_edit_product()
    {
        $admin = User::factory()->admin()->create();
        $product = Producto::factory()->create();
        $category = Categoria::factory()->create();

        $response = $this->actingAs($admin)->get(route('products.edit', $product));
        $response->assertStatus(200);

        $updatedData = [
            'nombre' => 'Producto Editado Admin',
            'descripcion' => 'Editado por admin',
            'precio' => 250.00,
            'categoria_id' => $category->id,
            'stock' => 15,
            'materiales' => 'Pino',
            'dimensiones' => '150x150',
            'color_principal' => 'Negro'
        ];

        $response = $this->actingAs($admin)->put(route('products.update', $product), $updatedData);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto Editado Admin']);
    }

    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->admin()->create();
        $product = Producto::factory()->create();

        $response = $this->actingAs($admin)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseMissing('productos', ['id' => $product->id]);
    }
}
