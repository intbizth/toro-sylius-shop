<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\User\AdminUserType;
use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class AdminUserTypeExtension extends AbstractTypeExtension
{
    /**
     * @var AuthorizationChecker
     */
    private $checker;

    public function __construct(AuthorizationChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = [
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_SUPER' => 'ROLE_SUPER',
        ];

        if ($isRoot = $this->checker->isGranted('ROLE_ROOT')) {
            $roles['ROLE_ROOT'] = 'ROLE_ROOT';
        }

        $builder
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'required' => true,
                'multiple' => true,
                'choices' => $roles,
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($isRoot) {
                /**
                 * Only 'ROLE_ROOT' can update root admin
                 * for delete @see \ToroShop\Bundle\CoreBundle\EventListener\AdminUserRootDeleteListener
                 */
                if ($isRoot) {
                    return;
                }

                /** @var AdminUserInterface $data */
                $data = $event->getData();
                if (in_array('ROLE_ROOT', $data->getRoles())) {
                    throw new AccessDeniedException();
                }
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return AdminUserType::class;
    }
}
