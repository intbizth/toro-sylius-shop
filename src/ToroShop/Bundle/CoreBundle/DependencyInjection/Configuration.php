<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('toro_shop_core');

        $rootNode
            ->children()
            ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->arrayNode('resources')->addDefaultsIfNotSet()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
