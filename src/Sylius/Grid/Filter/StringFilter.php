<?php

declare(strict_types=1);

namespace Sylius\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;

/*
 * Prevent trim on null
 */
final class StringFilter implements FilterInterface
{
    /**
     * @var FilterInterface
     */
    private $stringFilter;

    public function __construct(FilterInterface $stringFilter)
    {
        $this->stringFilter = $stringFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options): void
    {
        if (is_array($data)) {
            $data['value'] = (string) $data['value'];
        }

        if (!is_array($data)) {
            $data = (string) $data;
        }

        $this->stringFilter->apply($dataSource, $name, $data, $options);
    }
}
