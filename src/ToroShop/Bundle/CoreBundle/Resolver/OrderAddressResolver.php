<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Resolver;

use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderAddressResolver
{
    /**
     * @param OrderInterface $order
     */
    public function resolve(OrderInterface $order): void
    {
        $order->setShippingAddress($this->cloneAddressWithoutCustomer($order->getShippingAddress()));
        $order->setBillingAddress($this->cloneAddressWithoutCustomer($order->getBillingAddress()));
    }

    /**
     * @param AddressInterface $address
     *
     * @return AddressInterface
     */
    private function cloneAddressWithoutCustomer(AddressInterface $address): AddressInterface
    {
        $newAddress = clone $address;
        $newAddress->setCustomer(null);

        return $newAddress;
    }
}
