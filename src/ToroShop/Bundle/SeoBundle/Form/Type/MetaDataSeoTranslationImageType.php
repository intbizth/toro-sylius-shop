<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

class MetaDataSeoTranslationImageType extends ImageType
{
    public function getBlockPrefix(): string
    {
        return 'toro_meta_seo_image';
    }
}
