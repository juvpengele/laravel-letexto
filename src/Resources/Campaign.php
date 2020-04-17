<?php


namespace Letexto\Resources;


use Letexto\Http\Requests\CampaignHttpRequest;
use Letexto\Http\Requests\HttpRequest;
use Letexto\validators\CampaignValidator;


class Campaign extends BaseResource
{
    protected array $attributes = [
        "sender" => "",
        "campaignType" => "",
        "recipientSource" => "",
        "groupId" => "",
        "destination" => "",
        "responseUrl" => ""
    ];
    private array $recipients = [];
    private string $message = "";
    private ?array $schedules = null;
    private string $name = "";
    private ?string $id = null;

    public function __construct(array $nameAttribute = [])
    {
        $this->name = $nameAttribute["name"] ?? "";
    }

    /**
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($methodName, $arguments)
    {
        $instance = new CampaignHttpRequest;

        if(method_exists($instance, $methodName)) {
            return $instance->$methodName(...$arguments);
        }

        throw new \BadMethodCallException($methodName . " does not exist on the instance");
    }

    public static function create(array $nameAttribute) : Campaign
    {
        if(! isset($nameAttribute['name'])) {
            throw new \InvalidArgumentException('You must provide a name of the campaign');
        }

        return new static($nameAttribute);
    }


    /**
     * @param array $attributes
     * @return Campaign
     */
    public function withAttributes(array $attributes) : Campaign
    {
        $this->attributes = array_merge($this->attributes, $attributes);

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

    /**
     * Send a campaign
     * @return mixed
     * @throws Exception\GatewayException
     */
    public function send()
    {
        $mergedAttributes = array_merge($this->attributes, [
            "message" => $this->message,
            "recipients" => $this->recipients,
            "sendAt" => $this->schedules,
            "name"  => $this->name,
        ]);

        $this->applyValidator($mergedAttributes);

        $campaignHttpRequest = new CampaignHttpRequest();
        return $campaignHttpRequest->addParams($mergedAttributes)->store();
    }

    /**
     * Getter of the attributes attribute
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * Getter of the recipients attribute
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Getter of the schedules attribute
     * @return array|null
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * Getter of the message attribute
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Set the validation of all attributes to be created
     * @param $attributes
     * @return bool
     */
    private function applyValidator($attributes)
    {
        $validator = new CampaignValidator($attributes);
        $validator->handle();

        return true;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param $filters
     * @return Http\Response
     * @throws Exception\GatewayException
     */
    public function getMessages(array $filters = [])
    {
        if(! $this->id) {
            throw new \InvalidArgumentException("Id of the campaign is null");
        }

        $campaignHttpRequest = new CampaignHttpRequest();
        return $campaignHttpRequest->fetchMessages($this->id, $filters);
    }

    protected static function getHttpRequestHandler(): HttpRequest
    {
        return new CampaignHttpRequest();
    }
}