<?php

namespace NotificationChannels\WxWorkGroupBot;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Container\Container;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class WxWorkGroupBotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->when(WxWorkGroupBotChannel::class)
            ->needs(HttpClient::class)
            ->give(static function () {
                return new HttpClient();
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('wxWorkGroupBot', static function (Container $app) {
                return $app->make(WxWorkGroupBotChannel::class);
            });
        });
    }
}
