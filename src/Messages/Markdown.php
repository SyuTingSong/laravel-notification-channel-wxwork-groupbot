<?php

namespace NotificationChannels\WxWorkGroupBot\Messages;

use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;

class Markdown extends WxWorkGroupBotMessage
{
    protected $msgType = parent::TYPE_MARKDOWN;

    protected $data = ['content' => ''];

    public function content(string $content)
    {
        $this->data['content'] = $content;
        return $this;
    }
}
