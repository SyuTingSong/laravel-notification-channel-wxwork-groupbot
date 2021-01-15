<?php

namespace NotificationChannels\WxWorkGroupBot\Messages;

use NotificationChannels\WxWorkGroupBot\Article;
use NotificationChannels\WxWorkGroupBot\WxWorkGroupBotMessage;

class News extends WxWorkGroupBotMessage
{
    protected $msgType = parent::TYPE_NEWS;

    protected $data = ['articles' => []];

    public function article(Article $article): News
    {
        $this->data['articles'][] = $article;
        return $this;
    }

    public function articles(Article ...$articles): News
    {
        $this->data['articles'] = $articles;
        return $this;
    }
}
