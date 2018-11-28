<?php

namespace Project\Client\Producer;


use Project\Client\Auth\AuthDataProviderInterface;
use Project\Client\ClientException;
use Project\Client\Request\RequestFactory;

class RestProducerClient implements ProducerClientInterface
{
    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var AuthDataProviderInterface
     */
    private $authDataProvider;

    public function __construct(RequestFactory $requestFactory, ?AuthDataProviderInterface $authDataProvider = null)
    {
        $this->requestFactory = $requestFactory;
        $this->authDataProvider = $authDataProvider;
    }

    /**
     * @return Producer[]
     * @throws ClientException
     * @throws ProducerException
     */
    public function listProducers(): array
    {
        $response = $this->requestFactory->get("/producers", $this->getAuthData())->execute();
        $responseBody = $this->unmarshallBody($response->getBody());

        if ($response->getStatus() === 401) {
            throw ClientException::unauthorizedRequest();
        }

        if ($response->getStatus() !== 200) {
            throw ClientException::apiError($responseBody["error"]['reason_code'], $responseBody["error"]["messages"]);
        }

        return $this->getProducersFromData($responseBody['data']['producers']);
    }

    /**
     * @param Producer $producer
     * @return Producer
     * @throws ClientException
     * @throws ProducerException
     */
    public function createProducer(Producer $producer): Producer
    {
        $producerData = [
            "producer" => $producer
        ];

        $response = $this->requestFactory->post("/producers", json_encode($producerData), $this->getAuthData())->execute();
        $responseBody = $this->unmarshallBody($response->getBody());

        if ($response->getStatus() === 401) {
            throw ClientException::unauthorizedRequest();
        }

        if ($response->getStatus() !== 200) {
            throw ClientException::apiError($responseBody["error"]['reason_code'], $responseBody["error"]["messages"]);
        }

        return Producer::createFromArray($responseBody['data']['producer']);
    }

    private function unmarshallBody(string $responseBody)
    {
        return json_decode($responseBody, true);
    }

    private function getAuthData(): array
    {
        return $this->authDataProvider !== null ? $this->authDataProvider->getAsHeader() : [];
    }

    /**
     * @param $producersData
     * @return array
     * @throws ProducerException
     */
    protected function getProducersFromData(array $producersData): array
    {
        $producers = [];
        foreach ($producersData as $producerData) {
            $producers[] = Producer::createFromArray($producerData);
        }
        return $producers;
    }
}