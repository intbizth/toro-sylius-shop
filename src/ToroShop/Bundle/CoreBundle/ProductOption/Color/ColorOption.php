<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\ProductOption\Color;

use ToroShop\Bundle\CoreBundle\ProductOption\ProductOptionTypeInterface;

final class ColorOption implements ProductOptionTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLabel(): string
    {
        return 'Color options';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): string
    {
        return '@ToroShopCore/ProductOption/Type/_color.html.twig';
    }
}
