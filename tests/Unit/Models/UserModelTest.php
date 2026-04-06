<?php
namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;

class UserModelTest extends TestCase
{
    public function test_fillable_and_casts()
    {
        $user = new User();
        $this->assertContains('email', $user->getFillable());
        $this->assertArrayHasKey('fecha_nacimiento', $user->getCasts());
    }

    public function test_relations_return_relations()
    {
        $user = new User();
        // `entradas` model may not exist in minimal test setup; check core relations used by app
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $user->pedidos());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $user->facturas());
    }
}
