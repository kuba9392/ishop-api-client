<?php

namespace Project\Client\Request;


use Project\Client\HttpMockTestCase;

class GetRequestITest extends HttpMockTestCase
{

    public function testExecute()
    {
        $body = "test_response";
        $statusCode = 200;

        $this->addInteraction(
            "Get foo",
            "A get request to /foo",
            $this->mockRequest("GET", "/foo", []),
            $this->mockResponse(200, $body, [])
        );

        $response = GetRequest::newInstance()->setUri(self::getServerPath("/foo"))->execute();

        $this->assertEquals($body, $response->getBody());
        $this->assertEquals($statusCode, $response->getStatus());
    }

    protected static function getMockServerHost(): string
    {
        return "localhost";
    }
}
