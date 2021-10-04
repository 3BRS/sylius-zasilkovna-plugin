<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Form\Extension;

use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Form\Type\ZasilkovnaConfigType;

class AdminZasilkovnaShippingMethodExtension extends AbstractTypeExtension
{
    /** @param array<mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('zasilkovnaConfig', ZasilkovnaConfigType::class);
    }

    /** @return array<string> */
    public static function getExtendedTypes(): array
    {
        return [
            ShippingMethodType::class,
        ];
    }
}
