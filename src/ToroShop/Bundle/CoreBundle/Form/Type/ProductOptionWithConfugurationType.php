<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Type;

use Sylius\Bundle\ProductBundle\Form\Type\ProductOptionValueType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ProductOptionWithConfugurationType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['configuration_type']) {
            return;
        }

        $builder->add('typeConfiguration', $options['configuration_type'], [
            'constraints' => [new Valid([
                'groups' => $this->validationGroups
            ])]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('configuration_type', null);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ProductOptionValueType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_product_option_with_configuration';
    }
}
