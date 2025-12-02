<?php

namespace Tests\Unit;

use App\Models\Carrito;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_belongs_to_role()
    {
        $role = Rol::factory()->create();
        $user = User::factory()->create(['rol_id' => $role->id]);

        $this->assertInstanceOf(Rol::class, $user->rol);
        $this->assertEquals($role->id, $user->rol->id);
    }

    public function test_user_has_many_carritos()
    {
        $user = User::factory()->create();
        $carrito = Carrito::factory()->create(['usuario_id' => $user->id]);

        $this->assertTrue($user->carritos->contains($carrito));
        $this->assertInstanceOf(Carrito::class, $user->carritos->first());
    }
}
