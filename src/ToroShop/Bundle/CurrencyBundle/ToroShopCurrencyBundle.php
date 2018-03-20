<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class ToroShopCurrencyBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace(): string
    {
        return 'ToroShop\Bundle\CurrencyBundle\Model';
    }
}
