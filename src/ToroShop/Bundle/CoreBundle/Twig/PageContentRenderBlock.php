<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Twig;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;

final class PageContentRenderBlock extends \Twig_Extension
{
    const TEMPLATE_TAG_NAME = 'img';

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(BlockRepositoryInterface $blockRepository, \Twig_Environment $twig)
    {
        $this->blockRepository = $blockRepository;
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new \Twig_Filter('page_content_render_block', [$this, 'render']),
            new \Twig_Filter('page_content_cover', [$this, 'getCover']),
        ];
    }

    /**
     * @param string $content
     * @param string $template
     *
     * @return string
     */
    public function render(string $content, string $template)
    {
        $matches = [];
        if (!preg_match_all(self::getRegex(), $content, $matches)) {
            return $content;
        }

        if (!isset($matches['blockCode']) || 0 === count($matches['blockCode'])) {
            return $content;
        }

        $templateRenderer = $this->twig->load($template);
        $returnContent = $content;
        foreach ($matches['blockCode'] as $blockCode) {
            $blockReplaced = self::getRegexForReplace($blockCode);
            if (!$block = $this->blockRepository->findOneByCode($blockCode)) {
                $returnContent = preg_replace($blockReplaced, '', $returnContent);

                continue;
            }

            $returnContent = preg_replace($blockReplaced, $templateRenderer->render(['block' => $block]), $returnContent);
        }

        return $returnContent;
    }

    /**
     * @param string $content
     *
     * @return BlockInterface|null
     */
    public function getCover(string $content)
    {
        $matches = [];
        if (!preg_match(self::getRegex(), $content, $matches)) {
            return null;
        }

        if (!isset($matches['blockCode'])) {
            return null;
        }

        return $this->blockRepository->findOneBy(['code' => $matches['blockCode'], 'type' => BlockInterface::IMAGE_BLOCK_TYPE]);
    }

    /**
     * @return string
     */
    private static function getRegex()
    {
        return '/\[' . self::TEMPLATE_TAG_NAME . '\](?<blockCode>.+)\[\/' . self::TEMPLATE_TAG_NAME . '\]/';
    }

    /**
     * @return string
     */
    private static function getRegexForReplace(string $blockCode)
    {
        return '/\[' . self::TEMPLATE_TAG_NAME . '\](' . $blockCode . ')\[\/' . self::TEMPLATE_TAG_NAME . '\]/';
    }
}
