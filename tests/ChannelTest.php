<?php

namespace NotificationChannels\Kavenegar\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use NotificationChannels\Kavenegar\Exceptions\CouldNotSendNotification;
use NotificationChannels\Kavenegar\Exceptions\InvalidConfiguration;
use NotificationChannels\Kavenegar\KavenegarChannel;
use Orchestra\Testbench\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $this->app['config']->set('services.kavenegar.api_key', 'my-api-key');

        $response = new Response(200);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://api.kavenegar.com/v1/my-api-key/sms/send.json', [
                    'form_params' => [
                        'receptor' => 'mobile-number',
                        'template' => 'sms-template',
                        'type' => 'sms',
                        'token' => 'hello',
                        'token10' => 'my number',
                    ],
                ])
            ->andReturn($response);
        $channel = new KavenegarChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_is_not_configured()
    {
        $this->expectException(InvalidConfiguration::class);

        $client = new Client();
        $channel = new KavenegarChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->expectException(CouldNotSendNotification::class);

        $this->app['config']->set('services.kavenegar.api_key', 'api-key');

        $response = new Response(500);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->andReturn($response);
        $channel = new KavenegarChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }
}
