<?php


namespace Letexto\Resources;


use Letexto\Http\Requests\HttpRequest;
use Letexto\Http\Requests\MessageHttpRequest;

class Message extends BaseResource
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


    protected static function getHttpRequestHandler(): HttpRequest
    {
       return new MessageHttpRequest();
    }
}