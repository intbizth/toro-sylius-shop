<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Type\Sylius\Shop;

use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddressBookChoiceType extends AbstractType
{
    /**
     * @var RepositoryInterface
     */
    private $addressRepository;

    /**
     * {@inheritdoc}
     */
    public function __construct(RepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'choices' => function (Options $options) {
                return $this->getChoices($options['customer']);
            },
            'expanded' => true,
            'choice_value' => 'id',
            'choice_label' => 'firstname',
            'choice_translation_domain' => false,
            'class' => $this->addressRepository->getClassName(),
        ]);

        $resolver->setRequired('customer');
        $resolver->addAllowedTypes('customer', CustomerInterface::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return array
     */
    protected function getChoices(CustomerInterface $customer)
    {
        return $customer->getAddresses();
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'gdd_address_book_choice';
    }
}
