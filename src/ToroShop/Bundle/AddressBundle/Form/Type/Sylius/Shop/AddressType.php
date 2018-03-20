<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Shop;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Form\EventSubscriber\ChoiceResizeListener;
use ToroShop\Bundle\AddressBundle\Form\Type\GeoAjaxSelectizeChoiceType;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class AddressType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'sylius.form.address.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'sylius.form.address.last_name',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => null !== $options['phone_number_required'] ? $options['phone_number_required'] : in_array('phone_number', $options['validation_groups']),
                'label' => 'sylius.form.address.phone_number',
            ])
            ->add('street', TextType::class, [
                'label' => 'sylius.form.address.street',
            ])
            ->add('geo', GeoAjaxSelectizeChoiceType::class, $geoOptions = [
                'type' => GeoNameInterface::TYPE_PARISH,
                'label' => 'sylius.form.address.geo',
            ])
        ;

        ChoiceResizeListener::create($builder, [
            'geo' => [
                'entry_type' => GeoAjaxSelectizeChoiceType::class,
                'options' => $geoOptions,
                'query_builder' => 'o.id',
            ],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'phone_number_required' => null,
        ]);

        $resolver->addAllowedTypes('phone_number_required', ['boolean', 'null']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_address';
    }
}
