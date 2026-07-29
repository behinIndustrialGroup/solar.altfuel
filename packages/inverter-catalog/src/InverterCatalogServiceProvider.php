<?php

namespace InverterCatalog;

use Illuminate\Support\ServiceProvider;

class InverterCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/inverter-catalog.php', 'inverter-catalog');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/inverter-catalog.php' => config_path('inverter-catalog.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'inverter-catalog');
    }
}
