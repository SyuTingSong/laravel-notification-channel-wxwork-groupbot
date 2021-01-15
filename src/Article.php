<?php

namespace NotificationChannels\WxWorkGroupBot;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class Article implements JsonSerializable, Arrayable
{
    protected $title = '';

    protected $description = '';

    protected $url = '';

    protected $pictureUrl = '';

    public function title(string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    public function description(string $description): Article
    {
        $this->description = $description;
        return $this;
    }

    public function url(string $url): Article
    {
        $this->url = $url;
        return $this;
    }

    public function pictureUrl(string $pictureUrl): Article
    {
        $this->pictureUrl = $pictureUrl;
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'url'         => $this->url,
            'picurl'      => $this->pictureUrl,
        ];
    }
}
