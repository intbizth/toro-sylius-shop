<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Toro\SeoBundle\Form\Type\MetaSeoTranslationType;
use ToroShop\Bundle\SeoBundle\Form\Type\MetaDataSeoTranslationImageType;

final class MetaSeoTranslationExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', MetaDataSeoTranslationImageType::class, [
                'label' => false,
                'required' => false
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return MetaSeoTranslationType::class;
    }
}
