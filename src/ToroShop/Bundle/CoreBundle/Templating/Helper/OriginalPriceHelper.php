<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Templating\Helper;

use ToroShop\Bundle\CoreBundle\Calculator\ProductVariantOriginalPriceCalculator;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Symfony\Component\Templating\Helper\Helper;
use Webmozart\Assert\Assert;

class OriginalPriceHelper extends Helper
{
    /**
     * @var ProductVariantOriginalPriceCalculator
     */
    private $productVariantPriceCalculator;

    /**
     * @param ProductVariantOriginalPriceCalculator $productVariantPriceCalculator
     */
    public function __construct(ProductVariantOriginalPriceCalculator $productVariantPriceCalculator)
    {
        $this->productVariantPriceCalculator = $productVariantPriceCalculator;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function getOriginalPrice(ProductVariantInterface $productVariant, array $context): ?int
    {
        Assert::keyExists($context, 'channel');

        return $this
            ->productVariantPriceCalculator
            ->calculate($productVariant, $context)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'sylius_calculate_original_price';
    }
}
