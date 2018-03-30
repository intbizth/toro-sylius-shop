<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Sitemap;

use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toro\SeoBundle\Sitemap\AbstractSitemapListener;
use ToroShop\Bundle\CoreBundle\Model\TaxonInterface;

class TaxonSitemap extends AbstractSitemapListener
{
    const SECTION = 'taxon';

    /**
     * @var TaxonRepositoryInterface
     */
    private $repository;

    public function __construct(UrlGeneratorInterface $urlGenerator, TaxonRepositoryInterface $repository)
    {
        parent::__construct($urlGenerator);
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function registerUrls(UrlContainerInterface $urls): void
    {
        $taxons = $this->repository->findAll();
        /** @var TaxonInterface $taxon */
        foreach ($taxons as $taxon) {
            if ($taxon->isRoot()) {
                continue;
            }

            $translations = $taxon->getTranslations();
            $isMultiLang = 2 <= count($translations);
            $url = new UrlConcrete(
                $this->urlGenerator->generate(
                    'sylius_shop_product_index',
                    [
                        'slug' => $taxon->getSlug(),
                        '_locale' => $taxon->getTranslation()->getLocale()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                new \Datetime,
                'always',
                0.7
            );

            if (!$isMultiLang) {
                $urls->addUrl($url, self::SECTION);
                continue;
            }

            $url = new GoogleMultilangUrlDecorator($url);
            /** @var TaxonTranslationInterface $translation */
            foreach ($translations as $translation) {
                $url->addLink($this->urlGenerator->generate(
                    'sylius_shop_product_index',
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
