<?php

namespace Project\Client\Producer;

use Project\Client\Auth\AuthDataProviderInterface;
use Project\Client\HttpMockTestCase;
use Project\Client\Request\RequestFactory;
use Project\Client\Request\RequestFactoryProviderInterface;

class TestRequestFactoryProviderInterface implements RequestFactoryProviderInterface
{

    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function get(): RequestFactory
    {
        return new RequestFactory($this->uri);
    }
}

class MockAuthDataProvider implements AuthDataProviderInterface
{
    const TEST_HEADER_CONTENT = "test_auth_key";

    public function getAsHeader(): array
    {
        return [
            self::AUTHORIZATION_HEADER_KEY => self::TEST_HEADER_CONTENT
        ];
    }
}

class RestProducerClientITest extends HttpMockTestCase
{
    /**
     * @var MockAuthDataProvider
     */
    private $authDataProvider;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    public function setUp()
    {
        parent::setUp();
        $this->authDataProvider = new MockAuthDataProvider();
        $this->requestFactory = (new TestRequestFactoryProviderInterface(self::getServerUri()))->get();
    }

    /**
     * @throws ProducerException
     * @throws \Project\Client\ClientException
     */
    public function testCreateProducerWhenGivenAuthorizationData()
    {
        $testProducer = $this->createTestProducer();

        $producerData = [
            "producer" => $testProducer
        ];

        $this->addInteraction(
            "Post Producers",
            "Post /producers",
            $this->mockRequest("POST", "/producers", $this->authDataProvider->getAsHeader(), json_encode($producerData)),
            $this->mockResponse(200, json_encode($this->createResponseMessage(true, $producerData)), [])
        );

        $client = new RestProducerClient($this->requestFactory, $this->authDataProvider);
        $this->assertEquals($testProducer, $client->createProducer($testProducer));
    }

    /**
     * @throws ProducerException
     * @throws \Project\Client\ClientException
     * @expectedException \Project\Client\ClientException
     * @expectedExceptionMessage Unauthorized request with 401 code
     */
    public function testCreateProducerWhenNotGivenAuthorizationData()
    {
        $testProducer = $this->createTestProducer();

        $producerData = [
            "producer" => $testProducer
        ];

        $this->addInteraction(
            "Post Producers",
            "Post /producers",
            $this->mockRequest("POST", "/producers", [], json_encode($producerData)),
            $this->mockResponse(401, null, [])
        );

        $client = new RestProducerClient($this->requestFactory);
        $client->createProducer($testProducer);
    }

    /**
     * @throws ProducerException
     * @throws \Project\Client\ClientException
     * @expectedException \Project\Client\ClientException
     * @expectedExceptionMessage Occurred API error (Reason: TEST_REASON_CODE)
     */
    public function testCreateProducerWhenErrorOccurred()
    {
        $testProducer = $this->createTestProducer();

        $producerData = [
            "producer" => $testProducer
        ];

        $this->addInteraction(
            "Post Producers",
            "Post /producers",
            $this->mockRequest("POST", "/producers", [], json_encode($producerData)),
            $this->mockResponse(400, json_encode($this->createResponseMessage(false, null, $this->createTestError())), [])
        );

        $client = new RestProducerClient($this->requestFactory);
        $client->createProducer($testProducer);
    }

    /**
     * @throws ProducerException
     * @throws \Project\Client\ClientException
     */
    public function testListProducersWhenGivenAuthorizationData()
    {
        $testProducer = $this->createTestProducer();

        $this->addInteraction(
            "Get Producers",
            "Get /producers",
            $this->mockRequest("GET", "/producers", $this->authDataProvider->getAsHeader()),
            $this->mockResponse(200, json_encode($this->createResponseMessage(true, [
                "producers" => [$testProducer]
            ])), [])
        );

        $client = new RestProducerClient($this->requestFactory, $this->authDataProvider);
        $this->assertEquals([$testProducer], $client->listProducers());
    }

    /**
     * @throws ProducerException
     * @throws \Project\Client\ClientException
     *
     * @expectedException \Project\Client\ClientException
     * @expectedExceptionMessage Unauthorized request with 401 code
     */
    public function testListProducersWhenNotGivenAuthorizationData()
    {
        $this->addInteraction(
            "Get Producers",
            "Get /producers",
            $this->mockRequest("GET", "/producers", []),
            $this->mockResponse(401, null, [])
        );

        $client = new RestProducerClient($this->requestFactory);
        $client->listProducers();
    }


    /**
     * @throws ProducerException
     * @throws \Project\Client\ClientException
     * @expectedException \Project\Client\ClientException
     * @expectedExceptionMessage Occurred API error (Reason: TEST_REASON_CODE)
     */
    public function testListProducersWhenErrorOccurred()
    {
        $responseMessage = $this->createResponseMessage(false, null, $this->createTestError());

        $this->addInteraction(
            "Get Producers",
            "Get /producers",
            $this->mockRequest("GET", "/producers", []),
            $this->mockResponse(400, json_encode($responseMessage), [])
        );

        $client = new RestProducerClient($this->requestFactory);
        $client->listProducers();
    }

    private function createTestProducer()
    {
        $producer = new Producer();
        $producer->setId(1);
        $producer->setName("test_producer");
        $producer->setSiteUrl("test_url");
        $producer->setOrdering(1);
        $producer->setLogoFilename("test_filename");
        $producer->setSourceId("test_source_id");
        return $producer;
    }

    private function createTestError()
    {
        return [
            "reason_code" => "TEST_REASON_CODE",
            "messages" => [
                "test.message"
            ]
        ];
    }

    private function createResponseMessage(bool $success, $data, ?array $error = null)
    {
        return [
            "version" => "v1",
            "success" => $success,
            "data" => $data,
            "error" => $error
        ];
    }

    protected static function getMockServerHost(): string
    {
        return "localhost";
    }

}
