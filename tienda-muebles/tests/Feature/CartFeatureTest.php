<?php

namespace Tests\Feature;

use App\Models\Carrito;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
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

    public function test_stock_is_reduced_when_order_is_placed()
    {
        $user = User::factory()->create();
        $product = Producto::factory()->create([
            'stock' => 10,
            'precio' => 100,
        ]);

        // Simulate adding to cart in session
        $cart = [
            $product->id => [
                'nombre' => $product->nombre,
                'precio' => $product->precio,
                'cantidad' => 2,
                'imagen' => null,
                'producto_id' => $product->id,
            ]
        ];
        Session::put('carrito', $cart);

        $this->actingAs($user)
            ->post(route('carrito.guardar'));

        // Assert stock is reduced
        $this->assertEquals(8, $product->fresh()->stock);

        // Assert cart is created in DB
        $this->assertDatabaseHas('carritos', [
            'usuario_id' => $user->id,
        ]);

        // Assert session is cleared
        $this->assertEmpty(Session::get('carrito'));
    }

    public function test_cannot_place_order_with_insufficient_stock()
    {
        $user = User::factory()->create();
        $product = Producto::factory()->create([
            'stock' => 1,
            'precio' => 100,
        ]);

        // Simulate adding 2 items to cart (more than stock)
        $cart = [
            $product->id => [
                'nombre' => $product->nombre,
                'precio' => $product->precio,
                'cantidad' => 2,
                'imagen' => null,
                'producto_id' => $product->id,
            ]
        ];
        Session::put('carrito', $cart);

        $response = $this->actingAs($user)
            ->post(route('carrito.guardar'));

        // Assert redirect back with error
        $response->assertSessionHas('error');

        // Assert stock is NOT reduced
        $this->assertEquals(1, $product->fresh()->stock);
    }

    public function test_cookie_preferences_are_saved()
    {
        $response = $this->put(route('preferences.update'), [
            'paginacion' => 24,
            'tema' => 'dark',
            'moneda' => '$',
        ]);

        $response->assertRedirect();
        $response->assertCookie('paginacion', 24);
        $response->assertCookie('tema', 'dark');
        $response->assertCookie('moneda', '$');
    }
}