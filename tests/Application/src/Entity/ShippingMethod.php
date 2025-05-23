<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusZasilkovnaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodTrait;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'sylius_shipping_method')]
class ShippingMethod extends BaseShippingMethod implements ZasilkovnaShippingMethodInterface
{
    use ZasilkovnaShippingMethodTrait;
}
