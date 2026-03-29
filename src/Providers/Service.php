<?php

namespace GeneaLabs\LaravelTawk\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class Service extends ServiceProvider
{
    protected $bladeCompiler;

    public function boot()
    {
        $resourcePath = realpath(__DIR__ . "/../../resources");

        $this->app->make(BladeCompiler::class)
            ->directive("tawk", function () use ($resourcePath) {
                $template = file_get_contents($resourcePath . "/tawk.php");

                return str_replace('__DIR__', "'" . addslashes($resourcePath) . "'", $template);
            });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../../config/services.php", "services");
    }
}
