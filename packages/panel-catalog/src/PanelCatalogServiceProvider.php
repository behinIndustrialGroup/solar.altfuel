<?php

namespace PanelCatalog;

use Illuminate\Support\ServiceProvider;

class PanelCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/panel-catalog.php', 'panel-catalog');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/panel-catalog.php' => config_path('panel-catalog.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'panel-catalog');
    }
}
