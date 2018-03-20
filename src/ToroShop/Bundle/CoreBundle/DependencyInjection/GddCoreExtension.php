<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\DependencyInjection;

use ToroShop\Bundle\CoreBundle\GddCoreBundle;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class GddCoreExtension extends AbstractResourceExtension
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

        $this->registerResources(GddCoreBundle::APPLICATION_NAME, $config['driver'], $config['resources'], $container);
    }
}
