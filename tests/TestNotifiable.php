<?php

namespace NotificationChannels\Kavenegar\Test;

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return array
     */
    public function routeNotificationForKavenegar()
    {
        return ['mobile_number' => 'mobile-number'];
    }
}