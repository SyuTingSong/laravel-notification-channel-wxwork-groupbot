<?php

namespace NotificationChannels\WxWorkGroupBot\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotChannel;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $client = new Client(['handler' => HandlerStack::create(new MockHandler([
            new Response(200),
        ]))]);
        $channel = new WxWorkGroupBotChannel($client);
        $response = $channel->send(new TestNotifiable(), new TestNotification());
        self::assertEquals(200, $response->getStatusCode());
    }
}

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForWxWorkGroupBot()
    {
        return 'XXXX-XXXX';
    }
}

class TestNotification extends Notification
{
    public function toWxWorkGroupBot($notifiable)
    {
        return WxWorkGroupBotMessage::text('Hello, world!');
    }
}
