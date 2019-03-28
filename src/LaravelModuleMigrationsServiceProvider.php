<?php

namespace Joshbrw\LaravelModuleMigrations;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Joshbrw\LaravelModuleMigrations\Services\ModuleMigrationService;

class LaravelModuleMigrationsServiceProvider extends ServiceProvider
{

    /**
     * Register the Service Provider
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerService();
    }

    /**
     * Register the config
     * @return void
     */
    protected function registerConfig()
    {
        $configPath = __DIR__ . '/../config/module-migrations.php';

        $this->mergeConfigFrom($configPath, 'module-migrations');
        $this->publishes([
            $configPath => config_path('module-migrations.php')
        ]);
    }

    /**
     * Reegister the Schema Building service
     * @return void
     */
    protected function registerService()
    {
        $this->app->singleton(ModuleMigrationService::class, function (Application $app) {
            $config = $app->config['module-migrations'];

            return new ModuleMigrationService(
                array_get($config, 'tables', []),
                $app['db']->connection()->getSchemaBuilder(),
                $app['modules']
            );
        });
    }

}
