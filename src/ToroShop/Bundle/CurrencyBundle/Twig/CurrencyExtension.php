<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Twig;

use Symfony\Component\Templating\Helper\Helper;

final class CurrencyExtension extends \Twig_Extension
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
            new \Twig_Filter('toro_currency_name', [$this->helper, 'getCurrencyName']),
        ];
    }
}
