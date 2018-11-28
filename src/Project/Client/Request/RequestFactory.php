<?php

namespace Project\Client\Request;

class RequestFactory
{
    /**
     * @var string
     */
    private $baseUri = "";

    public function __construct(string $baseUri = "")
    {
        $this->baseUri = $baseUri;
    }

    public function get(string $uri, array $headers = []): Request
    {
        return GetRequest::newInstance()->setUri($this->baseUri . $uri)->setHeaders($headers);
    }

    public function post(string $uri, $body, array $headers = []): Request
    {
        return PostRequest::newInstance()->setUri($this->baseUri . $uri)->setBody($body)->setHeaders($headers);
    }
}