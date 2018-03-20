<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Admin\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Form\Type\Sylius\GeoAutocompleteType;
use ToroShop\Bundle\AddressBundle\Grid\Filter\GeoTreeFilter;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class GeoFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!isset($options['type'])) {
            $builder
                ->add('type', ChoiceType::class, [
                    'choices' => [
                        'sylius.ui.contains' => GeoTreeFilter::TYPE_CHILD_INCLUDE,
                    ],
                ])
            ;
        }

        $builder
            ->add('value', GeoAutocompleteType::class, [
                'type' => $options['geo_type'] ?? GeoNameInterface::TYPE_PROVINCE,
                'multiple' => $options['multiple'] ?? true,
                'required' => false,
                'label' => 'sylius.ui.value',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
            ])
            ->setDefined('type')
            ->setAllowedValues('type', [
                GeoTreeFilter::TYPE_CHILD_INCLUDE,
            ])
            ->setDefined('geo_type')
            ->setAllowedValues('geo_type', [
                GeoNameInterface::TYPE_DISTRICT,
                GeoNameInterface::TYPE_PROVINCE,
                GeoNameInterface::TYPE_PARISH,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_grid_filter_string';
    }
}
