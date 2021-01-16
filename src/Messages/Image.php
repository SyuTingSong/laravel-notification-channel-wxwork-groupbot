<?php

namespace NotificationChannels\WxWorkGroupBot\Messages;

use NotificationChannels\WxWorkGroupBot\Exceptions\CouldNotSendNotification;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;

class Image extends WxWorkGroupBotMessage
{
    protected $msgType = parent::TYPE_IMAGE;

    /**
     * @param mixed $image
     *
     * @throws CouldNotSendNotification
     */
    public function __construct($image)
    {
        if (is_resource($image)) {
            if (get_resource_type($image) === 'gd') {
                ob_start();
                imagepng($image);
                $image = ob_get_clean();
                goto buildMessage;
            } elseif (get_resource_type($image) === 'stream') {
                $image = stream_get_contents($image);
                goto buildMessage;
            }
        }
        if (is_string($image)) {
            if (is_readable($image)) {
                $image = file_get_contents($image);
            }
            goto buildMessage;
        }
        throw new CouldNotSendNotification('unsupported image');

        buildMessage:
        $this->data = [
            'base64' => base64_encode($image),
            'md5'    => md5($image),
        ];
    }
}
