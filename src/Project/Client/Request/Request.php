<?php

namespace Project\Client\Request;


use Project\Client\Response\Response;

abstract class Request
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var mixed
     */
    private $body;

    public abstract function execute(): Response;

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    protected function getCurlHeaders(): array
    {
        $curlHeaders = [];
        foreach ($this->headers as $headerName => $headerValue) {
            $curlHeaders[] = $headerName . ": " . $headerValue;
        }
        return $curlHeaders;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function getHeader(string $headerName)
    {
        return $this->headers[$headerName];
    }

    public function setHeader(string $headerName, $headerValue): self
    {
        $this->headers[$headerName] = $headerValue;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body): self
    {
        $this->body = $body;
        return $this;
    }

    protected function getHeadersArray(string $headers): array
    {
        $headersArray = $this->removeStatusHeader($this->formatToArray($headers));

        $keyValueHeaders = $this->getKeyValueHeaders($headersArray);

        return $keyValueHeaders;
    }

    private function removeStatusHeader(array $headersArray): array
    {
        unset($headersArray[0]);
        $headersArray = array_filter($headersArray);
        return $headersArray;
    }

    private function formatToArray(string $headers): array
    {
        return explode("\r\n", $headers);
    }

    private function getKeyValueHeaders(array $headersArray): array
    {
        $keyValueHeaders = [];
        foreach ($headersArray as $header) {
            $delimiterPosition = strpos($header, ':');
            $headerContent = substr($header, $delimiterPosition + 2, strlen($header));
            $headerName = substr($header, 0, $delimiterPosition);
            $keyValueHeaders[$headerName] = $headerContent;
        }
        return $keyValueHeaders;
    }
}