<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class GeoNameTranslationType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'toro.form.geo_name.name',
            ])
            ->add('geoName', TextType::class, [
                'label' => 'toro.form.geo_name.geo_name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'toro.form.geo_name.slug',
            ])
        ;
    }
}
