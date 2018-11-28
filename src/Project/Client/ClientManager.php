<?php

namespace Project\Client;


use Project\Client\Auth\AuthDataProviderInterface;
use Project\Client\Producer\ProducerClientInterface;
use Project\Client\Request\RequestFactoryProviderInterface;

class ClientManager
{
    /**
     * @var ClientRegistry
     */
    private $clientRegistry;


    public function __construct(
        ?RequestFactoryProviderInterface $requestFactoryProvider = null,
        ?AuthDataProviderInterface $authDataProvider = null
    )
    {
        $this->clientRegistry = new ClientRegistry($requestFactoryProvider, $authDataProvider);
    }

    public function getProducerClient(): ProducerClientInterface
    {
        /** @var ProducerClientInterface $client */
        $client = $this->clientRegistry->getClient(ClientRegistry::PRODUCER_CLIENT_KEY);
        return $client;
    }
}