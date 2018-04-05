<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Provider;

use Sylius\Component\Locale\Provider\LocaleProviderInterface as SyliusLocaleProviderInterface;
use Toro\SeoBundle\Provider\LocaleProviderInterface;

final class SyliusLocaleProvider implements LocaleProviderInterface
{
    /**
     * @var SyliusLocaleProviderInterface
     */
    private $localeProvider;

    public function __construct(SyliusLocaleProviderInterface $localeProvider)
    {
        $this->localeProvider = $localeProvider;
    }

    public function getAvailableLocalesCodes(): array
    {
        return $this->localeProvider->getAvailableLocalesCodes();
    }

    public function getDefaultLocaleCode(): string
    {
        return $this->localeProvider->getDefaultLocaleCode();
    }
}
