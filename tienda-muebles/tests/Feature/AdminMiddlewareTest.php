<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_protected_routes()
    {
        $response = $this->get(route('products.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_users_cannot_access_protected_routes()
    {
        $user = User::factory()->cliente()->create();

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Acceso no autorizado. Se requieren permisos de administrador.');
    }

    public function test_admin_users_can_access_protected_routes()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('products.create'));

        $response->assertStatus(200);
    }
}
