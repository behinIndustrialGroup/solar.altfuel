<?php

namespace BatteryCatalog;

use Illuminate\Support\ServiceProvider;

class BatteryCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/battery-catalog.php', 'battery-catalog');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/battery-catalog.php' => config_path('battery-catalog.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'battery-catalog');
    }
}
