<?php

namespace Joshbrw\LaravelModuleMigrations\Traits;

use Joshbrw\LaravelModuleMigrations\Services\ModuleMigrationService;

trait ModuleMigrator
{

    /**
     * Ensure a Database Table exists.
     * @param string $tableName
     * @return bool
     */
    public function ensureTableExists($tableName)
    {
        return app(ModuleMigrationService::class)->ensureTableExists($tableName);
    }

}
