<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

#[ORM\Table(name: 'threebrs_packeta_config')]
#[ORM\Entity]
class PacketaConfig implements ResourceInterface, PacketaConfigInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $apiKey = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $senderLabel = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $carrierId = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $optionCountry = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getOptionCountry(): ?string
    {
        return $this->optionCountry;
    }

    public function setOptionCountry(?string $optionCountry): void
    {
        $this->optionCountry = $optionCountry;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getSenderLabel(): ?string
    {
        return $this->senderLabel;
    }

    public function setSenderLabel(?string $senderLabel): void
    {
        $this->senderLabel = $senderLabel;
    }

    public function getCarrierId(): ?string
    {
        return $this->carrierId;
    }

    public function setCarrierId(?string $carrierId): void
    {
        $this->carrierId = $carrierId;
    }
}
