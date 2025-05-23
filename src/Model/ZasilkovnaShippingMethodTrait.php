<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use ThreeBRS\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfig;
use ThreeBRS\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;

trait ZasilkovnaShippingMethodTrait
{
    #[ORM\OneToOne(targetEntity: ZasilkovnaConfig::class, cascade: ['persist'], fetch: 'EAGER')]
    private ?ZasilkovnaConfigInterface $zasilkovnaConfig = null;

    public function getZasilkovnaConfig(): ?ZasilkovnaConfigInterface
    {
        return $this->zasilkovnaConfig;
    }

    public function setZasilkovnaConfig(?ZasilkovnaConfigInterface $zasilkovnaConfig): void
    {
        $this->zasilkovnaConfig = $zasilkovnaConfig;
    }
}
