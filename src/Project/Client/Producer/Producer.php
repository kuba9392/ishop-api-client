<?php

namespace Project\Client\Producer;

class Producer implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $siteUrl;

    /**
     * @var string
     */
    private $logoFilename;

    /**
     * @var integer
     */
    private $ordering;

    /**
     * @var string
     */
    private $sourceId;

    /**
     * @param array $data
     * @return Producer
     * @throws ProducerException
     */
    public static function createFromArray(array $data): self
    {
        $producer = new Producer();

        self::validateProducerData($data, $producer);

        $producer->setId($data["id"]);
        $producer->setName($data["name"]);
        $producer->setSiteUrl($data["site_url"]);
        $producer->setLogoFilename($data["logo_filename"]);
        $producer->setOrdering($data["ordering"]);
        $producer->setSourceId($data["source_id"]);

        return $producer;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSiteUrl(): ?string
    {
        return $this->siteUrl;
    }

    public function setSiteUrl(?string $siteUrl): void
    {
        $this->siteUrl = $siteUrl;
    }

    public function getLogoFilename(): ?string
    {
        return $this->logoFilename;
    }

    public function setLogoFilename(?string $logoFilename): void
    {
        $this->logoFilename = $logoFilename;
    }

    public function getOrdering(): int
    {
        return $this->ordering;
    }

    public function setOrdering(int $ordering): void
    {
        $this->ordering = $ordering;
    }

    public function getSourceId(): ?string
    {
        return $this->sourceId;
    }

    public function setSourceId(?string $sourceId): void
    {
        $this->sourceId = $sourceId;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "site_url" => $this->siteUrl,
            "logo_filename" => $this->logoFilename,
            "ordering" => $this->ordering,
            "source_id" => $this->sourceId
        ];
    }

    /**
     * @param array $data
     * @param Producer $producer
     * @return void
     * @throws ProducerException
     */
    private static function validateProducerData(array $data, Producer $producer): void
    {
        $keys = [];
        foreach ($producer->jsonSerialize() as $key => $value) {
            if (!array_key_exists($key, $data)) {
                $keys[] = $key;
            }
        }

        if (!empty($keys)) {
            throw ProducerException::missingKeys($keys, $data);
        }
    }
}