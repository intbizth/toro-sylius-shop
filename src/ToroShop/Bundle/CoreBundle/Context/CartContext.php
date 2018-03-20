<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Context;

use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Model\OrderInterface;

/**
 * We don't want clone default ShippingAddress in order
 *
 * @see \Sylius\Component\Core\Cart\Context\ShopBasedCartContext::setCustomerAndAddressOnCart
 */
final class CartContext implements CartContextInterface
{
    /**
     * @var CartContextInterface
     */
    private $cartContext;

    /**
     * @var OrderInterface|null
     */
    private $cart;

    /**
     * @param CartContextInterface $cartContext
     */
    public function __construct(CartContextInterface $cartContext)
    {
        $this->cartContext = $cartContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getCart(): OrderInterface
    {
        if (null !== $this->cart) {
            return $this->cart;
        }

        /** @var \Sylius\Component\Core\Model\OrderInterface $cart */
        $cart = $this->cartContext->getCart();

        if ($cart->getShippingAddress()) {
            $cart->setShippingAddress(null);
        }

        $this->cart = $cart;

        return $cart;
    }
}
