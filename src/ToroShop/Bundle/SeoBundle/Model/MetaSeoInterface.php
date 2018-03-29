<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Model;

use Toro\SeoBundle\Model\MetaSeoInterface as BaseMetaSeoInterface;

interface MetaSeoInterface extends BaseMetaSeoInterface
{
    /**
     * @return MetaSeoTranslationImageInterface|null
     */
    public function getImage(): ?MetaSeoTranslationImageInterface;

    /**
     * @param MetaSeoTranslationImageInterface|null $image
     */
    public function setImage(?MetaSeoTranslationImageInterface $image): void;
}
