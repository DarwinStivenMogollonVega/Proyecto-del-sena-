<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class MisPedidosTest extends TestCase
{
    use RefreshDatabase;

    public function test_mis_pedidos_requires_auth()
    {
        $response = $this->get('/perfil/pedidos');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_mis_pedidos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/perfil/pedidos');
        $response->assertStatus(200);
        $response->assertSee('Mis pedidos');
    }
}
