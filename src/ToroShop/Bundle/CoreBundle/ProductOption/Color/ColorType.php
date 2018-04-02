<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\ProductOption\Color;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ColorType as SymfonyColorType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ColorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', SymfonyColorType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'groups' => ['sylius']
                    ])
                ]
            ])
        ;
    }
}
