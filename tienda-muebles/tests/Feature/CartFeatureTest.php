<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_loads_for_guest()
    {
        $response = $this->get('/carrito');
        $response->assertStatus(200);
    }

    public function test_cart_page_loads_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/carrito');
        $response->assertStatus(200);
    }
}
