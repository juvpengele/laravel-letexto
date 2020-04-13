<?php


namespace Letexto\Http\Requests;


use Letexto\Http\Response;

class VolumeHttpRequest extends HttpRequest
{
    protected static string $BASE_URI = "user-volume";

    public function fetch()
    {
        $uri = $this->getUri();

        try {
            $response = $this->httpClient->get($uri);

            return new Response($response);
        } catch(\Exception $exception) {
            $this->handleException($exception);
        }
    }
}