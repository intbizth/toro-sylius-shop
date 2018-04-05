<?php

namespace ToroShop\Bundle\UiBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('toro_shop_ui');

        $this->addTransitionConfig($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addTransitionConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('state_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('colors')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('negative')->defaultValue('negative')->cannotBeEmpty()->end()
                                ->scalarNode('positive')->defaultValue('positive')->cannotBeEmpty()->end()
                                ->scalarNode('na')->defaultValue('na')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('icon')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('info')->defaultValue('info-circle')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('graphs')
                            ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->arrayNode('states')
                                            ->useAttributeAsKey('name')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('color')->end()
                                                    ->scalarNode('icon')->end()
                                                    ->arrayNode('translation')
                                                        ->children()
                                                            ->scalarNode('key')->end()
                                                            ->scalarNode('domain')->defaultValue('transitions')->cannotBeEmpty()->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->arrayNode('transitions')
                                            ->useAttributeAsKey('name')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('color')->end()
                                                    ->arrayNode('translation')
                                                        ->children()
                                                            ->scalarNode('key')->end()
                                                            ->scalarNode('domain')->defaultValue('transitions')->cannotBeEmpty()->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
