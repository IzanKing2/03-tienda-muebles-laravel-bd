<?php

namespace Tests\Feature;

use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_index_loads()
    {
        Categoria::factory()->count(3)->create();

        $response = $this->get('/categories');

        $response->assertStatus(200);
        $response->assertViewHas('categories');
    }

    public function test_can_create_category()
    {
        $response = $this->post('/categories', [
            'nombre' => 'Nueva Categoría'
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categorias', ['nombre' => 'Nueva Categoría']);
    }

    public function test_can_update_category()
    {
        $category = Categoria::factory()->create();

        $response = $this->put('/categories/' . $category->id, [
            'nombre' => 'Categoría Editada'
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categorias', ['nombre' => 'Categoría Editada']);
    }

    public function test_can_delete_category()
    {
        $category = Categoria::factory()->create();

        $response = $this->delete('/categories/' . $category->id);

        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categorias', ['id' => $category->id]);
    }
}
