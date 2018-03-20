<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Sylius\Component\Core\Model\Address as BaseAddress;

class Address extends BaseAddress implements AddressInterface
{
    /**
     * @var GeoNameInterface
     */
    protected $geo;

    /**
     * {@inheritdoc}
     */
    public function getGeo(): ?GeoNameInterface
    {
        return $this->geo;
    }

    /**
     * {@inheritdoc}
     */
    public function setGeo(?GeoNameInterface $geo)
    {
        $this->geo = $geo;
    }
}
