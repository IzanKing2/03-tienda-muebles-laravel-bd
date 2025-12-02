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
}
