<?php

namespace NotificationChannels\WxWorkGroupBot\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(ResponseInterface $response, int $code = 0)
    {
        return new static(sprintf('Server response with an error: %d %s %s',
            $response->getStatusCode(),
            $response->getReasonPhrase(),
            $response->getBody()->getContents()
        ), $code);
    }
}
