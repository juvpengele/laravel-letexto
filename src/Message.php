<?php


namespace Letexto;


use Letexto\Http\Requests\CampaignHttpRequest;
use Letexto\Http\Requests\MessageHttpRequest;

class Message
{
    /**
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($methodName, $arguments)
    {
        $instance = new MessageHttpRequest;

        if(method_exists($instance, $methodName)) {
            return $instance->$methodName(...$arguments);
        }

        throw new \BadMethodCallException($methodName . " does not exist on the instance");
    }
}