<?php

use Example\EnvAuthDataProvider;
use Project\Client\ClientManager;
use Project\Client\Request\DefaultRequestFactoryProvider;
use Project\Client\Producer\Producer;

require_once("vendor/autoload.php");

$clientManager = new ClientManager(new DefaultRequestFactoryProvider(), new EnvAuthDataProvider());

$client = $clientManager->getProducerClient();

$testProducerSourceId = getenv("SOURCE_ID");

$testProducer = new Producer();
$testProducer->setName("test_producer");
$testProducer->setSiteUrl("test_url");
$testProducer->setOrdering(1);
$testProducer->setLogoFilename("test_filename");
$testProducer->setSourceId($testProducerSourceId);

$client->createProducer($testProducer);

$producers = $client->listProducers();

foreach ($producers as $producer) {
    if($producer->getSourceId() === $testProducer->getSourceId()) {
        var_dump($producer);
    }
}