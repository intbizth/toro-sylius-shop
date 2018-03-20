<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class TaxonConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price_range_for_search', CollectionType::class, [
                'required' => false,
                'label' => 'Price range for searching',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_type' => PriceRangeType::class,
            ])
        ;
    }
}
