<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Form\Extension;

use Sylius\Bundle\CurrencyBundle\Form\Type\CurrencyChoiceType;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToroShop\Bundle\CurrencyBundle\CurrencyDataProviderInterface;

final class CurrencyChoiceTypeExtension extends AbstractTypeExtension
{
    /**
     * @var CurrencyDataProviderInterface
     */
    private $dataProvider;

    public function __construct(CurrencyDataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'choice_label' => function(CurrencyInterface $currency) {
                return Intl::getCurrencyBundle()->getCurrencyName($currency->getCode()) ?: $this->dataProvider->getCurrencyName($currency->getCode());
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return CurrencyChoiceType::class;
    }
}
