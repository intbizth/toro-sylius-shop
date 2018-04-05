<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Twig;

use Sylius\Component\Registry\ServiceRegistryInterface;

final class ProductOptionServicesExtension extends \Twig_Extension
{
    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * @param ServiceRegistryInterface $registry
     */
    public function __construct(ServiceRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_Function(
                'get_service_all_product_types',
                [$this->registry, 'all']
            ),
            new \Twig_Function(
                'get_service_product_option_type',
                [$this, 'getService']
            ),
        ];
    }

    /**
     * @param $id
     * @return null|object
     */
    public function getService($id)
    {
        if (!$this->registry->has($id)) {
            return null;
        }

        return $this->registry->get($id);
    }
}
