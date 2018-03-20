<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\EventListener;

use Knp\Menu\MenuItem;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AdminMenuListener
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    public function checkGrant(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        foreach ($menu->getChildren() as $group) {
            // Add geo menu
            if ('configuration' === $group->getName()) {
                $group->addChild('geo', [
                    'route' => 'toro_admin_geo_index',
                    'label' => 'toro.ui.geo_names',
                ]);
            }

            $group->setChildren(array_filter($group->getChildren(), function (MenuItem $item) {
                if (preg_match('/^(.+)\/root\/(.+)$/', $item->getUri())) {
                    return $this->checker->isGranted('ROLE_ROOT');
                }

                if (preg_match('/^(.+)\/super\/(.+)$/', $item->getUri())) {
                    return $this->checker->isGranted('ROLE_SUPER');
                }

                return true;
            }));

            // Remove when no children
            if (0 === count($group->getChildren())) {
                $menu->removeChild($group->getName());
            }
        }
    }
}
