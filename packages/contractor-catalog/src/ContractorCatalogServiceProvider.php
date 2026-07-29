<?php

namespace ContractorCatalog;

use Illuminate\Support\ServiceProvider;

class ContractorCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/contractor-catalog.php', 'contractor-catalog');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/contractor-catalog.php' => config_path('contractor-catalog.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'contractor-catalog');
    }
}
