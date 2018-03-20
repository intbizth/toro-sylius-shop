<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Calculator;

use Sylius\Component\Core\Exception\MissingChannelConfigurationException;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface ProductVariantOriginalPriceCalculatorInterface
{
    /**
     * @param ProductVariantInterface $productVariant
     * @param array $context
     *
     * @return int|null
     *
     * @throws MissingChannelConfigurationException when price for given channel does not exist
     */
    public function calculate(ProductVariantInterface $productVariant, array $context): ?int;
}
