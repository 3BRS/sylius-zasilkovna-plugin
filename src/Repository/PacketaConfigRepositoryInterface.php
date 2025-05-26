<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use ThreeBRS\SyliusPacketaPlugin\Entity\PacketaConfigInterface;

interface PacketaConfigRepositoryInterface extends RepositoryInterface
{
    public function findOneEnabled(): ?PacketaConfigInterface;
}
