<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Product\ProductReviewType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ProductReviewTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $comment = $data['comment'];

                if (!$comment) {
                    return;
                }
                $data['title'] = mb_substr($comment, 0, 10);
                $event->setData($data);
            });
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return ProductReviewType::class;
    }
}
