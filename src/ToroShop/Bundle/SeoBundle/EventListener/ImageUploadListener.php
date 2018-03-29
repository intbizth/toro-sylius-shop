<?php

declare(strict_types=1);

namespace ToroShop\Bundle\SeoBundle\EventListener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use ToroShop\Bundle\SeoBundle\Model\MetaSeoInterface;
use ToroShop\Bundle\SeoBundle\Model\MetaSeoTranslationInterface;
use Webmozart\Assert\Assert;

final class ImageUploadListener
{
    /**
     * @var ImageUploaderInterface
     */
    private $uploader;

    /**
     * @param ImageUploaderInterface $uploader
     */
    public function __construct(ImageUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @param ResourceControllerEvent $event
     */
    public function uploadImage(ResourceControllerEvent $event): void
    {
        $metaSeo = $event->getSubject();

        Assert::isInstanceOf($metaSeo, MetaSeoInterface::class);

        /** @var MetaSeoTranslationInterface $translation */
        foreach ($metaSeo->getTranslations() as $translation) {
            $image = $translation->getImage();

            if (null !== $image && true === $image->hasFile()) {
                $this->uploader->upload($image);
            }
        }
    }
}
