<?php

namespace Project\Client\Request;

use Project\Client\HttpMockTestCase;

class PostRequestITest extends HttpMockTestCase
{
    public function testExecute()
    {
        $body = "test_response";
        $requestBody = "test_request_body";
        $statusCode = 201;

        $this->addInteraction(
            "Post foo",
            "A post request to /foo",
            $this->mockRequest("POST", "/foo", [], $requestBody),
            $this->mockResponse(201, $body, [])
        );

        $response = PostRequest::newInstance()->setUri(self::getServerPath("/foo"))->setBody($requestBody)->execute();

        $this->assertEquals($body, $response->getBody());
        $this->assertEquals($statusCode, $response->getStatus());
    }

    public function testSetJson()
    {
        $array = ["testKey" => "testValue"];

        $request = PostRequest::newInstance()->setJson($array);

        $this->assertEquals(json_encode($array, true), $request->getBody());
    }

    protected static function getMockServerHost(): string
    {
        return "localhost";
    }
}
