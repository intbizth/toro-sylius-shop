<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\TaxonInterface;

class ProductRepository extends BaseProductRepository
{
    /**
     * {@inheritdoc}
     */
    public function createPublicListQueryBuilder(
        ChannelInterface $channel,
        TaxonInterface $taxon,
        string $locale,
        ?array $sorting = [],
        ?array $criteria = []
    ): QueryBuilder {
        $queryBuilder = parent::createShopListQueryBuilder($channel, $taxon, $locale, $sorting);

        // Prevent 'variant' is already defined
        if (isset($sorting['price'])) {
            return $queryBuilder;
        }

        if (isset($criteria['lowest_price']) or isset($criteria['highest_price'])) {
            $queryBuilder
                ->innerJoin('o.variants', 'variant')
                ->innerJoin('variant.channelPricings', 'channelPricing')
                ->andWhere('channelPricing.channelCode = :channelCode')
                ->setParameter('channelCode', $channel->getCode())
            ;
        }

        return $queryBuilder;
    }
}
