<?php

namespace NotificationChannels\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotChannel;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;
use PHPUnit\Framework\TestCase;

class ChannelTests extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $response = new Response(200);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=XXXX-XXXX',
                [
                    'body' => json_encode(['msgtype' => 'text', 'text' => [
                        'content'               => 'Hello, world!',
                        'mentioned_list'        => [],
                        'mentioned_mobile_list' => [],
                    ]]),
                ]
            )
            ->andReturn($response);
        $channel = new WxWorkGroupBotChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
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
