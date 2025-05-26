<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ShipmentType;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Shipping\Resolver\ShippingMethodsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Contracts\Translation\TranslatorInterface;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShipmentInterface;
use ThreeBRS\SyliusPacketaPlugin\Model\PacketaShippingMethodInterface;

class ShipmentPacketaExtension extends AbstractTypeExtension
{
    /** @var string[] */
    private array $packetaMethodsCodes = [];

    /**
     * @param ShippingMethodRepositoryInterface<PacketaShippingMethodInterface&ShippingMethodInterface> $shippingMethodRepository
     */
    public function __construct(
        private readonly ShippingMethodsResolverInterface $shippingMethodsResolver,
        private readonly ShippingMethodRepositoryInterface $shippingMethodRepository,
        private readonly TranslatorInterface $translator,
    ) {
    }

    /** @param array<mixed> $options */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('packeta', HiddenType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, function (
                FormEvent $event,
            ): void {
                $orderData = $event->getData();

                assert(is_array($orderData));
                assert(array_key_exists('packeta', $orderData));
                assert(array_key_exists('method', $orderData));

                $method = $orderData['method'];
                assert(is_string($method));

                $orderData['packeta'] = null;
                if (
                    array_key_exists('packeta_' . $method, $orderData) &&
                    in_array($orderData['method'], $this->packetaMethodsCodes, true) &&
                    $orderData['packeta_' . $method] !== ''
                ) {
                    $orderData['packeta'] = $orderData['packeta_' . $method];
                }

                $event->setData($orderData);

                // validation
                if (array_key_exists('packeta_' . $method, $orderData) && $orderData['packeta'] === null) {
                    $event->getForm()->addError(new FormError($this->translator->trans('threebrs.shop.checkout.packetaBranch', [], 'validators')));
                }
            })
            ->addEventListener(FormEvents::PRE_SET_DATA, function (
                FormEvent $event,
            ) {
                $form = $event->getForm();
                $shipment = $event->getData();
                assert($shipment === null || $shipment instanceof PacketaShipmentInterface);

                if ($shipment && $this->shippingMethodsResolver->supports($shipment)) {
                    $shippingMethods = $this->shippingMethodsResolver->getSupportedMethods($shipment);
                } else {
                    $shippingMethods = $this->shippingMethodRepository->findAll();
                }

                $selectedMethodCode = $shipment?->getMethod()?->getCode() ?? null;

                foreach ($shippingMethods as $method) {
                    assert($method instanceof ShippingMethodInterface);
                    assert($method instanceof PacketaShippingMethodInterface);

                    $packetaConfig = $method->getPacketaConfig();
                    if ($packetaConfig && $packetaConfig->getApiKey()) {
                        assert($method->getCode() !== null);
                        $zone = $method->getZone();
                        assert($zone !== null);

                        $data = null;
                        $dataLabel = null;
                        if ($selectedMethodCode !== null && $selectedMethodCode === $method->getCode() && $shipment?->getPacketa() !== null) {
                            $data = json_encode($shipment->getPacketa());
                            $dataLabel = $this->getPacketaName($shipment->getPacketa());
                        }

                        $this->packetaMethodsCodes[] = $method->getCode();
                        $form
                            ->add('packeta_' . $method->getCode(), HiddenType::class, [
                                'attr' => [
                                    'data-api-key' => $packetaConfig->getApiKey(),
                                    'data-country' => $packetaConfig->getOptionCountry(),
                                    'data-label' => $dataLabel,
                                ],
                                'data' => $data,
                                'required' => false,
                                'mapped' => false,
                                'empty_data' => null,
                            ]);
                    }
                }
            });

        $builder
            ->get('packeta')
            ->addModelTransformer(new CallbackTransformer(
                fn (
                    $packetaAsArray,
                ) => null,
                function (
                    $packetaAsString,
                ) {
                    if ($packetaAsString === null) {
                        return null;
                    }
                    assert(is_string($packetaAsString));

                    return json_decode($packetaAsString, true);
                },
            ));
    }

    /**
     * @param array<mixed> $packeta
     */
    private function getPacketaName(array $packeta): string
    {
        $arrayName = [];
        if (array_key_exists('place', $packeta)) {
            $arrayName[] = $packeta['place'];
        }
        if (array_key_exists('nameStreet', $packeta)) {
            $arrayName[] = $packeta['nameStreet'];
        } elseif (array_key_exists('name', $packeta)) {
            $arrayName[] = $packeta['name'];
        }

        return implode(', ', $arrayName);
    }

    /** @return array<string> */
    public static function getExtendedTypes(): array
    {
        return [
            ShipmentType::class,
        ];
    }
}
