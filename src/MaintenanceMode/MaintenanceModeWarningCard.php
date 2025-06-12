<?php

namespace AdevPmftc\NovaArtisanCards\MaintenanceMode;

use Laravel\Nova\Card;

class MaintenanceModeWarningCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     */
    public $width = 'full';

    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'is_down_for_maintenance' => app()->isDownForMaintenance(),
        ]);
    }

    /**
     * Get the component name for the element.
     */
    public function component(): string
    {
        return 'nova-artisan-maintenance-mode-warning-card';
    }
}
