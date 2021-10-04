<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Model;

use ThreeBRS\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;

interface ZasilkovnaShippingMethodInterface
{
    public function getZasilkovnaConfig(): ?ZasilkovnaConfigInterface;

    public function setZasilkovnaConfig(?ZasilkovnaConfigInterface $zasilkovnaConfig): void;
}
