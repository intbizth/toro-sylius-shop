<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class GeoNameType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', ResourceTranslationsType::class, [
                'label' => false,
                'entry_type' => GeoNameTranslationType::class,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /** @var GeoNameInterface $data */
                if (!$data = $event->getData()) {
                    return;
                }

                if (!$data->isParish()) {
                    return;
                }

                $event->getForm()->add('postCode', TextType::class, [
                    'label' => 'toro.form.geo_name.post_code',
                ]);
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver
            ->setDefaults([
                'validation_groups' => function (FormInterface $form): array {
                    /** @var GeoNameInterface $data */
                    $data = $form->getData();
                    if ($data && $data->isParish()) {
                        $this->validationGroups[] = 'post_code';
                    }

                    return $this->validationGroups;
                },
            ])
        ;
    }
}
