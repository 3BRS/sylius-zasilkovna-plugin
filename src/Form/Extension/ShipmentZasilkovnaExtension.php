<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Form\Extension;

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
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;

class ShipmentZasilkovnaExtension extends AbstractTypeExtension
{
    /** @var string[] */
    private array $zasilkovnaMethodsCodes = [];

    /**
     * @param ShippingMethodRepositoryInterface<ZasilkovnaShippingMethodInterface&ShippingMethodInterface> $shippingMethodRepository
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
            ->add('zasilkovna', HiddenType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, function (
                FormEvent $event,
            ): void {
                $orderData = $event->getData();

                assert(is_array($orderData));
                assert(array_key_exists('zasilkovna', $orderData));
                assert(array_key_exists('method', $orderData));

                $method = $orderData['method'];
                assert(is_string($method));

                $orderData['zasilkovna'] = null;
                if (
                    array_key_exists('zasilkovna_' . $method, $orderData) &&
                    in_array($orderData['method'], $this->zasilkovnaMethodsCodes, true) &&
                    $orderData['zasilkovna_' . $method] !== ''
                ) {
                    $orderData['zasilkovna'] = $orderData['zasilkovna_' . $method];
                }

                $event->setData($orderData);

                // validation
                $data = $event->getData();
                assert(is_array($data));
                assert(array_key_exists('method', $data));
                $method2 = $data['method'];
                assert(is_string($method2));
                if (array_key_exists('zasilkovna_' . $method2, $data) && !((bool) $orderData['zasilkovna_' . $method])) {
                    $event->getForm()->addError(new FormError($this->translator->trans('threebrs.shop.checkout.zasilkovnaBranch', [], 'validators')));
                }
            })
            ->addEventListener(FormEvents::PRE_SET_DATA, function (
                FormEvent $event,
            ) {
                $form = $event->getForm();
                $shipment = $event->getData();
                assert($shipment === null || $shipment instanceof ZasilkovnaShipmentInterface);

                if ($shipment && $this->shippingMethodsResolver->supports($shipment)) {
                    $shippingMethods = $this->shippingMethodsResolver->getSupportedMethods($shipment);
                } else {
                    $shippingMethods = $this->shippingMethodRepository->findAll();
                }

                $selectedMethodCode = $shipment?->getMethod()?->getCode() ?? null;

                foreach ($shippingMethods as $method) {
                    assert($method instanceof ShippingMethodInterface);
                    assert($method instanceof ZasilkovnaShippingMethodInterface);

                    $zasilkovnaConfig = $method->getZasilkovnaConfig();
                    if ($zasilkovnaConfig && $zasilkovnaConfig->getApiKey()) {
                        assert($method->getCode() !== null);
                        $zone = $method->getZone();
                        assert($zone !== null);

                        $data = null;
                        $dataLabel = null;
                        if ($selectedMethodCode !== null && $selectedMethodCode === $method->getCode() && $shipment?->getZasilkovna() !== null) {
                            $data = json_encode($shipment->getZasilkovna());
                            $dataLabel = $this->getZasilkovnaName($shipment->getZasilkovna());
                        }

                        $this->zasilkovnaMethodsCodes[] = $method->getCode();
                        $form
                            ->add('zasilkovna_' . $method->getCode(), HiddenType::class, [
                                'attr' => [
                                    'data-api-key' => $zasilkovnaConfig->getApiKey(),
                                    'data-country' => $zasilkovnaConfig->getOptionCountry(),
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
            ->get('zasilkovna')
            ->addModelTransformer(new CallbackTransformer(
                fn (
                    $zasilkovnaAsArray,
                ) => null,
                function (
                    $zasilkovnaAsString,
                ) {
                    if ($zasilkovnaAsString === null) {
                        return null;
                    }
                    assert(is_string($zasilkovnaAsString));

                    return json_decode($zasilkovnaAsString, true);
                },
            ));
    }

    /**
     * @param array<mixed> $zasilkovna
     */
    private function getZasilkovnaName(array $zasilkovna): string
    {
        $arrayName = [];
        if (array_key_exists('place', $zasilkovna)) {
            $arrayName[] = $zasilkovna['place'];
        }
        if (array_key_exists('nameStreet', $zasilkovna)) {
            $arrayName[] = $zasilkovna['nameStreet'];
        } elseif (array_key_exists('name', $zasilkovna)) {
            $arrayName[] = $zasilkovna['name'];
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
