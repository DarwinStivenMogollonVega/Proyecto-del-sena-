<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Http\Controllers\TelemetryController;
use Illuminate\Http\Request;

class TelemetryControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_store_validates_and_logs()
    {
        $data = ['event' => 'click', 'user_id' => 1];

        $req = Mockery::mock(Request::class);
        $req->shouldReceive('validate')->once()->andReturn($data);

        // Use Log facade mock via container
        \Illuminate\Support\Facades\Log::shouldReceive('info')->once()->with('telemetry.event', $data);

        $ctrl = new TelemetryController();
        $resp = $ctrl->store($req);

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertEquals(['status' => 'ok'], $resp->getData(true));
    }
}
