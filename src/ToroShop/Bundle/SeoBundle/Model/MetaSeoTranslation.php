<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Model;

use Toro\SeoBundle\Model\MetaSeoTranslation as BaseMetaSeoTranslation;

class MetaSeoTranslation extends BaseMetaSeoTranslation implements MetaSeoTranslationInterface
{
    /**
     * @var MetaSeoTranslationImageInterface
     */
    protected $image;

    /**
     * {@inheritdoc}
     */
    public function getImage(): ?MetaSeoTranslationImageInterface
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage(?MetaSeoTranslationImageInterface $image)
    {
        $this->image = $image;

        if ($image) {
            $this->image->setOwner($this);
        }
    }
}
