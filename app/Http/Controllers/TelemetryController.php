<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelemetryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'event' => 'required|string|max:191',
            'user_id' => 'nullable|integer',
            'crop_size' => 'nullable|integer',
            'current_scale' => 'nullable|numeric',
            'timestamp' => 'nullable|date_format:Y-m-d\TH:i:sP',
            'extra' => 'nullable|array',
        ]);

        // Log telemetry for now; later integrate with analytics or DB
        Log::info('telemetry.event', $data);

        return response()->json(['status' => 'ok']);
    }
}
