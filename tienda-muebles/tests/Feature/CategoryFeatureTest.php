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
}
