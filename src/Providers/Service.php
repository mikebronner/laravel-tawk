<?php

namespace GeneaLabs\LaravelTawk\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class Service extends ServiceProvider
{
    protected $bladeCompiler;

    public function boot()
    {
        $this->app->make(BladeCompiler::class)
            ->directive("tawk", function () {
                return file_get_contents(__DIR__ . "/../../resources/tawk.php");
            });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../../config/services.php", "services");
    }
}
