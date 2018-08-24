<?php

namespace NotificationChannels\Kavenegar\Test;

use Illuminate\Notifications\Notification;
use NotificationChannels\Kavenegar\KavenegarMessage;

class TestNotification extends Notification
{
    public function toKavenegar($notifiable)
    {
        return
            (new KavenegarMessage())
                ->template('sms-template')
                ->type('sms')
                ->token('hello')
                ->token('my number', 10);
    }
}