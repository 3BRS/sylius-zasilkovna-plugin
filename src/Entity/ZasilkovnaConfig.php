<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Table(name="threebrs_zasilkovna_config")
 *
 * @ORM\Entity
 */
#[ORM\Table(name: 'threebrs_zasilkovna_config')]
#[ORM\Entity]
class ZasilkovnaConfig implements ResourceInterface, ZasilkovnaConfigInterface
{
    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', nullable: false)]
    protected ?int $id = null;

    /** @ORM\Column(type="string", nullable=true) */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $apiKey = null;

    /** @ORM\Column(type="string", nullable=true) */
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $senderLabel = null;

    /** @ORM\Column(type="string", nullable=true) */
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $carrierId = null;

    /** @ORM\Column(type="string", nullable=true) */
    #[ORM\Column(type: 'string', nullable: true)]
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
