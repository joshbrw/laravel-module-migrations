# Laravel Module Migrations

Provides a Trait that can be used on migrations with Laravel Modules to ensure that a table from another Module exists. This solves any cross-module table dependency issues.

## Installation
1. Publish the config to `config/module-migrations.php` by running:

    `php artisan vendor:publish --provider="Joshbrw\LaravelModuleMigrations\LaravelModuleMigrationsServiceProvider"`
2. Write your table definitions within this config file. This config file should define the tables that can be created, the module that their migrations exist in and any migrations that should be ran to create this table.
3. In any migrations that require tables created in other modules, `use Joshbrw\LaravelModuleMigrations\Traits\ModuleMigrator`.
4. Use `$this->ensureTableExists('tableName');` wherever you want the tables to be created.  
