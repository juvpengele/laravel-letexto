<?php


namespace Letexto\Http\Requests;

use Letexto\Campaign;
use Letexto\Exception\GatewayException;
use Letexto\Http\Response;


class CampaignHttpRequest extends HttpRequest
{
    protected static string $BASE_URI = "campaigns";


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

            return $this->getResponse($response);
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function find($campaignId) : Campaign
    {
        $response = $this->fetch($campaignId)->toArray();

        $campaign = new Campaign();
        $campaign->withAttributes($response)
                 ->setId($response["id"]);

        return $campaign;
    }


    /**
     * @return string
     * @throws GatewayException
     */
    public function store()
    {
        try {
            $response = $this->httpClient->post(static::$BASE_URI, $this->params());
            $campaign = $this->getResponse($response)->toObject();

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

            return $this->getResponse($response);
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

    /**
     * @param $campaignId
     * @param $filters
     * @return Response
     * @throws GatewayException
     */
    public function fetchMessages(string $campaignId, array $filters = [])
    {
        $this->filterBy($filters);

        $uri = self::$BASE_URI . "/$campaignId/messages?" .$this->getFormattedQueryParams();

        try {
            $response = $this->httpClient->get($uri);
            return $this->getResponse($response);
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }


}