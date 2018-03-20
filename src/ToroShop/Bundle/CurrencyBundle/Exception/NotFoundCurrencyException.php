<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Exception;

final class NotFoundCurrencyException extends \RuntimeException
{
    public function __construct(string $currencyCode)
    {
        parent::__construct(sprintf('Currency %s could not be found!', $currencyCode));
    }
}
