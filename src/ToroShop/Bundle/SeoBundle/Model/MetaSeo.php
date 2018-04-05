<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Model;

use Toro\SeoBundle\Model\MetaSeo as BaseMetaSeo;

/**
 * @method MetaSeoTranslationInterface getTranslation(): MetaSeoTranslationInterface
 */
class MetaSeo extends BaseMetaSeo implements MetaSeoInterface
{
    /**
     * {@inheritdoc}
     */
    public function createTranslation()
    {
        return new MetaSeoTranslation();
    }

    /**
     * {@inheritdoc}
     */
    public function getImage(): ?MetaSeoTranslationImageInterface
    {
        return $this->getTranslation()->getImage();
    }

    /**
     * {@inheritdoc}
     */
    public function setImage(?MetaSeoTranslationImageInterface $image): void
    {
        $this->getTranslation()->setImage($image);
    }
}
