<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\EventSubscriber;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ChoiceResizeListener
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $configs
     *
     * @return ChoiceResizeListener
     */
    public static function create(FormBuilderInterface $builder, array $configs)
    {
        return new self($builder, $configs);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $configs
     */
    public function __construct(FormBuilderInterface $builder, array $configs)
    {
        $builder
            // see the partner submitted data and resize for validation phase
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($configs) {
                $this->build($event, $configs, 1);
            })
            // to bind data into view phase
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($configs) {
                if ($event->getData()) {
                    $this->build($event, $configs, 2);
                }
            });
    }

    /**
     * @param FormEvent $event
     * @param array $configs
     * @param string $eventType
     */
    private function build(FormEvent $event, array $configs, $eventType)
    {
        foreach ($configs as $property => $config) {
            $this->resize($event, $property, $config, $eventType);
        }
    }

    /**
     * @param FormEvent $event
     * @param string $property
     * @param array $config
     * @param string $eventType
     */
    private function resize(FormEvent $event, $property, array $config, $eventType)
    {
        $form = $event->getForm();

        // no submit value send me to validation error.
        if (1 === $eventType && empty($event->getData()[$property])) {
            return;
        }

        $choices = [];

        if (array_key_exists('choices', $config['options'])) {
            $choices = (array) $config['options']['choices']; // user defined choices
        }

        // self resize
        if (is_string($config['query_builder'])) {
            $id = $config['query_builder'];

            $config['query_builder'] = function (QueryBuilder $queryBuilder, FormEvent $event, $type) use ($property, $id, $choices) {
                $data = $event->getData();
                $value = null;

                // pre submit
                if (1 === $type && empty($value = $data[$property])) {
                    $queryBuilder->setMaxResults(count($choices));

                    return;
                }

                // post set data
                if (2 === $type) {
                    $accessor = PropertyAccess::createPropertyAccessorBuilder()
                        ->disableExceptionOnInvalidIndex()
                        ->getPropertyAccessor();

                    if (is_array($data)) {
                        $data = (object) $data;
                    }

                    if (!$value = $accessor->getValue($data, $property)) {
                        $queryBuilder->setMaxResults(count($choices));

                        return;
                    }

                    // multiple selection
                    if ($value instanceof Collection) {
                        $value = $value->map(function ($object) use ($accessor, $id) {
                            [$alias, $id] = explode('.', $id);

                            return $accessor->getValue($object, $id);
                        })->toArray();
                    }
                }

                if (!$value) {
                    $queryBuilder->setMaxResults(count($choices));

                    return;
                }

                $where = sprintf('%s = :%s', $id, $token = str_replace('.', '_', $id));

                // NOTE: 001
                // cannot set max result, case of impossible to determine translation left-join result
                // this mean assume 4 languages in db
                $max = count($choices) + 4;

                if (is_array($value)) {
                    $where = $queryBuilder->expr()->in($id, ':' . $token);
                    $max = count($value) * $max;
                }

                $queryBuilder
                    ->setMaxResults($max)
                    ->andWhere($where)
                    ->setParameter($token, $value);
            };
        }

        $type = $config['type'] ?? $config['entry_type'];

        $form->add($property, $type, array_merge($config['options'], [
            'choices' => null,
            'query_builder' => function (EntityRepository $er) use ($config, $event, $eventType, $property, $choices) {
                // @see NOTE: 001
                // do not remember setMaxResults(n) on your own custom  query_builder
                //->setMaxResults(0)
                $queryBuilder = $er->createQueryBuilder($config['alias'] ?? 'o');

                /** @var \Closure $customQueryBuilder */
                $customQueryBuilder = $config['query_builder'];
                $customQueryBuilder->call($this, $queryBuilder, $event, $eventType, $property);

                if (!empty($choices)) {
                    $queryBuilder
                        ->orWhere($queryBuilder->expr()->in('o.id', ':_choices'))
                        ->setParameter('_choices', $choices);
                }

                return $queryBuilder;
            },
        ]));
    }
}
