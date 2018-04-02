<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductOptionType;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\CoreBundle\Form\Type\ProductOptionWithConfugurationType;
use ToroShop\Bundle\CoreBundle\Model\ProductOptionInterface;

final class ProductOptionTypeExtension extends AbstractTypeExtension
{
    /**
     * @var FormTypeRegistryInterface
     */
    private $formRegistry;

    public function __construct(FormTypeRegistryInterface $formRegistry)
    {
        $this->formRegistry = $formRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                /** @var ProductOptionInterface $data */
                $data = $event->getData();
                $form = $event->getForm();

                $optionType = $options['option_type'];
                if ($data && $data->getId()) {
                    $optionType = $data->getOptionType();
                }

                if (!$optionType) {
                    return;
                }

                $form->add('values', CollectionType::class, [
                    'entry_type' => ProductOptionWithConfugurationType::class,
                    'entry_options' => [
                        'configuration_type' => $this->formRegistry->get($optionType, 'default')
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'label' => false,
                    'button_add_label' => 'sylius.form.option_value.add_value',
                ]);
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use ($options) {
                /** @var ProductOptionInterface $data */
                $data = $event->getData();

                if ($data->getOptionType() or empty($options['option_type'])) {
                    return;
                }

                $data->setOptionType($options['option_type']);

                $event->setData($data);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'option_type' => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return ProductOptionType::class;
    }
}
