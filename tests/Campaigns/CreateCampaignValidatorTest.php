<?php


namespace Tests\Campaigns;


use Letexto\validators\CampaignValidator;
use Orchestra\Testbench\TestCase;

class CreateCampaignValidatorTest extends TestCase
{
    /** @test */
    public function a_name_is_required()
    {
        $validator = new CampaignValidator(["name" => "My campaign"]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);

        $validator = new CampaignValidator(["name" => ""]);
        $validator->handle();
    }

    /** @test */
    public function a_campaign_type_must_have_two_values()
    {
        $validator = new CampaignValidator(["campaignType" => "SIMPLE"]);
        $this->assertTrue($validator->handle());

        $validator = new CampaignValidator(["campaignType" => "MAIL"]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);

        $validator = new CampaignValidator(["campaignType" => "LOREM"]);
        $validator->handle();
    }

    /** @test */
    public function a_sender_is_required()
    {
        $validator = new CampaignValidator(["sender" => "MY SENDER"]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);

        $validator = new CampaignValidator(["campaignType" => ""]);
        $validator->handle();
    }

    /** @test */
    public function a_sender_must_not_be_longer_than_eleven_characters()
    {
        $this->expectException(\InvalidArgumentException::class);

        $validator =  new CampaignValidator(["sender" => "I LOVE THE WORLD"]);
        $validator->handle();
    }

    /** @test */
    public function a_recipient_source_is_required()
    {
        $validator = new CampaignValidator(["recipientSource" => "CUSTOM"]);
        $this->assertTrue($validator->handle());

        $validator = new CampaignValidator(["recipientSource" => "GROUP"]);
        $this->assertTrue($validator->handle());

        $validator = new CampaignValidator(["recipientSource" => "FILE"]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["recipientSource" => "LOREM"]);
        $validator->handle();

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["recipientSource" => ""]);
        $validator->handle();
    }

    /** @test */
    public function a_destination_is_required()
    {
        $validator = new CampaignValidator(["destination" => "NAT"]);
        $this->assertTrue($validator->handle());

        $validator = new CampaignValidator(["destination" => "NAT_INTER"]);
        $this->assertTrue($validator->handle());

        $validator = new CampaignValidator(["destination" => "INTER"]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["destination" => "LOREM"]);
        $validator->handle();

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["destination" => ""]);
        $validator->handle();
    }

    /** @test */
    public function a_message_is_required()
    {
        $validator = new CampaignValidator(["message" => "Hello world"]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["message" => ""]);
        $validator->handle();
    }

    /** @test */
    public function recipients_are_required_and_must_be_valid()
    {
        $validator = new CampaignValidator([
            "recipients" => [
                [ 'phone' => '22502558855'],
                [ 'phone' => '22502558856']
            ]
        ]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["recipients" => []]);
        $validator->handle();


        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator([
            "recipients" => [
                ["number" => "225002255"]
            ]
        ]);
        $validator->handle();

    }

    /** @test */
    public function schedules_can_be_set()
    {
        $validator = new CampaignValidator(["schedules" => [
            "2020-02-11 00:00:00"
        ]]);
        $this->assertTrue($validator->handle());


        $validator = new CampaignValidator(["schedules" => null]);
        $this->assertTrue($validator->handle());

        $this->expectException(\InvalidArgumentException::class);
        $validator = new CampaignValidator(["schedules" => "lorem"]);
        $validator->handle();
    }
}