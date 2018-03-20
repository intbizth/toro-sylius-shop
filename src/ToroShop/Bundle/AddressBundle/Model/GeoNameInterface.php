<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface GeoNameInterface extends CodeAwareInterface, GeoNameTranslationInterface, TranslatableInterface
{
    const TYPE_PROVINCE = 1;
    const TYPE_DISTRICT = 2;
    const TYPE_PARISH = 3;

    /**
     * @return int
     */
    public function getPostcode();

    /**
     * @param int $postcode
     */
    public function setPostcode($postcode);

    /**
     * @return int
     */
    public function getType();

    /**
     * @param int $type
     */
    public function setType($type);

    /**
     * @return CountryInterface
     */
    public function getCountry();

    /**
     * @param CountryInterface $country
     */
    public function setCountry(CountryInterface $country = null);

    /**
     * @return bool
     */
    public function isProvince();

    /**
     * @return bool
     */
    public function isDistrict();

    /**
     * @return bool
     */
    public function isParish();

    /**
     * @return bool
     */
    public function isRoot();

    /**
     * @return GeoNameInterface
     */
    public function getRoot();

    /**
     * @return GeoNameInterface
     */
    public function getParent();

    /**
     * @param GeoNameInterface|null $parent
     */
    public function setParent(?self $parent = null);

    /**
     * @return GeoNameInterface[]
     */
    public function getParents();

    /**
     * @return Collection|GeoNameInterface[]
     */
    public function getChildren();

    /**
     * @param GeoNameInterface $child
     *
     * @return bool
     */
    public function hasChild(self $child);

    /**
     * @param GeoNameInterface $child
     */
    public function addChild(self $child);

    /**
     * @param GeoNameInterface $child
     */
    public function removeChild(self $child);

    /**
     * @return int
     */
    public function getLeft();

    /**
     * @param int $left
     */
    public function setLeft($left);

    /**
     * @return int
     */
    public function getRight();

    /**
     * @param int $right
     */
    public function setRight($right);

    /**
     * @return int
     */
    public function getLevel();

    /**
     * @param int $level
     */
    public function setLevel($level);

    /**
     * @return string
     */
    public function getAddressName();

    /**
     * @return string
     */
    public function getGeoAddress();
}
