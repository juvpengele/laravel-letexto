<?php


namespace Tests\Campaigns;


use Letexto\Campaign;
use Orchestra\Testbench\TestCase;

class CreateCampaignTest extends TestCase
{
    /** @test */
    public function a_campaign_can_be_created()
    {
        $campaign = Campaign::create([
            'name' => 'My first campaign'
        ]);

        $this->assertInstanceOf(Campaign::class, $campaign);
    }

    /** @test */
    public function a_campaign_requires_a_name_to_be_initialized()
    {
        $this->expectException(\InvalidArgumentException::class);

        Campaign::create(['lorem'=> 'ipsum']);
    }

    /** @test */
    public function a_campaign_can_add_attributes()
    {
        $campaign = Campaign::create([
                'name' => 'my first campaign'
            ])->withAttributes([
                'sender' => 'My sender',
                'type' => 'SIMPLE',
                'recipientSource' => 'CUSTOM',
                'destination' => 'NAT'
            ]);

        $this->assertContains("sender", array_keys($campaign->getAttributes()));
        $this->assertContains("type", array_keys($campaign->getAttributes()));
    }

    /** @test */
    public function we_can_add_recipients_to_a_campaign()
    {
        $campaign = Campaign::create([
            'name' => 'My new campaign'
        ])->to([
            ["phone" => "22503558855"],
            ["phone" => "22503558855"],
        ]);

        $this->assertCount(2, $campaign->getRecipients());
    }

    /** @test */
    public function a_campaign_can_be_scheduled()
    {
        $campaign = Campaign::create([
            'name' => 'My new campaign'
        ])->at(["2020-02-10 23:55:00", "2020-03-11 00:00:00"]);

        $this->assertCount(2, $campaign->getSchedules());
    }

    /** @test */
    public function a_campaign_has_a_message()
    {
        $campaign = Campaign::create(['name' => 'my campaign'])->withMessage("Hello world");

        $this->assertEquals("Hello world", $campaign->getMessage());
    }
}

