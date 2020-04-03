<?php


namespace Letexto\Http\Requests;

use Letexto\Exception\GatewayException;


class CampaignHttpRequest extends HttpRequest
{
    protected static string $BASE_URI = "campaigns";

    /**
     * @return string
     * @throws GatewayException
     */
    public function fetchAll()
    {
        try {
            $response = $this->httpClient->get($this->getUri(), $this->params());

            return $this->decodeResponse($response);
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @param $campaignId
     * @return string
     * @throws GatewayException
     */
    public function fetch($campaignId)
    {
        $uri = static::$BASE_URI . "/$campaignId";
        try {
            $response = $this->httpClient->get($uri, $this->params());

            return $this->decodeResponse($response);
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }


    /**
     * @return string
     * @throws GatewayException
     */
    public function store()
    {
        try {
            $response = $this->httpClient->post(static::$BASE_URI, $this->params());
            $campaign = $this->decodeResponse($response)->toObject();

            return $this->schedule($campaign);

        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @param $campaign
     * @return string
     * @throws GatewayException
     */
    protected function schedule($campaign)
    {
        try {
            $response = $this->httpClient->post( static::$BASE_URI. "/$campaign->id/schedules");

            return $this->decodeResponse($response);
        }  catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @return array
     */
    protected function additionalParams() : array
    {
        return [
            'json' => $this->params
        ];
    }
}