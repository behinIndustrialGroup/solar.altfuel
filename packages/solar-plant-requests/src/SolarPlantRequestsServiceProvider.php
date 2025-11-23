<?php

namespace SolarPlantRequests;

use Illuminate\Support\ServiceProvider;

class SolarPlantRequestsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/solar-plant-requests.php', 'solar-plant-requests');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/solar-plant-requests.php' => config_path('solar-plant-requests.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
