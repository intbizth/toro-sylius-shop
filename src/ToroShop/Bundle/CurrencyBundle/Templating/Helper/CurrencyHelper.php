<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Templating\Helper;

use Symfony\Component\Intl\Intl;
use Symfony\Component\Templating\Helper\Helper;
use ToroShop\Bundle\CurrencyBundle\CurrencyDataProviderInterface;

final class CurrencyHelper extends Helper implements CurrencyHelperInterface
{
    /**
     * @var CurrencyDataProviderInterface
     */
    private $dataProvider;

    public function __construct(CurrencyDataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencyName(string $code): string
    {
        return Intl::getCurrencyBundle()->getCurrencyName($code) ?: $this->dataProvider->getCurrencyName($code);
    }

    /**
     * {@inheritdoc}
     */
    public function convertCurrencyCodeToSymbol(string $code): string
    {
        return Intl::getCurrencyBundle()->getCurrencySymbol($code) ?: $this->dataProvider->getCurrencySymbol($code);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'toro_currency';
    }
}
