<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Twig;

use Symfony\Component\Templating\Helper\Helper;

final class PercentageDiscountExtension extends \Twig_Extension
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
    public function getFilters(): array
    {
        return [
            new \Twig_Filter('sylius_calculate_percentage_discount', [$this->helper, 'getPercentageDiscount']),
        ];
    }
}
