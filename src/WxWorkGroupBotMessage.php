<?php

namespace NotificationChannels\WxWorkGroupBot;

use JsonSerializable;
use NotificationChannels\WxWorkGroupBot\Exceptions\CouldNotSendNotification;
use NotificationChannels\WxWorkGroupBot\Messages\File;
use NotificationChannels\WxWorkGroupBot\Messages\Image;
use NotificationChannels\WxWorkGroupBot\Messages\Markdown;
use NotificationChannels\WxWorkGroupBot\Messages\News;
use NotificationChannels\WxWorkGroupBot\Messages\Text;

class WxWorkGroupBotMessage implements JsonSerializable
{
    public const TYPE_TEXT = 'text';
    public const TYPE_MARKDOWN = 'markdown';
    public const TYPE_IMAGE = 'image';
    public const TYPE_NEWS = 'news';
    public const TYPE_FILE = 'file';

    protected $msgType;

    protected $data = [];

    public static function text(?string $text = null): Text
    {
        if ($text === null) {
            return new Text();
        }

        return (new Text())->content($text);
    }

    public static function markdown(?string $content = null): Markdown
    {
        if ($content === null) {
            return new Markdown();
        }
        return (new Markdown())->content($content);
    }

    /**
     * @param mixed $image Can be GD resource, opened file/stream resource, readable file pathname, binary image string
     *
     * @return Image
     * @throws CouldNotSendNotification
     */
    public static function image($image = null): Image
    {
        if ($image === null) {
            return new Image();
        }

        return (new Image())->image($image);
    }

    public static function news(?Article $article = null): News
    {
        if ($article === null) {
            return new News();
        }
        return (new News())->article($article);
    }

    public static function file(?string $filename = null): File
    {
        if ($filename === null) {
            return new File();
        }

        return (new File())->filename($filename);
    }

    public function beforeSend(WxWorkGroupBotChannel $channel, string $key): void
    {
        // override this if something to do before sending
    }

    public function jsonSerialize()
    {
        return $this->getPayload();
    }

    public function getPayload(): array
    {
        return [
            'msgtype'      => $this->msgType,
            $this->msgType => $this->data,
        ];
    }
}
