<?php

namespace AdevPmftc\NovaArtisanCards\MaintenanceMode;

use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Card;

class MaintenanceModeCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'is_down_for_maintenance' => app()->isDownForMaintenance(),
            'maintenance_mode_bypass_url' => url('/' . Cache::get('artisan-down-secret')),
            'maintenance_mode_since' => Cache::get('artisan-down-since'),
            'last_up_at' => Cache::get('artisan-up-at'),
        ]);
    }

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-artisan-maintenance-mode-card';
    }
}
