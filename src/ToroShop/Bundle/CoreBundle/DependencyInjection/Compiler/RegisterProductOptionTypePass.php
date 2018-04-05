<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterProductOptionTypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('toro.registry.product_option_type') || !$container->hasDefinition('toro.form_registry.product_option_type')) {
            return;
        }

        $registry = $container->getDefinition('toro.registry.product_option_type');
        $formTypeRegistry = $container->getDefinition('toro.form_registry.product_option_type');

        foreach ($container->findTaggedServiceIds('toro.product_option_type') as $id => $attributes) {
            if (!isset($attributes[0]['type'], $attributes[0]['form_type'])) {
                throw new \InvalidArgumentException('Tagged grid filters needs to have `type` and `form_type` attributes.');
            }

            $registry->addMethodCall('register', [$attributes[0]['type'], new Reference($id)]);
            $formTypeRegistry->addMethodCall('add', [$attributes[0]['type'], 'default', $attributes[0]['form_type']]);
        }
    }
}
