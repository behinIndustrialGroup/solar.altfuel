<?php

namespace Behin\SimpleWorkflow;

use Illuminate\Support\ServiceProvider;

class SimpleWorkflowProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        require_once __DIR__ . '/Helper/behin-simple-workflow.php';
        $this->loadMigrationsFrom(__DIR__. '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__. '/Views', 'SimpleWorkflowView');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'SimpleWorkflowLang');
    }
}
