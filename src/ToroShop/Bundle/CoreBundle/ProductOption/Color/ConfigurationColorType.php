<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\ProductOption\Color;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigurationColorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', ColorType::class, [
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
