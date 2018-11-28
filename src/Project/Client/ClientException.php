<?php

namespace Project\Client;


class ClientException extends \Exception
{
    const API_ERROR_MESSAGE_FORMAT = "Occurred API error (Reason: %s) (Messages: %s)";

    public static function unauthorizedRequest()
    {
        return new self("Unauthorized request with 401 code");
    }

    public static function apiError(string $reason, array $messages)
    {
        return new self(self::formatApiError($reason, $messages));
    }

    private static function formatApiError(string $reason, array $messages): string
    {
        return sprintf(self::API_ERROR_MESSAGE_FORMAT, $reason, json_encode($messages));
    }
}