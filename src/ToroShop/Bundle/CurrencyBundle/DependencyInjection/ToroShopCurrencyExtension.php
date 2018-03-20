<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use ToroShop\Bundle\CurrencyBundle\CurrencyDataProvider;

class ToroShopCurrencyExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->registerResources('toro', $config['driver'], $config['resources'], $container);

        $def = new Definition(CurrencyDataProvider::class, [$config['currencies']]);
        $def->setPublic(true);
        $container->setDefinition('toro.currency.data_provider', $def);

        $container->setParameter('toro_formatter_config', $config['formatter']);
    }
}
