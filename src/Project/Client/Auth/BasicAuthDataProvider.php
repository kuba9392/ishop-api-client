<?php

namespace Project\Client\Auth;


class BasicAuthDataProvider implements AuthDataProviderInterface
{
    private const BASIC_AUTH_HEADER_CONTENT_FORMAT = "Basic %s";

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getAsHeader(): array
    {
        return [
            self::AUTHORIZATION_HEADER_KEY => $this->getHeaderContent(
                $this->username,
                $this->password
            )
        ];
    }

    private function getHeaderContent(string $username, string $password)
    {
        return sprintf(self::BASIC_AUTH_HEADER_CONTENT_FORMAT, base64_encode($username . ":" . $password));
    }
}