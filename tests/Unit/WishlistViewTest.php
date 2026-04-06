<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;

class WishlistViewTest extends TestCase
{
    use TestDbSetup;
    public function test_wishlist_view_renders()
    {
        $this->ensureBasicTables();

        $output = view('web.wishlist', [])->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
