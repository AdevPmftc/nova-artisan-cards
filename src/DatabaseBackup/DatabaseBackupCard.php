<?php

namespace AdevPmftc\NovaArtisanCards\DatabaseBackup;

use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Card;

class DatabaseBackupCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     */
    public $width = 'full';

    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'backup_disks' => implode(', ', config('backup.backup.destination.disks')),
            'last_database_backup_at' => Cache::get('artisan-backup-run-at'),
        ]);
    }

    /**
     * Get the component name for the element.
     */
    public function component(): string
    {
        return 'nova-artisan-database-backup-card';
    }
}
