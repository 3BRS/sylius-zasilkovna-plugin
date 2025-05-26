<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Model;

use ThreeBRS\SyliusPacketaPlugin\Entity\PacketaConfigInterface;

interface PacketaShippingMethodInterface
{
    public function getPacketaConfig(): ?PacketaConfigInterface;

    public function setPacketaConfig(?PacketaConfigInterface $packetaConfig): void;
}
