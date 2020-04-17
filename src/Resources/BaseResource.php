<?php


namespace Letexto\Resources;


use Letexto\Http\Requests\HttpRequest;


abstract class BaseResource
{

    protected array $attributes = [];

    /**
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($methodName, $arguments)
    {
        $instance = static::getHttpRequestHandler();

        if (method_exists($instance, $methodName)) {
            return $instance->$methodName(...$arguments);
        }

        throw new \BadMethodCallException($methodName . " does not exist on the instance");
    }

    protected static abstract function getHttpRequestHandler() : HttpRequest;

    /**
     * Magic getter to facilitate the access of campaign's attributes
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }


    /**
     * Getter of the attributes attribute
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

}