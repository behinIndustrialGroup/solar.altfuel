<?php

namespace SolarPlantEquipment;

use Illuminate\Support\ServiceProvider;

class SolarPlantEquipmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'solar-plant-equipment');
    }
}
