<?php
namespace Project\Client\Producer;

use PHPUnit\Framework\TestCase;

class ProducerTest extends TestCase
{

    /**
     * @throws ProducerException
     */
    public function testCreateFromArrayWhenKeysExistsThenCreateProducer()
    {
        $data = [
            "id" => 1,
            "name" => "test_name",
            "site_url" => "test_site_url",
            "logo_filename" => "test_logo_filename",
            "ordering" => 1,
            "source_id" => "test_source_id"
        ];

        $producer = Producer::createFromArray($data);
        $this->assertEquals($data, $producer->jsonSerialize());
    }

    /**
     * @throws ProducerException
     */
    public function testCreateFromArrayWhenKeysAreNullThenCreateProducer()
    {
        $data = [
            "id" => 1,
            "name" => "test_name",
            "site_url" => "test_site_url",
            "logo_filename" => "test_logo_filename",
            "ordering" => 1,
            "source_id" => null
        ];

        $producer = Producer::createFromArray($data);
        $this->assertEquals($data, $producer->jsonSerialize());
    }

    /**
     * @expectedException \Project\Client\Producer\ProducerException
     * @expectedExceptionMessage Missing keys in data when creating Producer from array (keys: [site_url])
     */
    public function testCreateFromArrayWhenKeyNotExistsThenThrowException()
    {
        $data = [
            "id" => 1,
            "name" => "test_name",
            "bad_site_url" => "test_site_url",
            "logo_filename" => "test_logo_filename",
            "ordering" => 1,
            "source_id" => "test_source_id"
        ];

        Producer::createFromArray($data);
    }

    /**
     * @expectedException \Project\Client\Producer\ProducerException
     * @expectedExceptionMessage Missing keys in data when creating Producer from array (keys: [name, site_url])
     */
    public function testCreateFromArrayWhenKeysNotExistsThenThrowException()
    {
        $data = [
            "id" => 1,
            "bad_name" => "test_name",
            "bad_site_url" => "test_site_url",
            "logo_filename" => "test_logo_filename",
            "ordering" => 1,
            "source_id" => "test_source_id"
        ];

        Producer::createFromArray($data);
    }
}
