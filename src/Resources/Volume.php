<?php


namespace Letexto;


use Letexto\Http\Requests\HttpRequest;
use Letexto\Http\Requests\VolumeHttpRequest;

class Volume extends BaseResource
{

    protected static function getHttpRequestHandler(): HttpRequest
    {
        return new VolumeHttpRequest;
    }
}