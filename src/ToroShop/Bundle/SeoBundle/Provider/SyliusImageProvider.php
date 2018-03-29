<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\Provider;

use ToroShop\Bundle\SeoBundle\Model\MetaSeoInterface as ShopMetaSeoInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Toro\SeoBundle\Model\MetaSeoInterface;
use Toro\SeoBundle\Provider\ImageProviderInterface;
use Webmozart\Assert\Assert;

final class SyliusImageProvider implements ImageProviderInterface
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function getImagePath(MetaSeoInterface $metaSeo): ?string
    {
        Assert::isInstanceOf($metaSeo, ShopMetaSeoInterface::class);

        /** @var ShopMetaSeoInterface $metaSeo */

        return $metaSeo->getImage() && $metaSeo->getImage()->getPath()
            ? $this->cacheManager->getBrowserPath($metaSeo->getImage()->getPath(), 'strip') : null;
    }
}
