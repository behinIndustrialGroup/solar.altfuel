<?php

namespace InspectorCatalog;

use Illuminate\Support\ServiceProvider;

class InspectorCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/inspector-catalog.php', 'inspector-catalog');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/inspector-catalog.php' => config_path('inspector-catalog.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'inspector-catalog');
    }
}
