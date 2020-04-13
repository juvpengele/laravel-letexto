<?php


namespace Letexto;


use Letexto\Http\Requests\VolumeHttpRequest;

class Volume
{
    public static function __callStatic($name, $arguments)
    {
        $instance = new static;

        if(! method_exists($instance, $name)) {
            throw new \BadMethodCallException("{$name} does not exist on the class");
        }

        return $instance->$name();
    }

    public static function fetch()
    {
        $volumeHttpRequest = new VolumeHttpRequest;

        return $volumeHttpRequest->fetch();
    }
}