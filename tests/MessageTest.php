<?php

namespace NotificationChannels\Kavenegar\Test;

use Illuminate\Support\Arr;
use NotificationChannels\Kavenegar\KavenegarMessage;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /** @var \NotificationChannels\Kavenegar\KavenegarMessage */
    protected $message;

    protected function setUp(): void
    {
        parent::setUp();

        $this->message = new KavenegarMessage();
    }

    /** @test */
    public function it_accepts_a_receptor_when_constructing_a_message()
    {
        $message = new KavenegarMessage('receptor');

        $this->assertEquals('receptor', Arr::get($message->toArray(), 'receptor'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = KavenegarMessage::create('receptor');

        $this->assertEquals('receptor', Arr::get($message->toArray(), 'receptor'));
    }

    /** @test */
    public function it_can_set_the_user()
    {
        $this->message->receptor('mobile-number');

        $this->assertEquals('mobile-number', Arr::get($this->message->toArray(), 'receptor'));
    }

    /** @test */
    public function it_can_set_the_template()
    {
        $this->message->template('otp');

        $this->assertEquals('otp', Arr::get($this->message->toArray(), 'template'));
    }

    /** @test */
    public function it_can_set_the_type()
    {
        $this->message->type('sms');

        $this->assertEquals('sms', Arr::get($this->message->toArray(), 'type'));
    }

    /** @test */
    public function it_can_set_the_message()
    {
        $this->message->message('my message');

        $this->assertEquals('my message', Arr::get($this->message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_sender()
    {
        $this->message->sender('sender');

        $this->assertEquals('sender', Arr::get($this->message->toArray(), 'sender'));
    }

    /** @test */
    public function it_can_set_the_tokens()
    {
        $this->message->token('first');
        $this->message->token('10th', 10);

        $this->assertEquals('first', Arr::get($this->message->toArray(), 'token'));
        $this->assertEquals('10th', Arr::get($this->message->toArray(), 'token10'));
    }
}
