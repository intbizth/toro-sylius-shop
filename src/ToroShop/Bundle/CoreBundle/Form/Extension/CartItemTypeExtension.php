<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Extension;

use Sylius\Bundle\OrderBundle\Form\Type\CartItemType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantMatchType;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class CartItemTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var ProductInterface $product */
        $product = $options['product'] ?? null;

        if (!$product) {
            return;
        }

        if ($product && $product->hasVariants() && !$product->isSimple()) {
            if (Product::VARIANT_SELECTION_CHOICE === $product->getVariantSelectionMethod()) {
                return;
            }

            $builder
                ->add('variant', ProductVariantMatchType::class, [
                    'product' => $product,
                    'entries' => array_filter($product->getOptions()->toArray(), function (ProductOptionInterface $productOption) use ($product) {
                        return $this->getOptionsChoice($product, $productOption);
                    }),
                    'entry_options' => function (ProductOptionInterface $productOption) use ($product) {
                        return [
                            'label' => $productOption->getName(),
                            'option' => $productOption,
                            'choices' => $this->getOptionsChoice($product, $productOption),
                        ];
                    },
                ])
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return CartItemType::class;
    }

    /**
     * @param ProductInterface $product
     * @param ProductOptionInterface $productOption
     *
     * @return array
     */
    private function getOptionsChoice(ProductInterface $product, ProductOptionInterface $productOption)
    {
        return array_filter($productOption->getValues()->toArray(), function (ProductOptionValueInterface $productOptionValue) use ($product) {
            foreach ($product->getVariants() as $productVariant) {
                /** @var ProductVariantInterface $productVariant */
                if ($productVariant->getOptionValues()->contains($productOptionValue)) {
                    return true;
                }
            }

            return false;
        });
    }
}
