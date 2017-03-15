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

    /**
     * Run specific migrations for a module
     * @param string $moduleName
     * @param array $migrations
     * @return bool
     */
    public function runModuleMigrations($moduleName, array $migrations)
    {
        return app(ModuleMigrationService::class)->runModuleMigrations($moduleName, $migrations);
    }

}
