<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_requires_auth()
    {
        $response = $this->get('/perfil');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/perfil');
        $response->assertStatus(200);
        $response->assertSee('Mi perfil');
    }

    public function test_avatar_crop_size_validation_enforced()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'name' => $user->name,
            'email' => $user->email,
            'avatar_crop_size' => 10, // below config min (100)
        ];

        $response = $this->put('/perfil', $payload);
        $response->assertSessionHasErrors('avatar_crop_size');
    }
}
