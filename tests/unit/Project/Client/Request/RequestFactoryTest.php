<?php

namespace Project\Client\Request;

use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    /**
     * @var RequestFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new RequestFactory($this->getTestBaseUri());
    }

    public function testGet()
    {
        $uri = "/test_uri";
        $headers = ["testHeader" => "testContent"];

        $request = $this->factory->get($uri, $headers);

        $this->assertEquals($this->getTestBaseUri(). $uri, $request->getUri());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertInstanceOf(GetRequest::class, $request);
    }

    public function testPost()
    {
        $uri = "/test_uri";
        $body = "test_body";
        $headers = ["testHeader" => "testContent"];

        $request = $this->factory->post($uri, $body, $headers);

        $this->assertEquals($this->getTestBaseUri(). $uri, $request->getUri());
        $this->assertEquals($body, $request->getBody());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertInstanceOf(PostRequest::class, $request);
    }

    private function getTestBaseUri(): string
    {
        return "test-base-uri.com";
    }
}
