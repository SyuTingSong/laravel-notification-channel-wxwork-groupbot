<?php

namespace NotificationChannels\WxWorkGroupBot\Test;

use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /** @test */
    public function can_build_text_message()
    {
        self::assertJsonStringEqualsJsonString(
            json_encode(['msgtype' => 'text', 'text' => [
                'content'               => 'Hello, world!',
                'mentioned_list'        => [],
                'mentioned_mobile_list' => [],
            ]]),
            json_encode(WxWorkGroupBotMessage::text('Hello, world!'))
        );
    }

    /** @test */
    public function add_mention_list()
    {
        self::assertJsonStringEqualsJsonString(
            json_encode(['msgtype' => 'text', 'text' => [
                'content'               => 'Hello, world!',
                'mentioned_list'        => ['zhangsan'],
                'mentioned_mobile_list' => [],
            ]]), json_encode(
                WxWorkGroupBotMessage::text('Hello, world!')
                    ->mention('zhangsan')
            )
        );
    }

    /** @test */
    public function add_mention_mobile()
    {
        self::assertJsonStringEqualsJsonString(
            json_encode(['msgtype' => 'text', 'text' => [
                'content'               => 'Hello, world!',
                'mentioned_list'        => [],
                'mentioned_mobile_list' => ['13322221111'],
            ]]), json_encode(
                WxWorkGroupBotMessage::text('Hello, world!')
                    ->mentionMobile('13322221111')
            )
        );
    }
}
