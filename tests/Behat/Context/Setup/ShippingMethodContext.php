<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusZasilkovnaPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfig;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;

final class ShippingMethodContext implements Context
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(
        EntityManagerInterface $entityManager,
        SharedStorageInterface $sharedStorage
    ) {
        $this->entityManager = $entityManager;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Given /^(this shipping method) has Zásilkovna api key$/
     */
    public function thisShippingMethodHasZasilkovnaApiKey(ShippingMethodInterface $shippingMethod)
    {
        assert($shippingMethod instanceof ZasilkovnaShippingMethodInterface);

        $zasilkovnaConfig = new ZasilkovnaConfig();
        $zasilkovnaConfig->setApiKey('zasilkovnaApiKeyFolder');

        $shippingMethod->setZasilkovnaConfig($zasilkovnaConfig);

        $this->entityManager->persist($shippingMethod);
        $this->entityManager->flush();
    }

    /**
     * @Given choose Zásilkovna branch ":zasilkovnaName"
     */
    public function chooseZasilkovnaBranch(string $zasilkovnaName)
    {
        $order = $this->sharedStorage->get('order');
        assert($order instanceof OrderInterface);

        $shipment = $order->getShipments()->last();
        assert($shipment instanceof ZasilkovnaShipmentInterface);

        $shipment->setZasilkovna(['id' => 1, 'place' => $zasilkovnaName]);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
