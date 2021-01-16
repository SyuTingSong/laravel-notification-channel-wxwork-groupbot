<?php

namespace NotificationChannels\WxWorkGroupBot\Messages;

use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotChannel;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;

class File extends WxWorkGroupBotMessage
{
    protected $msgType = parent::TYPE_FILE;

    protected $attachment;

    public function filename(string $filename): File
    {
        $this->attachment[0] = $filename;
        return $this;
    }

    public function mimeType(string $type): File
    {
        $this->attachment[1] = $type;
        return $this;
    }

    public function beforeSend(WxWorkGroupBotChannel $channel, string $key): void
    {
        $o = $channel->uploadFileFor($key, ...$this->attachment);
        $this->data = [
            'media_id' => $o->media_id,
        ];
    }
}
