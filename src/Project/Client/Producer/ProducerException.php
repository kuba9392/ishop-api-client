<?php

namespace Project\Client\Producer;

class ProducerException extends \Exception
{
    const MISSING_KEYS_MESSAGE_FORMAT = "Missing keys in data when creating Producer from array (keys: [%s]) (data: %s)";

    public static function missingKeys(array $keys, array $data)
    {
        return new ProducerException(self::formatMissingKeysMessage($keys, $data));
    }

    private static function formatMissingKeysMessage(array $keys, array $data)
    {
        $formattedKeys = implode(", ", $keys);
        return sprintf(self::MISSING_KEYS_MESSAGE_FORMAT, $formattedKeys, json_encode($data));
    }
}