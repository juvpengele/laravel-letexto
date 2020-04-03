<?php


namespace Letexto\validators;


class CampaignValidator extends Validator
{
    protected function validateName($value)
    {
        return !! $value;
    }

    protected function validateCampaignType($value)
    {
        return $value === "SIMPLE" || $value === "MAIL";
    }

    protected function validateSender($value)
    {
        return !! $value && strlen($value) <= 11;
    }

    protected function validateRecipientSource($value)
    {
        return !! $value && ($value === "CUSTOM" || $value === "GROUP" || $value === "FILE");
    }

    protected function validateDestination($value)
    {
        return !! $value && ( $value === "NAT" || $value === "INTER" || $value === "NAT_INTER");
    }

    protected function validateMessage($value)
    {
        return !! $value;
    }

    protected function validateRecipients(array $recipients)
    {
        foreach ($recipients as $recipient) {

            if(! isset($recipient['phone'])) {
                return false;
            }
        }

        return true;
    }

    protected function validateSchedules($value)
    {
        return is_null($value) || is_array($value);
    }
}