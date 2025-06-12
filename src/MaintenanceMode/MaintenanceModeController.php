<?php

namespace AdevPmftc\NovaArtisanCards\MaintenanceMode;

use AdevPmftc\NovaArtisanCards\MaintenanceMode\Requests\MaintenanceModeDownRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class MaintenanceModeController extends Controller
{
    public function down(MaintenanceModeDownRequest $maintenanceModeDownRequest): void
    {
        $secret = $maintenanceModeDownRequest->get('secret');

        // Save the secret to the cache for retrieval later
        Cache::set('artisan-down-secret', $secret);

        // Used to track when it was last down
        Cache::set('artisan-down-since', now());

        Artisan::call('down', ['--secret' => $secret, '--refresh' => 15]);
    }

    public function up(): void
    {
        // Used to track when it was last up
        Cache::set('artisan-up-at', now());

        Artisan::call('up');
    }
}
