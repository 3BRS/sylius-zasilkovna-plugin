<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Form\Extension;

use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use ThreeBRS\SyliusPacketaPlugin\Form\Type\PacketaConfigType;

class AdminPacketaShippingMethodExtension extends AbstractTypeExtension
{
    /** @param array<mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('packetaConfig', PacketaConfigType::class);
    }

    /** @return array<string> */
    public static function getExtendedTypes(): array
    {
        return [
            ShippingMethodType::class,
        ];
    }
}
