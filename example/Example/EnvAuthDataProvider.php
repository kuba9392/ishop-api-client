<?php

namespace Example;


use Project\Client\Auth\AuthDataProviderInterface;

class EnvAuthDataProvider implements AuthDataProviderInterface
{
    const ENV_CLIENT_BASIC_AUTH_USER = "CLIENT_BASIC_AUTH_USER";
    const ENV_CLIENT_BASIC_AUTH_PASSWORD = "CLIENT_BASIC_AUTH_PASSWORD";

    private const BASIC_AUTH_HEADER_CONTENT_FORMAT = "Basic %s";

    public function getAsHeader(): array
    {
        return [
            self::AUTHORIZATION_HEADER_KEY => $this->getHeaderContent(
                $this->getUsername(),
                $this->getPassword()
            )
        ];
    }

    private function getUsername()
    {
        return getenv(self::ENV_CLIENT_BASIC_AUTH_USER);
    }

    private function getPassword()
    {
        return getenv(self::ENV_CLIENT_BASIC_AUTH_PASSWORD);
    }

    private function getHeaderContent(string $username, string $password)
    {
        return sprintf(self::BASIC_AUTH_HEADER_CONTENT_FORMAT, base64_encode($username . ":" . $password));
    }
}