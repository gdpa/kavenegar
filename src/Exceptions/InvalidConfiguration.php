<?php

namespace NotificationChannels\Kavenegar\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send notification via Kavenegar you need to add `api_key` in the `kavenegar` key of `config.services`.');
    }
}
