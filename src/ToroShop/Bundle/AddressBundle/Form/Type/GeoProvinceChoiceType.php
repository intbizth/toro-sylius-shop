<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class GeoProvinceChoiceType extends AbstractGeoChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setRequired('countryCode');
    }

    /**
     * @param Options $options
     *
     * @return array
     */
    protected function getChoices(Options $options)
    {
        $queryBuilder = $this->geoRepository->createListProvinceQueryBuilder(
            $this->countryRepository->findOneByCode($options['countryCode']),
            $options['locale']
        );

        return $queryBuilder->addOrderBy('translation.name', 'ASC')->getQuery()->getResult();
    }
}
