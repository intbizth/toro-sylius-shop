<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Extension;

use ToroShop\Bundle\CoreBundle\Form\Type\TaxonConfigurationType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

final class TaxonTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('configuration', TaxonConfigurationType::class, [
                'label' => 'Configuration',
                'constraints' => [
                    new Valid(['groups' => $options['validation_groups']]), ],
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return TaxonType::class;
    }
}
