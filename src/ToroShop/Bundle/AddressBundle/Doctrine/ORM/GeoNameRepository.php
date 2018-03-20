<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use ToroShop\Bundle\AddressBundle\Model\CountryInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

class GeoNameRepository extends EntityRepository implements GeoNameRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListProvinceQueryBuilder(CountryInterface $country, $locale)
    {
        return $this->createTranslationQueryBuilder($locale)
            ->andWhere('o.country = :country')
            ->andWhere('o.type = :type')
            ->setParameter('country', $country)
            ->setParameter('type', GeoNameInterface::TYPE_PROVINCE)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function createListDistrictQueryBuilder(GeoNameInterface $parent, $locale)
    {
        return $this->createTranslationQueryBuilder($locale)
            ->andWhere('o.type = :type')
            ->andWhere('o.parent = :parent')
            ->setParameter('parent', $parent)
            ->setParameter('type', GeoNameInterface::TYPE_DISTRICT)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function createListParishQueryBuilder(GeoNameInterface $parent, $locale)
    {
        return $this->createTranslationQueryBuilder($locale)
            ->andWhere('o.type = :type')
            ->andWhere('o.parent = :parent')
            ->setParameter('parent', $parent)
            ->setParameter('type', GeoNameInterface::TYPE_PARISH)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function createTranslationQueryBuilder(string $locale)
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->setParameter('locale', $locale)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function findForFilter(string $search, string $locale, $type = null)
    {
        if ('' === $search) {
            return [];
        }

        $queryBuilder = $this->createTranslationQueryBuilder($locale);
        $likeSearch = '%' . $search . '%';

        if (null !== $type) {
            $queryBuilder->andWhere('o.type = :type')->setParameter('type', (int) $type);
        }

        return $queryBuilder
            ->andWhere(
                $queryBuilder->expr()->orX(
                    'translation.name like :search',
                    'translation.geoName like :search',
                    'o.postcode like :search'
                )
            )
            ->setParameter('search', $likeSearch)
            ->addOrderBy('translation.name', 'ASC')
            ->setMaxResults(20)
            ->getQuery()->getResult()
        ;
    }
}
