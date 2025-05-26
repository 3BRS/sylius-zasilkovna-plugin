<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait PacketaShipmentTrait
{
    /** @var array<mixed>|null */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $packeta = null;

    /**
     * @return array<mixed>|null
     */
    public function getPacketa(): ?array
    {
        return $this->packeta;
    }

    /**
     * @param array<mixed>|null $packeta
     */
    public function setPacketa(?array $packeta): void
    {
        $this->packeta = $packeta;
    }
}
