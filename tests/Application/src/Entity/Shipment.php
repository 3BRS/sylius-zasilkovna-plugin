<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusZasilkovnaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Shipment as BaseShipment;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'sylius_shipment')]
class Shipment extends BaseShipment implements ZasilkovnaShipmentInterface
{
    use ZasilkovnaShipmentTrait;
}
