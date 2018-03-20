<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Shop\Checkout;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;
use ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Shop\AddressType as ToroAddressType;

final class AddressType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shippingAddress', ToroAddressType::class, [
                'phone_number_required' => in_array('phone_number', $options['validation_groups']),
                'constraints' => [new Valid([
                    'groups' => $options['validation_groups']
                ])],
            ])
            ->add('billingAddress', ToroAddressType::class, [
                'phone_number_required' => in_array('phone_number', $options['validation_groups']),
                'constraints' => [new Valid([
                    'groups' => $options['validation_groups']
                ])],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return \Sylius\Bundle\CoreBundle\Form\Type\Checkout\AddressType::class;
    }
}
