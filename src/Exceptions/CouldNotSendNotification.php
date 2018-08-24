<?php

namespace NotificationChannels\Kavenegar\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Kavenegar responded with an error: `'.$response->getBody()->getContents().'`');
    }
}
