<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Templating\Helper;

use ToroShop\Bundle\CoreBundle\Provider\ProductVariantInventoryProviderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\Templating\Helper\Helper;

final class ProductVariantInventoryHelper extends Helper
{
    /**
     * @var ProductVariantInventoryProviderInterface
     */
    private $inventoryProvider;

    public function __construct(ProductVariantInventoryProviderInterface $inventoryProvider)
    {
        $this->inventoryProvider = $inventoryProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function provideVariantsInventory(ProductInterface $product): array
    {
        return $this->inventoryProvider->provideVariantsInventory($product);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'gdd_product_variants_inventory';
    }
}
