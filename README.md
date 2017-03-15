# Laravel Module Migrations

Provides a Trait that can be used on migrations with Laravel Modules to ensure that a table from another Module exists. This solves any cross-module table dependency issues.

## Installation
1. `php artisan vendor:publish --provider="Joshbrw\LaravelModuleMigrations\LaravelModuleMigrationsServiceProvider"`
2. Write your table definitions 
