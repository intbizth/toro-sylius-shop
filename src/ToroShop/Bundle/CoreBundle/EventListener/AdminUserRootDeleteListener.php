<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\EventListener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Webmozart\Assert\Assert;

/**
 * Only 'ROLE_ROOT' can delete root admin
 * for update @see \ToroShop\Bundle\CoreBundle\Form\Extension\AdminUserTypeExtension
 */
class AdminUserRootDeleteListener
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    public function canDelete(ResourceControllerEvent $event)
    {
        /** @var AdminUserInterface $adminUser */
        Assert::isInstanceOf($adminUser = $event->getSubject(), AdminUserInterface::class);

        if ($this->checker->isGranted('ROLE_ROOT')) {
            return;
        }

        if (!in_array('ROLE_ROOT', $adminUser->getRoles())) {
            return;
        }

        $event->stop('Cant remove ROOT USER', ResourceControllerEvent::TYPE_ERROR, [], 403);
    }
}
