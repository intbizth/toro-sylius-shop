<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface CountryInterface extends ToggleableInterface, ResourceInterface, CodeAwareInterface
{
    /**
     * @param string|null $locale
     *
     * @return string|null
     */
    public function getName($locale = null);

    /**
     * @return Collection|GeoNameInterface[]
     */
    public function getProvinces();

    /**
     * @return bool
     */
    public function hasProvinces();

    /**
     * @param GeoNameInterface $province
     */
    public function addProvince(GeoNameInterface $province);

    /**
     * @param GeoNameInterface $province
     */
    public function removeProvince(GeoNameInterface $province);

    /**
     * @param GeoNameInterface $province
     *
     * @return bool
     */
    public function hasProvince(GeoNameInterface $province);
}
