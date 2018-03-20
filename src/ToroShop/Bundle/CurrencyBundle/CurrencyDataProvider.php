<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle;

use Symfony\Component\Intl\Locale;
use ToroShop\Bundle\CurrencyBundle\Exception\NotFoundCurrencyException;

final class CurrencyDataProvider implements CurrencyDataProviderInterface
{
    /**
     * @var array|null
     */
    private $data = [];

    public function __construct(?array $data = null)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencyName(string $code, ?string $locale = null): string
    {
        $locale = $locale ?: Locale::getDefault();
        $code = strtoupper($code);

        if (!isset($this->data[$code]['name'])) {
            throw new NotFoundCurrencyException($code);
        }

        return $this->data[$code]['name'][$locale] ?? current($this->data[$code]['name']);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencyNames(?string $locale = null): array
    {
        $locale = $locale ?: Locale::getDefault();

        $results = [];
        foreach ($this->data as $code => $value) {
            $results[$code] = $value['name'][$locale] ?? current($value['name']);
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencySymbol(string $code): string
    {
        if (!isset($this->data[$code])) {
            throw new NotFoundCurrencyException($code);
        }

        return $this->data[$code]['symbol'];
    }
}
