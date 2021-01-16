<?php

namespace NotificationChannels\WxWorkGroupBot;

use Illuminate\Notifications\Notification;

final class GroupNotification extends Notification
{
    private $message;

    private function __construct() { }

    public static function make(WxWorkGroupBotMessage $message): GroupNotification
    {
        $notification = new self();
        $notification->message = $message;
        return $notification;
    }

    public function toWxWorkGroupBot()
    {
        return $this->message;
    }

    public function via()
    {
        return [WxWorkGroupBotChannel::class];
    }
}
