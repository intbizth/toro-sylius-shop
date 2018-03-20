<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface GeoNameTranslationInterface extends ResourceInterface
{
    public function __toString();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getAbbreviation();

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation($abbreviation);

    /**
     * @return string
     */
    public function getGeoName();

    /**
     * @param string $geoName
     */
    public function setGeoName($geoName);

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @param string $slug
     */
    public function setSlug($slug);
}
