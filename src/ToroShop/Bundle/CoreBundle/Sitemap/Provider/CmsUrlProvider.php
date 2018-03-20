<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Sitemap\Provider;

use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use SitemapPlugin\Factory\SitemapUrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Stefan Doorn <stefan@efectos.nl>
 */
final class CmsUrlProvider implements UrlProviderInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SitemapUrlFactoryInterface
     */
    private $sitemapUrlFactory;

    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    /**
     * @var array
     */
    private $urls = [];

    public function __construct(
        PageRepositoryInterface $pageRepository,
        RouterInterface $router,
        SitemapUrlFactoryInterface $sitemapUrlFactory,
        LocaleContextInterface $localeContext
    ) {
        $this->pageRepository = $pageRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->localeContext = $localeContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'cms';
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): iterable
    {
        foreach ($this->pageRepository->findBy(['enabled' => true]) as $page) {
            $url = $this->sitemapUrlFactory->createNew();
            $url->setChangeFrequency(ChangeFrequency::weekly());
            $url->setPriority(0.5);

            foreach ($page->getTranslations() as $translation) {
                /** @var TranslationInterface|PageTranslationInterface $translation */
                $location = $this->router->generate('gdd_shop_cms_page_show', [
                    'slug' => $translation->getSlug(),
                    '_locale' => $translation->getLocale(),
                ]);

                if ($translation->getLocale() === $this->localeContext->getLocaleCode()) {
                    $url->setLocalization($location);
                } else {
                    $url->addAlternative($location, $translation->getLocale());
                }
            }

            $this->urls[] = $url;
        }

        return $this->urls;
    }
}
