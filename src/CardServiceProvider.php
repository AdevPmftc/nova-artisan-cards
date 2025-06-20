<?php

namespace AdevPmftc\NovaArtisanCards;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-artisan-cards', __DIR__.'/../dist/js/card.js');
            Nova::style('nova-artisan-cards', __DIR__.'/../dist/css/card.css');
        });
    }

    /**
     * Register the card's routes.
     */
    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/nova-artisan-cards')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
