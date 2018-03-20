<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Doctrine\ORM;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use ToroShop\Bundle\AddressBundle\Model\CountryInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

interface GeoNameRepositoryInterface extends RepositoryInterface
{
    /**
     * @param CountryInterface $country
     * @param $locale
     */
    public function createListProvinceQueryBuilder(CountryInterface $country, $locale);

    /**
     * @param GeoNameInterface $parent
     * @param $locale
     */
    public function createListDistrictQueryBuilder(GeoNameInterface $parent, $locale);

    /**
     * @param GeoNameInterface $parent
     * @param $locale
     */
    public function createListParishQueryBuilder(GeoNameInterface $parent, $locale);

    /**
     * @param string $locale
     */
    public function createTranslationQueryBuilder(string $locale);

    /**
     * @param string $search
     * @param string $locale
     * @param null $type
     */
    public function findForFilter(string $search, string $locale, $type = null);
}
