<?php

namespace Project\Client;

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Standalone\MockService\MockServerConfig;
use PHPUnit\Framework\TestCase;

abstract class HttpMockTestCase extends TestCase
{
    const ENV_MOCK_SERVER_PORT = "MOCK_SERVER_PORT";

    /**
     * @var MockServer
     */
    private $server;

    /**
     * @var InteractionBuilder
     */
    private $interactionBuilder;

    protected static function getMockServerPort(): int
    {
        return self::getMockServerPortFromEnv() != 0 ? self::getMockServerPortFromEnv() : 50000;
    }

    protected static abstract function getMockServerHost(): string;

    protected static function getServerPath(string $path): string
    {
        return static::getServerUri() . $path;
    }

    protected static function getServerUri(): string
    {
        return static::getMockServerHost() . ":" . static::getMockServerPort();
    }

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        $config = new MockServerConfig();
        $config->setHost(static::getMockServerHost());
        $config->setPort(static::getMockServerPort());
        $config->setConsumer('testConsumer');
        $config->setProvider('testProvider');
        $config->setCors(true);

        $this->interactionBuilder = new InteractionBuilder($config);
        $this->server = new MockServer($config);

        $this->server->start();
    }

    public function tearDown()
    {
        $this->server->stop();
    }

    protected function mockRequest(string $method, string $path, array $headers, $body = null)
    {
        $request = new ConsumerRequest();
        $request
            ->setMethod($method)
            ->setPath($path)
            ->setBody($body);

        foreach ($headers as $headerName => $headerContent) {
            $request->addHeader($headerName, $headerContent);
        }

        return $request;
    }

    protected function mockResponse(int $statusCode, $body, array $headers)
    {
        $response = new ProviderResponse();
        $response
            ->setStatus($statusCode)
            ->setBody($body);

        foreach ($headers as $headerName => $headerContent) {
            $response->addHeader($headerName, $headerContent);
        }

        return $response;
    }

    protected function addInteraction(string $providerState, string $description, ConsumerRequest $request, ProviderResponse $response)
    {
        $this->interactionBuilder->given($providerState)->uponReceiving($description)->with($request)->willRespondWith($response);
    }

    private static function getMockServerPortFromEnv()
    {
        return getenv(self::ENV_MOCK_SERVER_PORT);
    }
}