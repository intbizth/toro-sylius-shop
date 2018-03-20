<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle;

interface CurrencyDataProviderInterface
{
    /**
     * @param string $code
     * @param null|string|null $locale
     *
     * @return string
     */
    public function getCurrencyName(string $code, ?string $locale = null): string;

    /**
     * @param null|string|null $locale
     *
     * @return array
     */
    public function getCurrencyNames(?string $locale = null): array;

    /**
     * @param string $code
     *
     * @return string
     */
    public function getCurrencySymbol(string $code): string;
}
