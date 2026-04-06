<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminActivityLogger;

class AdminActivityLoggerTest extends TestCase
{
    public function test_should_log_for_admin_path()
    {
        $req = Request::create('/admin/users', 'GET');
        $req->setRouteResolver(fn () => null);

        $mw = new AdminActivityLogger();

        $ref = new \ReflectionClass($mw);
        $method = $ref->getMethod('shouldLog');
        $method->setAccessible(true);

        $result = $method->invoke($mw, $req, '');
        $this->assertTrue($result);
    }

    public function test_should_not_log_for_unrelated_route()
    {
        $req = Request::create('/public/page', 'GET');
        $req->setRouteResolver(fn () => (object) ['getName' => fn () => '']);

        $mw = new AdminActivityLogger();

        $ref = new \ReflectionClass($mw);
        $method = $ref->getMethod('shouldLog');
        $method->setAccessible(true);

        $result = $method->invoke($mw, $req, '');
        $this->assertFalse($result);
    }
}
