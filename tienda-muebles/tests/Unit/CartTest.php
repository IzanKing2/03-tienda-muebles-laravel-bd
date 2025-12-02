<?php

namespace Tests\Unit;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_belongs_to_user()
    {
        $user = User::factory()->create();
        $cart = Carrito::factory()->create(['usuario_id' => $user->id]);

        $this->assertInstanceOf(User::class, $cart->usuario);
        $this->assertEquals($user->id, $cart->usuario->id);
    }

    public function test_cart_has_many_items()
    {
        $cart = Carrito::factory()->create();
        $item = CarritoItem::factory()->create(['carrito_id' => $cart->id]);

        $this->assertTrue($cart->items->contains($item));
        $this->assertInstanceOf(CarritoItem::class, $cart->items->first());
    }
}
