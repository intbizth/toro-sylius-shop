<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Calculator;

use Sylius\Component\Core\Exception\MissingChannelConfigurationException;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Webmozart\Assert\Assert;

final class ProductVariantOriginalPriceCalculator implements ProductVariantOriginalPriceCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function calculate(ProductVariantInterface $productVariant, array $context): ?int
    {
        Assert::keyExists($context, 'channel');

        $channelPricing = $productVariant->getChannelPricingForChannel($context['channel']);

        if (null === $channelPricing) {
            throw new MissingChannelConfigurationException(sprintf(
                'Channel %s has no price defined for product variant %s',
                $context['channel']->getName(),
                $productVariant->getName()
            ));
        }

        return $channelPricing->getOriginalPrice();
    }
}
