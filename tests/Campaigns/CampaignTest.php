<?php


namespace Tests\Campaigns;


use Letexto\Campaign;
use Orchestra\Testbench\TestCase;

class CampaignTest extends TestCase
{
    /** @test */
    public function we_can_retrieve_campaigns_attributes()
    {
        $campaign = new Campaign();
        $campaign->withAttributes(["sender" => "Juvenal"]);

        $this->assertEquals("Juvenal", $campaign->sender);
    }
}