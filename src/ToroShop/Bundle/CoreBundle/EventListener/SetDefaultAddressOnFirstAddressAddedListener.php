<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\CustomerInterface;
use ToroShop\Bundle\AddressBundle\Model\AddressInterface;

class SetDefaultAddressOnFirstAddressAddedListener
{
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param ResourceControllerEvent $event
     */
    public function setDefault(ResourceControllerEvent $event)
    {
        $address = $event->getSubject();

        if (!$address instanceof AddressInterface) {
            return;
        }

        if (null === $customer = $address->getCustomer()) {
            return;
        }

        /** @var $customer CustomerInterface */
        if ($customer->getDefaultAddress()) {
            return;
        }

        $customer->setDefaultAddress($address);
        $this->manager->flush();
    }
}
