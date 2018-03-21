<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\DependencyInjection;

use ToroShop\Bundle\CoreBundle\GddCoreBundle;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class ToroShopCoreExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $xmlLoader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $xmlLoader->load('services.xml');

        if (false === $config['guest_checkout']) {
            $xmlLoader->load('not_allow_guest_checkout.xml');
        }

        $this->registerResources('toro_shop_core', $config['driver'], $config['resources'], $container);
    }
}
