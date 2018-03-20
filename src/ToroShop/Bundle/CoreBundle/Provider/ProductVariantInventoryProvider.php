<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Provider;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class ProductVariantInventoryProvider implements ProductVariantInventoryProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function provideVariantsInventory(ProductInterface $product): array
    {
        $variantsInventories = [];

        /** @var ProductVariantInterface $variant */
        foreach ($product->getVariants() as $variant) {
            if (!$variant->isTracked()) {
                continue;
            }

            $variantsInventories[] = $this->constructOptionsMap($variant);
        }

        return $variantsInventories;
    }

    /**
     * @param ProductVariantInterface $variant
     *
     * @return array
     */
    private function constructOptionsMap(ProductVariantInterface $variant): array
    {
        $optionMap = [];

        /** @var ProductOptionValueInterface $option */
        foreach ($variant->getOptionValues() as $option) {
            $optionMap[$option->getOptionCode()] = $option->getCode();
        }

        $optionMap['onHand'] = $variant->getOnHand();

        return $optionMap;
    }
}
