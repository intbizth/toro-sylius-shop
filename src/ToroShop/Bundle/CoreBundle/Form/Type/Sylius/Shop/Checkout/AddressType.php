<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Type\Sylius\Shop\Checkout;

use ToroShop\Bundle\CoreBundle\Form\Type\Sylius\Shop\AddressBookChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class AddressType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shippingAddress', AddressBookChoiceType::class, [
                'required' => true,
                'label' => 'Shipping address',
                'constraints' => [new NotBlank([
                    'groups' => $options['validation_groups'],
                ])],
                'customer' => $options['customer'],
            ])
            ->add('billingAddress', AddressBookChoiceType::class, [
                'required' => true,
                'label' => 'Billing address',
                'constraints' => [new NotBlank([
                    'groups' => $options['validation_groups'],
                ])],
                'customer' => $options['customer'],
            ])
            ->add('differentBillingAddress', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'sylius.form.checkout.addressing.different_billing_address',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options): void {
                /** @var OrderInterface $orderData */
                $orderData = $event->getData();

                /** @var CustomerInterface $customer */
                $customer = $options['customer'];

                if ($orderData->getShippingAddress()) {
                    return;
                }

                if (!$defaultAddress = $customer->getDefaultAddress()) {
                    return;
                }

                $orderData->setShippingAddress($defaultAddress);
                $orderData->setBillingAddress($defaultAddress);

                $event->setData($orderData);
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
                $orderData = $event->getData();

                if (isset($orderData['shippingAddress']) && (!isset($orderData['differentBillingAddress']) || false === $orderData['differentBillingAddress'])) {
                    $orderData['billingAddress'] = $orderData['shippingAddress'];

                    $event->setData($orderData);
                }
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setRequired('customer');
        $resolver->addAllowedTypes('customer', CustomerInterface::class);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'toro_checkout_address';
    }
}
