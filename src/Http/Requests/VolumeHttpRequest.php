<?php


namespace Letexto\Http\Requests;


use Letexto\Http\Response;

class VolumeHttpRequest extends HttpRequest
{
    protected static string $BASE_URI = "user-volume";

    public function retrieve()
    {
        $uri = $this->getUri();

        try {
            $response = $this->httpClient->get($uri, $this->defaultParams());

            return $this->getResponse($response);
        } catch(\Exception $exception) {
            $this->handleException($exception);
        }
    }
}