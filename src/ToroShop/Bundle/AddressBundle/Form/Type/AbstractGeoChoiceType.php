<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Doctrine\ORM\GeoNameRepositoryInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

abstract class AbstractGeoChoiceType extends AbstractType
{
    /**
     * @var GeoNameRepositoryInterface
     */
    protected $geoRepository;

    /**
     * @var RepositoryInterface
     */
    protected $countryRepository;

    public function __construct(GeoNameRepositoryInterface $geoRepository, $countryRepository)
    {
        $this->geoRepository = $geoRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'choices' => function (Options $options) {
                return $this->getChoices($options);
            },
            'choice_value' => 'id',
            'choice_label' => 'geoAddress',
            'choice_translation_domain' => false,
            'class' => $this->geoRepository->getClassName(),
            'choice_attr' => function (GeoNameInterface $geo) {
                return [
                    // data option using for selectize
                    'data-data' => json_encode([
                        'id' => $geo->getId(),
                        'code' => $geo->getCode(),
                        'name' => $geo->getName(),
                        'path_name' => $geo->getGeoAddress(),
                    ]),
                ];
            },
            'locale' => 'th',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * @param Options $options
     *
     * @return array
     */
    protected function getChoices(Options $options)
    {
        return [];
    }
}
