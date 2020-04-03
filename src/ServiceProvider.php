<?php

namespace Letexto;

use Illuminate\Support\ServiceProvider;

class ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__."/config/letexto.php", "letexto"
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__."/config/letexto.php" => config_path('letexto.php'),
        ]);
    }
}