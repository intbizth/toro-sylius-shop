<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Data\ExpressionBuilderInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;

class GeoTreeFilter implements FilterInterface
{
    const NAME = 'geo_tree';

    const TYPE_CHILD_INCLUDE = 'child_include';

    /**
     * @var RepositoryInterface
     */
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options): void
    {
        $expressionBuilder = $dataSource->getExpressionBuilder();

        if (!array_key_exists('value', $data)) {
            return;
        }

        $arrValue = (is_array($data['value'])) ? $data['value'] : (array) $data['value'];
        $type = $data['type'] ?? self::TYPE_CHILD_INCLUDE;

        $value = [];
        // support both "1,2,3" and "array(1,2,3)"
        foreach ($arrValue as $v) {
            $value = array_merge($value, explode(',', $v));
        }

        $value = array_filter($value, 'is_numeric');

        if (empty($value)) {
            return;
        }

        // Limit
        $options['limit'] = (array_key_exists('limit', $options)) ?: 5;
        $value = (count($value) <= $options['limit']) ? $value : array_slice($value, 0, $options['limit']);

        $geoNames = $this->repository->findById($value);
        $expressions = $this->getExpression($expressionBuilder, $type, $options['alias'], $geoNames);

        if (empty($expressions)) {
            return;
        }

        $dataSource->restrict($expressionBuilder->orX(
            ...$expressions
        ));
    }

    /**
     * @param ExpressionBuilderInterface $expressionBuilder
     * @param $type
     * @param $field
     * @param $value
     *
     * @return array
     */
    private function getExpression(ExpressionBuilderInterface $expressionBuilder, $type, $field, $value)
    {
        $expressions = [];

        switch ($type) {
            case self::TYPE_CHILD_INCLUDE:
                foreach ($value as $geoName) {
                    /** @var $geoName GeoNameInterface */
                    // Can't use $expr->lessThanOrEqual , $expr->greaterThanOrEqual
                    $expressions[] = $expressionBuilder->andX(
                        sprintf('%s.left >= %s', $field, $geoName->getLeft()),
                        sprintf('%s.right <= %s', $field, $geoName->getRight())
                    );
                }

                return $expressions;
            default:
                throw new \InvalidArgumentException(sprintf('filter type %s do not supported in %s', $type, __CLASS__));
        }
    }
}
