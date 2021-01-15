<?php

namespace NotificationChannels\WxWorkGroupBot;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Notifications\Notification;
use NotificationChannels\WxWorkGroupBot\Exceptions\CouldNotSendNotification;
use stdClass;

class WxWorkGroupBotChannel
{
    /** @var HttpClient */
    protected $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $key = $notifiable->routeNotificationFor('wxWorkGroupBot');

        if (method_exists($notification, 'toWxWorkGroupBot')) {
            $message = $notification->toWxWorkGroupBot($notifiable);
        } else if (method_exists($notification, 'toArray')) {
            $message = $notification->toArray($notifiable);
        } else {
            throw new CouldNotSendNotification(
                'invalid notification, must implement toWxWorkGroupBot or toArray',
                1
            );
        }

        if ($message instanceof WxWorkGroupBotMessage) {
            $message->beforeSend($this, $key);
        }

        $webhookUrl = "https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=$key";
        try {
            $r = $this->httpClient->post($webhookUrl, [RequestOptions::JSON => $message]);
            $status = $r->getStatusCode();
            if ($status >= 300 || $status < 200) {
                throw CouldNotSendNotification::serviceRespondedWithAnError($r, 2);
            }
            return $r;
        } catch (GuzzleException $e) {
            throw new CouldNotSendNotification('Send message failed: ' . $e->getMessage(), 3, $e);
        }
    }

    /**
     * @param string $key
     * @param string $filename
     * @param string $mimeType
     *
     * @return stdClass
     * @throws CouldNotSendNotification
     */
    public function uploadFileFor(string $key, string $filename, string $mimeType)
    {
        $file = file_get_contents($filename);
        $uploadUrl = "https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media?key={$key}&type=file";
        try {
            $r = $this->httpClient->post($uploadUrl, [
                RequestOptions::MULTIPART => [[
                    'name'     => 'media',
                    'contents' => $file,
                    'filename' => basename($filename),
                    'headers'  => ['Content-Type' => $mimeType],
                ]],
            ]);
        } catch (GuzzleException $e) {
            throw new CouldNotSendNotification('Upload file error: %s' . $e->getMessage(), 7, $e);
        }
        $status = $r->getStatusCode();
        if ($status < 200 || $status >= 300) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($r, 5);
        }

        $o = json_decode($r->getBody()->getContents());
        if (!$o) {
            throw new CouldNotSendNotification('Upload file failed: cannot decode api response', 6);
        }
        if ($o->errcode !== 0) {
            throw new CouldNotSendNotification('Upload file failed: ' . $o->errmsg, 8);
        }

        return $o;
    }
}
