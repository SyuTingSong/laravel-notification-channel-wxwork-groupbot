<?php

namespace NotificationChannels\WxWorkGroupBot;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use NotificationChannels\WxWorkGroupBot\Exceptions\CouldNotSendNotification;

class WxWorkGroup
{
    use Notifiable;

    protected static $namedGroupKeys = [];

    protected $key;

    public static function get(string $name)
    {
        if (Arr::exists(static::$namedGroupKeys, $name)) {
            return new static(static::$namedGroupKeys[$name]);
        }
        throw new CouldNotSendNotification('Group not found by name: ' . $name, 15);
    }

    public static function make(string $key) {
        return new static($key);
    }

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function routeNotificationForWxWorkGroupBot($notification)
    {
        return $this->key;
    }
}
