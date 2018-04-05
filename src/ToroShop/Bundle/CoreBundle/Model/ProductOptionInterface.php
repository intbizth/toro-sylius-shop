<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Model;

use Sylius\Component\Product\Model\ProductOptionInterface as BaseProductOptionInterface;

interface ProductOptionInterface extends BaseProductOptionInterface
{
    /**
     * @return string
     */
    public function getOptionType(): ?string;

    /**
     * @param string $optionType
     */
    public function setOptionType(?string $optionType);
}
