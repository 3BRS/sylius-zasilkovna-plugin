<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ZasilkovnaConfigType extends AbstractResourceType
{
    /**
     * @param array<string> $countryChoices
     * @param array<string> $validationGroups
     */
    public function __construct(
        private readonly array $countryChoices,
        string $dataClass,
        array $validationGroups = [],
    ) {
        parent::__construct($dataClass, $validationGroups);
    }

    /** @param array<mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apiKey', TextType::class, [
                'label' => 'threebrs.admin.zasilkovna.form.apiKey',
                'required' => false,
            ])
            ->add('optionCountry', ChoiceType::class, [
                'label' => 'threebrs.admin.zasilkovna.form.optionCountry',
                'required' => false,
                'choices' => array_combine($this->countryChoices, $this->countryChoices),
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('senderLabel', TextType::class, [
                'label' => 'threebrs.admin.zasilkovna.form.senderLabel',
                'required' => false,
            ])
            ->add('carrierId', TextType::class, [
                'label' => 'threebrs.admin.zasilkovna.form.carrierId',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'threebrs_zasilkovna_plugin';
    }
}
