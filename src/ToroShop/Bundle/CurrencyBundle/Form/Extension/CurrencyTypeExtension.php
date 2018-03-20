<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Form\Extension;

use Sylius\Bundle\CurrencyBundle\Form\Type\CurrencyType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType as SymfonyCurrencyType;
use Symfony\Component\Intl\Intl;
use ToroShop\Bundle\CurrencyBundle\CurrencyDataProviderInterface;

final class CurrencyTypeExtension extends AbstractTypeExtension
{
    /**
     * @var CurrencyDataProviderInterface
     */
    private $dataProvider;

    public function __construct(CurrencyDataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new AddCodeFormSubscriber(SymfonyCurrencyType::class, [
                'label' => 'sylius.form.currency.code',
                'choice_loader' => null,
                'choices' => array_flip(array_merge(Intl::getCurrencyBundle()->getCurrencyNames(), $this->dataProvider->getCurrencyNames())),
            ]))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return CurrencyType::class;
    }
}
