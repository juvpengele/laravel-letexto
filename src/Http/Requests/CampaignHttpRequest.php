<?php


namespace Letexto\Http\Requests;

use Letexto\Exception\GatewayException;

class CampaignHttpRequest extends HttpRequest
{
    /**
     * @return string
     * @throws GatewayException
     */
    public function store()
    {
        try {
            $response = $this->httpClient->post("/campaigns", $this->params());
            $campaign = json_decode($this->decodeResponse($response));

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
            $response = $this->httpClient->post( '/campaigns/' . $campaign->id . '/schedules');

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