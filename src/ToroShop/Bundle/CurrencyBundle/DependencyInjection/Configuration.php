<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('toro_shop_currency');

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                ->arrayNode('resources')->addDefaultsIfNotSet()->end()
                ->arrayNode('formatter')
                    ->children()
                        ->scalarNode('use_symbol')->defaultTrue()->end()
                        ->scalarNode('zero_decimal_aware')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('currencies')
                    ->useAttributeAsKey('code')
                    ->arrayPrototype()
                        ->children()
                            ->arrayNode('name')
                                ->useAttributeAsKey('locale_code')
                                ->scalarPrototype()->end()
                            ->end()
                            ->scalarNode('symbol')->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
