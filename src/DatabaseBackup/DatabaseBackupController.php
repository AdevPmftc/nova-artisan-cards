<?php

namespace AdevPmftc\NovaArtisanCards\DatabaseBackup;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DatabaseBackupController extends Controller
{
    public function __invoke(): void
    {
        // I want to call the backup:run command here as a background process
        Artisan::queue('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true,
        ]);

        Cache::set('artisan-backup-run-at', now());
    }
}
