<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Sylius\Component\Core\Model\AddressInterface as BaseAddressInterface;

interface AddressInterface extends BaseAddressInterface
{
    /**
     * @return GeoNameInterface|null
     */
    public function getGeo(): ?GeoNameInterface;

    /**
     * @param GeoNameInterface|null $geo
     */
    public function setGeo(?GeoNameInterface $geo);
}
