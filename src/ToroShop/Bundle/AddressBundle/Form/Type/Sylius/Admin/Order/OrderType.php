<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Admin\Order;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use ToroShop\Bundle\AddressBundle\Form\Type\Sylius\Admin\AddressType as AdminAddressType;

final class OrderType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shippingAddress', AdminAddressType::class)
            ->add('billingAddress', AdminAddressType::class)
        ;
    }
}
