<?php


namespace Tests\Campaigns;


use GuzzleHttp\Client;
use Letexto\Http\Requests\CampaignHttpRequest;
use Orchestra\Testbench\TestCase;

class CampaignHttpRequestTest extends TestCase
{
    /** @test */
    public function a_campaign_request_can_have_a_client()
    {
        $campaignHttpRequest = new CampaignHttpRequest();

        $this->assertInstanceOf(Client::class, $campaignHttpRequest->getHttpClient());
    }

    /** @test */
    public function params_can_be_added_to_a_campaign_http()
    {
        $campaignHttpRequest = new CampaignHttpRequest();
        $campaignHttpRequest->addParams([
            'name' => 'lorem',
            'recipients' => [
                ['phone' => '225088522255']
            ]
        ]);

        $this->assertNotEmpty($campaignHttpRequest->getParams());
    }

    /**
     * @test
     */
    public function query_params_can_be_added()
    {
        $campaignHttpRequest = new CampaignHttpRequest;
        $campaignHttpRequest->filterBy(['status' => 'sent', 'from' => '2020-02-11 00:00:00']);

        $this->assertNotEmpty($campaignHttpRequest->getQueryParams());
        $this->assertCount(2, $campaignHttpRequest->getQueryParams());
    }

}