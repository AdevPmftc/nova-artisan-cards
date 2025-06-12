<?php

namespace AdevPmftc\NovaArtisanCards\MigrateFresh;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class MigrateFreshController extends Controller
{
    public function __invoke(): void
    {
        Artisan::call('migrate:fresh');

        Artisan::call('cache:clear');

        Cache::set('artisan-migrate-fresh-at', now());

        auth()->logout();
    }
}
