<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;

class ContactoViewTest extends TestCase
{
    use TestDbSetup;
    public function test_contacto_view_renders()
    {
        $this->ensureBasicTables();

        $output = view('web.contacto')->render();

        $this->assertStringContainsString('Contacto', $output);
    }
}
