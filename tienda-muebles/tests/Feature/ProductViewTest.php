<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product_page_loads()
    {
        $this->withoutExceptionHandling();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('productos.create');
        $response->assertSee('Nombre'); // Check for some content
    }

    public function test_edit_product_page_loads()
    {
        $admin = User::factory()->admin()->create();
        $product = Producto::factory()->create();

        $response = $this->actingAs($admin)->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertViewIs('productos.edit');
        $response->assertSee($product->nombre);
    }
}
