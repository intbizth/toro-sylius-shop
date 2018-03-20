<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Doctrine\ORM\GeoNameRepositoryInterface;
use ToroShop\Bundle\AddressBundle\Form\DataTransformer\GeoDataTransformer;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class GeoAjaxSelectizeChoiceType extends AbstractGeoChoiceType
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(GeoNameRepositoryInterface $geoRepository, $countryRepository, Router $router)
    {
        parent::__construct($geoRepository, $countryRepository);

        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setRequired('type');
        $resolver->addAllowedValues('type', [
            GeoNameInterface::TYPE_PROVINCE,
            GeoNameInterface::TYPE_DISTRICT,
            GeoNameInterface::TYPE_PARISH,
        ]);

        $resolver->setNormalizer('attr', function (Options $options, $value) {
            return array_replace_recursive([
                'data-chooser' => json_encode([
                    'value' => 'id',
                    'labelTextField' => 'addressName',
                    'min_query' => 3,
                    'clearOnLoad' => false,
                    'url' => $this->router->getGenerator()->generate('toro_shop_ajax_filter_geo', ['type' => $options['type']]),
                ]),
            ], $value);
        });
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new GeoDataTransformer($this->geoRepository, $options['type']));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'toro_geo_name_ajax_selectize_choice';
    }
}
