<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CmsBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class ToroShopCmsBundle extends AbstractResourceBundle
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
        return 'ToroShop\Bundle\CmsBundle\Model';
    }
}
