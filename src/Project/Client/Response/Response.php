<?php

namespace Project\Client\Response;


class Response
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var int
     */
    private $status;

    /**
     * @var array
     */
    private $headers;

    public static function newInstance(): self
    {
        return new self();
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): Response
    {
        $this->body = $body;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Response
    {
        $this->status = $status;
        return $this;
    }

    public function setHeaders(array $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getHeader(string $name)
    {
        return $this->headers[$name];
    }

}