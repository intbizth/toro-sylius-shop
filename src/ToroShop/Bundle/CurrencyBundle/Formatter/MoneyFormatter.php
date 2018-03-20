<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Formatter;

use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatterInterface;
use Symfony\Component\Intl\Intl;
use ToroShop\Bundle\CurrencyBundle\CurrencyDataProviderInterface;

final class MoneyFormatter implements MoneyFormatterInterface
{
    /**
     * @var MoneyFormatterInterface
     */
    private $decorateMoneyFormatter;

    /**
     * @var CurrencyDataProviderInterface
     */
    private $dataProvider;

    /**
     * @var array
     */
    private $formatterConfig = [];

    public function __construct(MoneyFormatterInterface $decorateMoneyFormatter, CurrencyDataProviderInterface $dataProvider, array $formatterConfig)
    {
        $this->decorateMoneyFormatter = $decorateMoneyFormatter;
        $this->dataProvider = $dataProvider;
        $this->formatterConfig = $formatterConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function format(int $amount, string $currency, ?string $locale = null): string
    {
        $moneyFormatResult = $this->decorateMoneyFormatter->format($amount, $currency, $locale);

        if (true === $this->formatterConfig['use_symbol']) {
            $result = number_format(abs($amount / 100), 2);
            $symbol = Intl::getCurrencyBundle()->getCurrencySymbol($currency) ?: $this->dataProvider->getCurrencySymbol($currency);
            $result .= ' ' . $symbol;

            $moneyFormatResult = $amount >= 0 ? $result : '-' . $result;
        }

        if (false === $this->formatterConfig['zero_decimal_aware']) {
            $moneyFormatResult = str_replace('.00', '', $moneyFormatResult);
        }

        return $moneyFormatResult;
    }
}
