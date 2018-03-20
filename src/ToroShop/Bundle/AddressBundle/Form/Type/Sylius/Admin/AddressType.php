<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Admin;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use ToroShop\Bundle\AddressBundle\Form\Type\Sylius\GeoAutocompleteType;
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
                'required' => in_array('phone_number', $this->validationGroups),
                'label' => 'sylius.form.address.phone_number',
            ])
            ->add('street', TextType::class, [
                'label' => 'sylius.form.address.street',
            ])
            ->add('geo', GeoAutocompleteType::class, $geoOptions = [
                'type' => GeoNameInterface::TYPE_PARISH,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_address';
    }
}
