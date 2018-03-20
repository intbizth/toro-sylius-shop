<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Templating\Helper;

use Sylius\Bundle\CurrencyBundle\Templating\Helper\CurrencyHelperInterface as SyliusCurrencyHelperInterface;

interface CurrencyHelperInterface extends SyliusCurrencyHelperInterface
{
    /**
     * @param string $code
     *
     * @return string
     */
    public function getCurrencyName(string $code): string;
}
