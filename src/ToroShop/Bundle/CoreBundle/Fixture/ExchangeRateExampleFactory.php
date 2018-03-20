<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Currency\Model\ExchangeRateInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExchangeRateExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @var RepositoryInterface
     */
    private $currencyRepository;

    public function __construct(FactoryInterface $userFactory, RepositoryInterface $currencyRepository)
    {
        $this->factory = $userFactory;
        $this->currencyRepository = $currencyRepository;
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = [])
    {
        /** @var ExchangeRateInterface $exchangeRate */
        $exchangeRate = $this->factory->createNew();
        $exchangeRate->setRatio($options['ratio']);
        $exchangeRate->setSourceCurrency($this->currencyRepository->findOneByCode($options['source']));
        $exchangeRate->setTargetCurrency($this->currencyRepository->findOneByCode($options['target']));

        return $exchangeRate;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('source')
            ->setRequired('target')
            ->setRequired('ratio')
            ->setAllowedTypes('ratio', ['float'])
        ;
    }
}
