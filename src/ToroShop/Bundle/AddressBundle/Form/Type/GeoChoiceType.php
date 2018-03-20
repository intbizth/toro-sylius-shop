<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class GeoChoiceType extends AbstractGeoChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setRequired('parent');
        $resolver->setAllowedTypes('parent', [
            GeoNameInterface::class,
        ]);
        $resolver->setRequired('type');
        $resolver->addAllowedValues('type', [
            GeoNameInterface::TYPE_DISTRICT,
            GeoNameInterface::TYPE_PARISH,
        ]);
    }

    /**
     * @param Options $options
     *
     * @return array
     */
    protected function getChoices(Options $options)
    {
        switch ($options['type']) {
            case GeoNameInterface::TYPE_DISTRICT:
                if (!$options['parent']->isProvince()) {
                    throw new \InvalidArgumentException(sprintf('%s must be province', get_class($options['parent'])));
                }
                $queryBuilder = $this->geoRepository->createListDistrictQueryBuilder(
                    $options['parent'],
                    $options['locale']
                );

                break;
            case GeoNameInterface::TYPE_PARISH:
                if (!$options['parent']->isDistrict()) {
                    throw new \InvalidArgumentException(sprintf('%s must be district', get_class($options['parent'])));
                }
                $queryBuilder = $this->geoRepository->createListParishQueryBuilder(
                    $options['parent'],
                    $options['locale']
                );

                break;
        }

        return $queryBuilder->addOrderBy('translation.name', 'ASC')->getQuery()->getResult();
    }
}
