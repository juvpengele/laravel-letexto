<?php


namespace Letexto\Http\Requests;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Letexto\Exception\GatewayException;

class HttpRequest
{
    const BASE_URI = "";

    protected ?Client $httpClient = null;
    protected array $params = [];
    protected array $queryParams = [];

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

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

    public function filterBy(array $queryParams = [])
    {
        $this->queryParams = $queryParams;
        return $this;
    }

    public function getFormattedQueryParams()
    {
        return http_build_query($this->getQueryParams());
    }

    public function getUri()
    {
        if(empty($this->getFormattedQueryParams())) {
            return self::BASE_URI;
        }

        return self::BASE_URI . "?" .$this->getFormattedQueryParams();
    }


}