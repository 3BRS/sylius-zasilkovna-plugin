<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Shipment as BaseShipment;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShipmentInterface;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShipmentTrait;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'sylius_shipment')]
class Shipment extends BaseShipment implements PacketaShipmentInterface
{
    use PacketaShipmentTrait;
}
