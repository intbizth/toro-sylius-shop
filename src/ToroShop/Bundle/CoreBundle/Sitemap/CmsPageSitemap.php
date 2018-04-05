<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Sitemap;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toro\SeoBundle\Sitemap\AbstractSitemapListener;

class CmsPageSitemap extends AbstractSitemapListener
{
    const SECTION = 'cms_page';

    /**
     * @var PageRepositoryInterface
     */
    private $repository;

    public function __construct(UrlGeneratorInterface $urlGenerator, PageRepositoryInterface $repository)
    {
        parent::__construct($urlGenerator);
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function registerUrls(UrlContainerInterface $urls): void
    {
        $pages = $this->repository->findBy(['enabled' => true]);
        /** @var PageInterface $page */
        foreach ($pages as $page) {
            $translations = $page->getTranslations();
            $isMultiLang = 2 <= count($translations);
            $url = new UrlConcrete(
                $this->urlGenerator->generate(
                    'toro_shop_cms_page_show',
                    [
                        'slug' => $page->getSlug(),
                        '_locale' => $page->getTranslation()->getLocale()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $page->getUpdatedAt() ?: $page->getCreatedAt(),
                'weekly',
                0.8
            );

            if (!$isMultiLang) {
                $urls->addUrl($url, self::SECTION);
                continue;
            }

            $url = new GoogleMultilangUrlDecorator($url);
            /** @var PageTranslationInterface $translation */
            foreach ($translations as $translation) {
                $url->addLink($this->urlGenerator->generate(
                    'toro_shop_cms_page_show',
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
}
