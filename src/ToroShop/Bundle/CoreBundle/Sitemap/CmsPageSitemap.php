<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Sitemap;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toro\SeoBundle\Provider\LocaleProviderInterface;
use Toro\SeoBundle\Sitemap\AbstractSitemapListener;

final class CmsPageSitemap extends AbstractSitemapListener
{
    /**
     * @var PageRepositoryInterface
     */
    private $repository;

    public function __construct(UrlGeneratorInterface $urlGenerator, LocaleProviderInterface $localeProvider, PageRepositoryInterface $repository)
    {
        parent::__construct($urlGenerator, $localeProvider);
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'cms_page';
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $pages = $this->repository->findBy(['enabled' => true]);

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            $this->addUrl($this->createUrl([
                'route' => 'toro_shop_cms_page_show',
                'parameters' => [
                    'slug' => $page->getSlug()
                ],
                'changefreq' => 'weekly',
                'priority' => 1.0,
                'multi_lang' => true
            ]));
        }
    }
}
