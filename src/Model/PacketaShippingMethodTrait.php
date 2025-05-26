<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use ThreeBRS\SyliusPacketaPlugin\Entity\PacketaConfig;
use ThreeBRS\SyliusPacketaPlugin\Entity\PacketaConfigInterface;

trait PacketaShippingMethodTrait
{
    #[ORM\OneToOne(targetEntity: PacketaConfig::class, cascade: ['persist'], fetch: 'EAGER')]
    private ?PacketaConfigInterface $packetaConfig = null;

    public function getPacketaConfig(): ?PacketaConfigInterface
    {
        return $this->packetaConfig;
    }

    public function setPacketaConfig(?PacketaConfigInterface $packetaConfig): void
    {
        $this->packetaConfig = $packetaConfig;
    }
}
