<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Provider;

use Sylius\Component\Core\Model\ProductInterface;

interface ProductVariantInventoryProviderInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function provideVariantsInventory(ProductInterface $product): array;
}
