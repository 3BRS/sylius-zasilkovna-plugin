<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShippingMethodInterface;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShippingMethodTrait;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'sylius_shipping_method')]
class ShippingMethod extends BaseShippingMethod implements PacketaShippingMethodInterface
{
    use PacketaShippingMethodTrait;
}
