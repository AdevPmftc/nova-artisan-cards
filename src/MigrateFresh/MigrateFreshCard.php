<?php

namespace AdevPmftc\NovaArtisanCards\MigrateFresh;

use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Card;

class MigrateFreshCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     */
    public $width = 'full';

    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'last_migrate_fresh_at' => Cache::get('artisan-migrate-fresh-at'),
        ]);
    }

    /**
     * Get the component name for the element.
     */
    public function component(): string
    {
        return 'nova-artisan-migrate-fresh-card';
    }
}
