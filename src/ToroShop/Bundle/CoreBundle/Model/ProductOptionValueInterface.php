<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Model;

use Sylius\Component\Product\Model\ProductOptionValueInterface as BaseProductOptionValueInterface;

interface ProductOptionValueInterface extends BaseProductOptionValueInterface
{
    /**
     * @return array
     */
    public function getTypeConfiguration(): array;

    /**
     * @param array $typeConfiguration
     */
    public function setTypeConfiguration(array $typeConfiguration);
}
