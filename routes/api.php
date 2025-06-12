<?php

use AdevPmftc\NovaArtisanCards\DatabaseBackup\DatabaseBackupController;
use AdevPmftc\NovaArtisanCards\MaintenanceMode\MaintenanceModeController;
use AdevPmftc\NovaArtisanCards\MigrateFresh\MigrateFreshController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::post('/artisan/migrate-fresh', MigrateFreshController::class);

Route::post('/artisan/down', [MaintenanceModeController::class, 'down']);

Route::post('/artisan/up', [MaintenanceModeController::class, 'up']);

Route::post('/artisan/database-backup', DatabaseBackupController::class);
