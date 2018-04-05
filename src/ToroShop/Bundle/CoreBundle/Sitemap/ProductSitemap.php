<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Sitemap;

use Doctrine\Common\Collections\Collection;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toro\SeoBundle\Sitemap\AbstractSitemapListener;

class ProductSitemap extends AbstractSitemapListener
{
    const SECTION = 'product';

    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    /**
     * @var array
     */
    private $channelLocaleCodes;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        ProductRepositoryInterface $repository,
        ChannelContextInterface $channelContext
    )
    {
        parent::__construct($urlGenerator);
        $this->repository = $repository;
        $this->channelContext = $channelContext;
    }

    /**
     * @inheritdoc
     */
    public function registerUrls(UrlContainerInterface $urls): void
    {
        $products = $this->getProducts();

        /** @var ProductInterface $product */
        foreach ($products as $product) {
            $translations = $this->getTranslations($product);
            $isMultiLang = 2 <= count($translations);
            $url = new UrlConcrete(
                $this->urlGenerator->generate(
                    'sylius_shop_product_show',
                    [
                        'slug' => $product->getSlug(),
                        '_locale' => $product->getTranslation()->getLocale()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $product->getUpdatedAt() ?: $product->getCreatedAt(),
                'daily',
                1.0
            );

            if (!$isMultiLang) {
                $urls->addUrl($url, self::SECTION);
                continue;
            }

            $url = new GoogleMultilangUrlDecorator($url);
            /** @var ProductTranslationInterface $translation */
            foreach ($translations as $translation) {
                $url->addLink($this->urlGenerator->generate(
                    'sylius_shop_product_show',
                    [
                        'slug' => $translation->getSlug(),
                        '_locale' => $translation->getLocale()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ), $translation->getLocale());
            }

            $urls->addUrl($url, self::SECTION);
        }
    }

    /**
     * @return array|Collection|ProductInterface[]
     */
    private function getProducts()
    {
        return $this->repository->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation')
            ->andWhere(':channel MEMBER OF o.channels')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('channel', $this->channelContext->getChannel())
            ->setParameter('enabled', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param ProductInterface $product
     * @return Collection|ProductTranslationInterface[]
     */
    private function getTranslations(ProductInterface $product): Collection
    {
        return $product->getTranslations()->filter(function (TranslationInterface $translation) {
            return $this->localeInLocaleCodes($translation);
        });
    }

    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes());
    }

    /**
     * @return array
     */
    private function getLocaleCodes(): array
    {
        if ($this->channelLocaleCodes === null) {
            /** @var ChannelInterface $channel */
            $channel = $this->channelContext->getChannel();
            $this->channelLocaleCodes = $channel->getLocales()->map(function (LocaleInterface $locale) {
                return $locale->getCode();
            })->toArray();
        }

        return $this->channelLocaleCodes;
    }
}
