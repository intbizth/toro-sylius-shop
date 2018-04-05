<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Model;

use Sylius\Component\Product\Model\ProductOption as BaseProductOption;

class ProductOption extends BaseProductOption
{
    /**
     * @var string
     */
    protected $optionType;

    /**
     * @return string
     */
    public function getOptionType(): ?string
    {
        return $this->optionType;
    }

    /**
     * @param string $optionType
     */
    public function setOptionType(?string $optionType)
    {
        $this->optionType = $optionType;
    }
}
