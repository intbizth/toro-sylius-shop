<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type\Sylius;

use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Form\DataTransformer\GeoDataTransformer;
use ToroShop\Bundle\AddressBundle\Form\Type\AbstractGeoChoiceType;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class GeoAutocompleteType extends AbstractGeoChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'resource' => 'toro.geo_name',
            'choice_name' => 'geoName',
            'choice_value' => 'id',
        ]);

        $resolver->setRequired('type');
        $resolver->addAllowedValues('type', [
            GeoNameInterface::TYPE_PROVINCE,
            GeoNameInterface::TYPE_DISTRICT,
            GeoNameInterface::TYPE_PARISH,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new GeoDataTransformer($this->geoRepository, $options['type']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['remote_criteria_type'] = 'contains';
        $view->vars['remote_criteria_name'] = 'search';
        $view->vars['geo_type'] = $options['type'];
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'toro_sylius_geo_name_autocomplete_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ResourceAutocompleteChoiceType::class;
    }
}
