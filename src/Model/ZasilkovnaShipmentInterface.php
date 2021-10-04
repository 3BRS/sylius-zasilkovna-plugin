<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Model;

interface ZasilkovnaShipmentInterface
{
    /**
     * @return array<mixed>|null
     */
    public function getZasilkovna(): ?array;

    /**
     * @param array<mixed>|null $zasilkovna
     */
    public function setZasilkovna(?array $zasilkovna): void;
}
