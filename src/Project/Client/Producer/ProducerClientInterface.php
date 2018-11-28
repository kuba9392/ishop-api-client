<?php

namespace Project\Client\Producer;

use Project\Client\ClientInterface;

interface ProducerClientInterface extends ClientInterface
{
    /**
     * @return Producer[]
     */
    public function listProducers(): array;

    public function createProducer(Producer $producer): Producer;
}