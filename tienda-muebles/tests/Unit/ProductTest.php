<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Galeria;
use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_many_categories()
    {
        $product = Producto::factory()->create();
        $category = Categoria::factory()->create();

        $product->categorias()->attach($category);

        $this->assertTrue($product->categorias->contains($category));
    }

    public function test_product_has_one_galeria()
    {
        $product = Producto::factory()->create();
        $galeria = Galeria::factory()->create(['producto_id' => $product->id]);

        $this->assertInstanceOf(Galeria::class, $product->galeria);
        $this->assertEquals($galeria->id, $product->galeria->id);
    }
}
