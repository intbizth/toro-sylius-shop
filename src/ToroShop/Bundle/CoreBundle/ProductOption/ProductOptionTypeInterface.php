<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\ProductOption;

interface ProductOptionTypeInterface
{
    /**
     * Label key of translation
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Template for render in shop
     *
     * @return string
     */
    public function getTemplate(): string;
}
