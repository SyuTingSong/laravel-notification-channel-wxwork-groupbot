<?php

namespace NotificationChannels\WxWorkGroupBot\Messages;

use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;

class Text extends WxWorkGroupBotMessage
{
    protected $msgType = parent::TYPE_TEXT;

    protected $data = [
        'content'               => '',
        'mentioned_list'        => [],
        'mentioned_mobile_list' => [],
    ];

    public function content(string $content)
    {
        $this->data['content'] = $content;
        return $this;
    }

    public function mention(string $wxWorkUserId)
    {
        $this->data['mentioned_list'][] = $wxWorkUserId;
        return $this;
    }

    public function mentionMobile(string $mobile)
    {
        $this->data['mentioned_mobile_list'][] = $mobile;
        return $this;
    }
}
