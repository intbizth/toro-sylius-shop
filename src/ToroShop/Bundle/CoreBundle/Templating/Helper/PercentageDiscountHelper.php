<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Templating\Helper;

use ToroShop\Bundle\CoreBundle\Calculator\ProductVariantOriginalPriceCalculator;
use Sylius\Component\Core\Calculator\ProductVariantPriceCalculator;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Symfony\Component\Templating\Helper\Helper;
use Webmozart\Assert\Assert;

class PercentageDiscountHelper extends Helper
{
    /**
     * @var ProductVariantOriginalPriceCalculator
     */
    private $productVariantOriginalPriceCalculator;

    /**
     * @var ProductVariantPriceCalculator
     */
    private $productVariantPriceCalculator;

    /**
     * @param ProductVariantOriginalPriceCalculator $productVariantOriginalPriceCalculator
     * @param ProductVariantPriceCalculator $productVariantPriceCalculator
     */
    public function __construct(
        ProductVariantOriginalPriceCalculator $productVariantOriginalPriceCalculator,
        ProductVariantPriceCalculator $productVariantPriceCalculator
    ) {
        $this->productVariantOriginalPriceCalculator = $productVariantOriginalPriceCalculator;
        $this->productVariantPriceCalculator = $productVariantPriceCalculator;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function getPercentageDiscount(ProductVariantInterface $productVariant, array $context): ?int
    {
        Assert::keyExists($context, 'channel');

        $originalPrice = $this
            ->productVariantOriginalPriceCalculator
            ->calculate($productVariant, $context);

        if (null === $originalPrice) {
            return null;
        }

        $price = $this
            ->productVariantPriceCalculator
            ->calculate($productVariant, $context);

        return (int) (100 - round(($price / $originalPrice) * 100));
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'sylius_calculate_percentage_discount';
    }
}
