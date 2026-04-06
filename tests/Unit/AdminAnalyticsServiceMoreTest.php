<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;

class AdminAnalyticsServiceMoreTest extends TestCase
{
 
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_categoryData_calls_ventasData()
    {
        $svc = Mockery::mock(\App\Services\AdminAnalyticsService::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $svc->shouldReceive('ventasData')->once()->andReturn(['ventas' => 'ok']);

        $res = $svc->categoryData('ventas');

        $this->assertSame(['ventas' => 'ok'], $res);
    }

    public function test_categoryData_cat_calls_categoriaEspecificaData()
    {
        $svc = Mockery::mock(\App\Services\AdminAnalyticsService::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $svc->shouldReceive('categoriaEspecificaData')->once()->with(123)->andReturn(['id' => 123]);

        $res = $svc->categoryData('cat-123');

        $this->assertSame(['id' => 123], $res);
    }

    public function test_panelModuleRow_returns_expected_structure()
    {
        $svc = new \App\Services\AdminAnalyticsService();

        // create a fake query object with count and max
        $query = new class {
            public function count() { return 5; }
            public function max($col) { return '2026-01-01 00:00:00'; }
        };

        $ref = new \ReflectionClass($svc);
        $method = $ref->getMethod('panelModuleRow');
        $method->setAccessible(true);

        $res = $method->invoke($svc, 'TestModule', $query);

        $this->assertIsArray($res);
        $this->assertEquals('TestModule', $res['modulo']);
        $this->assertEquals(5, $res['registros']);
        $this->assertEquals('Con datos', $res['estado']);
    }
}
