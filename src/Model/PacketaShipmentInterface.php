<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Model;

use Sylius\Component\Shipping\Model\ShipmentInterface;

interface PacketaShipmentInterface extends ShipmentInterface
{
    /**
     * @return array<mixed>|null
     */
    public function getPacketa(): ?array;

    /**
     * @param array<mixed>|null $packeta
     */
    public function setPacketa(?array $packeta): void;
}
