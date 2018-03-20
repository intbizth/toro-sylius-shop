<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class GddCoreBundle extends AbstractResourceBundle
{
    const APPLICATION_NAME = 'gdd';

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
        return 'ToroShop\CoreBundle\Model';
    }
}
