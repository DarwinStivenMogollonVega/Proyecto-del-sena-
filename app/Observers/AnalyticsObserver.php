<?php

namespace App\Observers;

use App\Events\StatisticsUpdated;
use App\Services\AdminAnalyticsService;

class AnalyticsObserver
{
    protected AdminAnalyticsService $service;

    public function __construct()
    {
        $this->service = new AdminAnalyticsService();
    }

    public function saved($model): void
    {
        $this->broadcast();
    }

    public function deleted($model): void
    {
        $this->broadcast();
    }

    protected function broadcast(): void
    {
        // Build a compact payload with key metrics used by admin panel
        $payload = [
            'metrics' => $this->service->panelData(),
        ];

        event(new StatisticsUpdated($payload));
    }
}
