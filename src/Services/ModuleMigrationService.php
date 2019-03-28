<?php

namespace Joshbrw\LaravelModuleMigrations\Services;

use Illuminate\Database\Schema\Builder;
use Joshbrw\LaravelModuleMigrations\Exceptions\UnknownTableException;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Migrations\Migrator;

class ModuleMigrationService
{

    /**
     * @var array
     */
    private $tableConfig;
    /**
     * @var Builder
     */
    private $schemaBuilder;
    /**
     * @var RepositoryInterface
     */
    private $moduleRepository;

    public function __construct(
        array $tableConfig,
        Builder $schemaBuilder,
        RepositoryInterface $moduleRepository
    ) {
        $this->tableConfig = $tableConfig;
        $this->schemaBuilder = $schemaBuilder;
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Ensure a Table exists
     * @param string $tableName
     * @return bool
     * @throws UnknownTableException
     */
    public function ensureTableExists($tableName)
    {
        if ($this->tableAlreadyExists($tableName)) {
            return true;
        }

        if ($this->knowsHowToBuild($tableName) === false) {
            throw new UnknownTableException("We do not know how to build table '{$tableName}`.");
        }

        /* Collect data from the definition */
        $definition = array_get($this->tableConfig, $tableName, []);
        $moduleName = array_get($definition, 'module');
        $migrations = array_get($definition, 'migrations', []);

        return $this->runModuleMigrations($moduleName, $migrations);
    }

    /**
     * Does the table already exist?
     * @param string $tableName
     * @return bool
     */
    protected function tableAlreadyExists($tableName)
    {
        return $this->schemaBuilder->hasTable($tableName);
    }

    /**
     * Do we know how to build a specific Table?
     * @param string $tableName
     * @return bool
     */
    protected function knowsHowToBuild($tableName)
    {
        if (!array_has($this->tableConfig, $tableName)) {
            return false;
        }

        return array_has($this->tableConfig, ["{$tableName}.module", "{$tableName}.migrations"]);
    }

    /**
     * Run the Migrations for a Module
     * @param string $moduleName
     * @param array $migrations
     * @return bool
     * @throws UnknownTableException
     */
    public function runModuleMigrations($moduleName, array $migrations = [])
    {
        if (!$module = $this->moduleRepository->find($moduleName)) {
            throw new UnknownTableException("Module {$moduleName} does not exist.");
        }

        $migrator = new Migrator($module);
        $migrator->requireFiles($migrations);

        foreach ($migrations as $migration) {
            $migrator->up($migration);
            $migrator->log($migration);
        }

        return true;
    }
}
