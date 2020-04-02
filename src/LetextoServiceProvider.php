<?php

namespace Letexto;

use Illuminate\Support\ServiceProvider;

class LetextoServiceProvider extends ServiceProvider
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