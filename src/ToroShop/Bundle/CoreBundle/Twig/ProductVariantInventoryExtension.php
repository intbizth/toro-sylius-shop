<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Twig;

use Symfony\Component\Templating\Helper\Helper;

final class ProductVariantInventoryExtension extends \Twig_Extension
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_Function('gdd_product_variants_inventory', [$this->helper, 'provideVariantsInventory']),
        ];
    }
}
