<?php


namespace Letexto\validators;


use Illuminate\Support\Str;

class Validator
{
    protected array $attributes = [];

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function handle()
    {
        foreach ($this->attributes as $key => $attribute) {

            $method = $this->getValidationMethodName($key);

            if(! method_exists($this, $method)) {
                throw new \BadMethodCallException("Please you must provide " . $method . " method");
            }

            if(! $this->$method($attribute)) {
                throw new \InvalidArgumentException("Please provide a value for " . $key);
            }
        }

        return true;
    }

    private function getValidationMethodName($key)
    {
        return "validate" . ucfirst(Str::camel($key));
    }

}