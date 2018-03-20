<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\Factory\AdminUserExampleFactory as BaseAdminUserExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserExampleFactory extends BaseAdminUserExampleFactory implements ExampleFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): AdminUserInterface
    {
        $user = parent::create($options);

        foreach ($options['roles'] as $role) {
            $user->addRole($role);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefined('roles')
        ;
    }
}
