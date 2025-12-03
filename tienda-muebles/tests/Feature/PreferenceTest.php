<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PreferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_preferences()
    {
        $response = $this->get(route('preferences'));
        $response->assertStatus(200);
        $response->assertViewIs('preferences.index');
    }

    public function test_guest_can_update_preferences()
    {
        $data = [
            'tema' => 'dark',
            'moneda' => '$',
            'paginacion' => 24,
        ];

        $response = $this->put(route('preferences.update'), $data);

        $response->assertRedirect(route('preferences'));
        $response->assertCookie('tema', 'dark');
        $response->assertCookie('moneda', '$');
        $response->assertCookie('paginacion', 24);
    }

    public function test_auth_user_can_view_preferences()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('preferences'));
        $response->assertStatus(200);
        $response->assertViewIs('preferences.index');
    }

    public function test_auth_user_can_update_preferences()
    {
        $user = User::factory()->create();
        $data = [
            'tema' => 'dark',
            'moneda' => '$',
            'paginacion' => 24,
        ];

        $response = $this->actingAs($user)->put(route('preferences.update'), $data);

        $response->assertRedirect(route('preferences'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'tema' => 'dark',
            'moneda' => '$',
            'paginacion' => 24,
        ]);
    }
}
