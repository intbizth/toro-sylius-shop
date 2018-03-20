<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\AdminUserFixture as BaseAdminUserFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class AdminUserFixture extends BaseAdminUserFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'toro_admin_user';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        parent::configureResourceNode($resourceNode);

        $resourceNode
            ->children()
            ->arrayNode('roles')->defaultValue([])
                ->scalarPrototype()->end()
            ->end()
        ;
    }
}
