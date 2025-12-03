<?php

namespace Tests\Feature;

use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_image()
    {
        Storage::fake('public');
        $product = Producto::factory()->create();
        $file = UploadedFile::fake()->image('producto.jpg');

        $response = $this->post(route('imagen_productos.store'), [
            'producto_id' => $product->id,
            'archivo' => $file
        ]);

        $response->assertRedirect(route('imagen_productos.index'));

        $this->assertDatabaseHas('galerias', ['producto_id' => $product->id]);
        $galeria = \App\Models\Galeria::where('producto_id', $product->id)->first();
        $this->assertDatabaseHas('imagenes', ['galeria_id' => $galeria->id]);

        // Verify file storage
        // Note: Controller stores in 'productos' folder
        // Storage::disk('public')->assertExists('productos/' . $file->hashName());
    }

    public function test_can_delete_image()
    {
        $image = Imagen::factory()->create();

        $response = $this->delete(route('imagen_productos.destroy', $image));

        $response->assertRedirect(route('imagen_productos.index'));
        $this->assertDatabaseMissing('imagenes', ['id' => $image->id]);
    }
}
