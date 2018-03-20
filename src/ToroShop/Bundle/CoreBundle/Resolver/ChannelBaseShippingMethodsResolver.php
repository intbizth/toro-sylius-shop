<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Resolver;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Shipping\Model\ShippingSubjectInterface;
use Sylius\Component\Shipping\Resolver\ShippingMethodsResolverInterface;
use Webmozart\Assert\Assert;

class ChannelBaseShippingMethodsResolver implements ShippingMethodsResolverInterface
{
    /**
     * @var ShippingMethodRepositoryInterface
     */
    private $shippingMethodRepository;

    /**
     * @param ShippingMethodRepositoryInterface $shippingMethodRepository
     */
    public function __construct(
        ShippingMethodRepositoryInterface $shippingMethodRepository
    ) {
        $this->shippingMethodRepository = $shippingMethodRepository;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function getSupportedMethods(ShippingSubjectInterface $subject): array
    {
        /** @var ShipmentInterface $subject */
        Assert::true($this->supports($subject));
        /** @var OrderInterface $order */
        $order = $subject->getOrder();

        $methods = [];

        $shippingMethods = $this->shippingMethodRepository->findEnabledForChannel($order->getChannel());
        foreach ($shippingMethods as $shippingMethod) {
            $methods[] = $shippingMethod;
        }

        return $methods;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ShippingSubjectInterface $subject): bool
    {
        return $subject instanceof ShipmentInterface &&
            null !== $subject->getOrder() &&
            null !== $subject->getOrder()->getShippingAddress() &&
            null !== $subject->getOrder()->getChannel()
            ;
    }
}
