<?php

namespace Letexto;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__."/config/letexto.php", "letexto"
        );
    }

    public function boot()
    {
    }
}