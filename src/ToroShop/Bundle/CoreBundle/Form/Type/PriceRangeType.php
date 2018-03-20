<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class PriceRangeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lowest_price', NumberType::class, [
                'required' => true,
                'constraints' => [new NotBlank([
                    'groups' => ['sylius'],
                ])],
                'attr' => [
                    'placeholder' => 'gdd.form.product.search.low_price',
                ],
            ])
            ->add('highest_price', NumberType::class, [
                'required' => true,
                'constraints' => [new NotBlank([
                    'groups' => ['sylius'],
                ])],
                'attr' => [
                    'placeholder' => 'gdd.form.product.search.high_price',
                ],
            ])
        ;
    }
}
