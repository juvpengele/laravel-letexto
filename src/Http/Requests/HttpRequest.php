<?php


namespace Letexto\Http\Requests;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Letexto\Exception\GatewayException;
use Letexto\Http\Response;

class HttpRequest
{
    protected static string $BASE_URI = "";

    protected ?Client $httpClient = null;
    protected array $params = [];
    protected array $queryParams = [];



    public function __construct()
    {
        $this->httpClient = new Client(["base_uri" => config("letexto.api_url")]);
    }

    /**
     * Getter of the HTTP Client.
     * @return Client|null
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Getter of the query params attribute
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Set up of the default parameters to be sent
     * @return array
     */
    public function defaultParams() : array
    {
        return [
            'headers' => [
                'Authorization' => "Bearer ". config("letexto.token"),
                'Content-Type'  => 'application/json'
            ]
        ];
    }

    /**
     * Setter of the params attribute
     * @param array $params
     * @return $this
     */
    public function addParams(array $params = [])
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Getter of the params attribute
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Set the body of the response in a correct format.
     * @param $response
     * @return Response
     */
    protected function decodeResponse($response) : Response
    {
        $content = (string) $response->getBody();
        return new Response($content);
    }

    protected function additionalParams() : array
    {
        return [];
    }

    public function params()
    {
        return array_merge($this->defaultParams(), $this->additionalParams());
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

        if(empty($this->queryParams)) {
            return static::$BASE_URI;
        }

        return static::$BASE_URI . "?" .$this->getFormattedQueryParams();
    }

}