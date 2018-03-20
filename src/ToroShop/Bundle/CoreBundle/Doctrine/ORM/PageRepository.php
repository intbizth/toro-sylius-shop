<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Doctrine\ORM;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepository as BasePageRepository;

class PageRepository extends BasePageRepository
{
    /**
     * {@inheritdoc}
     */
    public function findOneEnabledBySlugAndSection(string $slug, string $sectionCode, ?string $localeCode): ?PageInterface
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.sections', 'section')
            ->where('translation.locale = :localeCode')
            ->andWhere('translation.slug = :slug')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('sectionCode', $sectionCode)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
