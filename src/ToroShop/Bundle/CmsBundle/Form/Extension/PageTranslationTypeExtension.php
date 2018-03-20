<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CmsBundle\Form\Extension;

use BitBag\SyliusCmsPlugin\Form\Type\Translation\PageTranslationType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class PageTranslationTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', CKEditorType::class, [
            'label' => 'bitbag_sylius_cms_plugin.ui.content',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return PageTranslationType::class;
    }
}
