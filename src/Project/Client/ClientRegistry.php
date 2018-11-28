<?php

namespace Project\Client;


use Project\Client\Auth\AuthDataProviderInterface;
use Project\Client\Producer\RestProducerClient;
use Project\Client\Request\RequestFactoryProviderInterface;

class ClientRegistry
{
    const PRODUCER_CLIENT_KEY = "producerClient";

    /**
     * @var ClientInterface[]
     */
    private $clients;


    public function __construct(
        RequestFactoryProviderInterface $requestFactoryProvider,
        ?AuthDataProviderInterface $authDataProvider = null
    )
    {
        $this->clients = [
            self::PRODUCER_CLIENT_KEY => new RestProducerClient($requestFactoryProvider->get(), $authDataProvider)
        ];
    }

    public function getClient(string $clientKey): ClientInterface
    {
        return $this->clients[$clientKey];
    }
}