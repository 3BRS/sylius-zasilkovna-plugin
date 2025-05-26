<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use ThreeBRS\SyliusPacketaPlugin\Entity\PacketaConfig;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShipmentInterface;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShippingMethodInterface;

final readonly class ShippingMethodContext implements Context
{
    public function __construct(private EntityManagerInterface $entityManager, private SharedStorageInterface $sharedStorage)
    {
    }

    /**
     * @Given /^(this shipping method) has Packeta api key$/
     */
    public function thisPaymentMethodHasZone(ShippingMethodInterface $shippingMethod)
    {
        assert($shippingMethod instanceof PacketaShippingMethodInterface);

        $packetaConfig = new PacketaConfig();
        $packetaConfig->setApiKey('packetaApiKeyFolder');

        $shippingMethod->setPacketaConfig($packetaConfig);

        $this->entityManager->persist($shippingMethod);
        $this->entityManager->flush();
    }

    /**
     * @Given choose Packeta branch ":packetaName"
     */
    public function choosePacketaBranch(string $packetaName)
    {
        $order = $this->sharedStorage->get('order');
        assert($order instanceof OrderInterface);

        $shipment = $order->getShipments()->last();
        assert($shipment instanceof PacketaShipmentInterface);

        $shipment->setPacketa(['id' => 1, 'place' => $packetaName]);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
