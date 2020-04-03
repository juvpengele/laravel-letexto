<?php


namespace Letexto\Http\Requests;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Letexto\Exception\GatewayException;

class HttpRequest
{
    protected ?Client $httpClient = null;
    protected array $params = [];

    public function __construct()
    {
        $this->httpClient = new Client(["base_uri" => config("letexto.api_url")]);
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function defaultParams() : array
    {
        return [
            'headers' => [
                'Authorization' => "Bearer ". config("letexto.token"),
                'Content-Type'  => 'application/json'
            ]
        ];
    }

    public function addParams(array $params = [])
    {
        $this->params = $params;
        return $this;
    }

    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Set the body of the response in a correct format.
     * @param $response
     * @return string
     */
    protected function decodeResponse($response)
    {
        return (string) $response->getBody();
    }

    protected function additionalParams() : array
    {
        return [];
    }

    public function params()
    {
        return array_merge($this->params, $this->additionalParams());
    }

    /**
     * @param \Exception $exception
     * @throws GatewayException
     */
    protected function handleException(\Exception $exception)
    {
        $message = $exception->getMessage();

        Log::error($message);
        throw new GatewayException($exception);
    }
}