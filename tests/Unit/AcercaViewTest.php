<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\ViewErrorBag;

class AcercaViewTest extends TestCase
{
    public function test_acerca_view_renders()
    {
        view()->share('errors', new ViewErrorBag());
        $output = view('web.acerca', [])->render();
        $this->assertStringContainsString('Acerca de DiscZone', $output);
    }
}
