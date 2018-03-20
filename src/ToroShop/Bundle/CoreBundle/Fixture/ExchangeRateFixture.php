<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ExchangeRateFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'toro_exchange_rate';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->scalarNode('source')->cannotBeEmpty()->end()
                ->scalarNode('target')->cannotBeEmpty()->end()
                ->floatNode('ratio')->end()
            ->end()
        ;
    }
}
