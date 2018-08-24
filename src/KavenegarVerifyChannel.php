<?php

namespace NotificationChannels\Kavenegar;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use NotificationChannels\Kavenegar\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use NotificationChannels\Kavenegar\Exceptions\InvalidConfiguration;

class KavenegarVerifyChannel
{
    private static $API_ENDPOINT = 'https://api.kavenegar.com/v1/%s/verify/lookup.json';

    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Kavenegar\Exceptions\InvalidConfiguration
     * @throws \NotificationChannels\Kavenegar\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $routing = collect($notifiable->routeNotificationFor('Kavenegar'))) {
            return;
        }

        $key = config('services.kavenegar.api_key');

        if (is_null($key)) {
            throw InvalidConfiguration::configurationNotSet();
        }

        $kavenegarParameters = $notification->toKavenegar($notifiable)->toArray();

        $response = $this->client->post(sprintf(self::$API_ENDPOINT, $key), [
            'form_params' => Arr::set($kavenegarParameters, 'receptor', $routing->get('mobile_number')),
        ]);

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
