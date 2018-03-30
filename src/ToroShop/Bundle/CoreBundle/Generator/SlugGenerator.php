<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Generator;

use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use ToroShop\Bundle\CoreBundle\Slug\URLify;

final class SlugGenerator implements SlugGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate(string $name): string
    {
        return URLify::slug($name);
    }
}
