<?php


namespace Letexto;


use Letexto\validators\CampaignValidator;

final class Campaign
{

    private array $attributes = [
        "sender" => "",
        "campaignType" => "",
        "recipientSource" => "",
        "groupId" => "",
        "destination" => ""
    ];
    private array $recipients = [];
    private string $message = "";
    private ?array $schedules = null;

    public function __construct(array $nameAttribute)
    {
        if(! isset($nameAttribute['name'])) {
            throw new \InvalidArgumentException('You must provide a name of the campaign');
        }

        $this->attributes["name"] = $nameAttribute["name"];
    }

    public static function create(array $nameAttribute) : Campaign
    {
        return new static($nameAttribute);
    }

    /**
     * @param array $attributes
     * @return Campaign
     */
    public function withAttributes(array $attributes) : Campaign
    {
        $this->attributes = array_merge($attributes, $this->attributes);

        return $this;
    }

    public function to(array $recipients) : Campaign
    {
        $this->recipients = $recipients;
        return $this;
    }

    public function at(array $schedules) : Campaign
    {
        $this->schedules = $schedules;
        return $this;
    }

    public function withMessage(string $message) : Campaign
    {
        $this->message = $message;
        return $this;
    }

    public function send()
    {
        $this->applyValidator();
    }

    /**
     *
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getSchedules()
    {
        return $this->schedules;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    private function applyValidator()
    {
        $allAttributes = array_merge($this->attributes, [
            "message" => $this->message,
            "recipients" => $this->recipients,
            "sendAt" => $this->schedules
        ]);

        $validator = new CampaignValidator($allAttributes);
        $validator->handle();
    }

}