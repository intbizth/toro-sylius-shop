<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Model;

use Sylius\Component\Product\Model\ProductOptionValue as BaseProductOptionValue;

class ProductOptionValue extends BaseProductOptionValue
{
    /**
     * @var array
     */
    protected $typeConfiguration = [];

    /**
     * @return array
     */
    public function getTypeConfiguration(): array
    {
        return $this->typeConfiguration;
    }

    /**
     * @param array $typeConfiguration
     */
    public function setTypeConfiguration(array $typeConfiguration)
    {
        $this->typeConfiguration = $typeConfiguration;
    }
}
