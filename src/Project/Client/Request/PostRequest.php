<?php

namespace Project\Client\Request;

use Project\Client\Response\Response;

class PostRequest extends Request
{
    public static function newInstance(): self
    {
        return new self();
    }

    public function execute(): Response
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->getUri(),
            CURLOPT_HTTPHEADER => $this->getCurlHeaders(),
            CURLOPT_HEADER => true,
            CURLOPT_POSTFIELDS => $this->getBody()
        ));

        $resp = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $headersSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($resp, 0, $headersSize);
        $body = substr($resp, $headersSize);

        curl_close($curl);

        return Response::newInstance()->setBody($body)->setStatus($httpCode)->setHeaders($this->getHeadersArray($headers));
    }

    public function setJson(array $body): Request
    {
        return $this->setBody(json_encode($body));
    }
}