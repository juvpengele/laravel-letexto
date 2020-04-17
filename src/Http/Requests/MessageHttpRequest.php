<?php


namespace Letexto\Http\Requests;


use Letexto\Exception\GatewayException;
use Letexto\Http\Response;

class MessageHttpRequest extends HttpRequest
{
    protected static string $BASE_URI = "messages";

    /**
     * Get the statistics of messages in the platform.
     * @return Response
     * @throws GatewayException
     */
    public function getStatistics()
    {
        $uri = "messages-stats";
        try {
            $response = $this->httpClient->get($uri, $this->params());

            return $this->getResponse($response);
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }
}