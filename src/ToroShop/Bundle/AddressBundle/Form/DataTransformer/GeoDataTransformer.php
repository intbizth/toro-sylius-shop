<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Form\DataTransformer;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use ToroShop\Bundle\AddressBundle\Doctrine\ORM\GeoNameRepositoryInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

final class GeoDataTransformer implements DataTransformerInterface
{
    /**
     * @var GeoNameRepositoryInterface
     */
    private $repository;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $identifier;

    public function __construct(RepositoryInterface $repository, int $type, ?string $identifier = null)
    {
        $this->repository = $repository;
        $this->type = $type;
        $this->identifier = $identifier ?? 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof Collection) {
            foreach ($value->toArray() as $geoName) {
                $this->validate($geoName);
            }

            return $value;
        }

        // Use query only id and then type compare
        // Because reduce query eager
        /** @var GeoNameInterface $geoName */
        $geoName = $this->repository->findOneBy([
            $this->identifier => $value,
        ]);

        $this->validate($geoName);

        return $geoName;
    }

    /**
     * @param GeoNameInterface $geoName
     */
    private function validate(GeoNameInterface $geoName)
    {
        if (null === $geoName || ($geoName && $geoName->getType() !== $this->type)) {
            throw new TransformationFailedException(sprintf(
                'A geo "%s" with type does not exist.',
                $geoName->getName()
            ));
        }
    }
}
