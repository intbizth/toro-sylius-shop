<?php

declare(strict_types=1);

namespace Sylius\Grid\Filter;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;
use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Data\ExpressionBuilderInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;

class PriceFilter implements FilterInterface
{
    const NAME = 'price';

    const DEFAULT_SCALE = 2;
    const TYPE_GREATER_THAN_OR_EQUAL = 'greater_than_or_equal';
    const TYPE_LESS_THAN_OR_EQUAL = 'less_than_or_equal';

    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    /**
     * @var CurrencyContextInterface
     */
    private $currencyContext;

    public function __construct(
        CurrencyConverterInterface $currencyConverter,
        ChannelContextInterface $channelContext,
        CurrencyContextInterface $currencyContext
    ) {
        $this->currencyConverter = $currencyConverter;
        $this->channelContext = $channelContext;
        $this->currencyContext = $currencyContext;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options): void
    {
        if (empty($data)) {
            return;
        }

        if (!is_numeric($data['value'])) {
            return;
        }

        $type = $data['type'];
        $scale = (int) ($options['scale'] ?? self::DEFAULT_SCALE);
        $price_format = $this->normalizeAmount((float) $data['value'], $scale);

        try {
            /** @var ChannelInterface $channel  */
            $channel = $this->channelContext->getChannel();
            $price_format = $this->currencyConverter->convert($price_format, $this->currencyContext->getCurrencyCode(), $channel->getBaseCurrency()->getCode());
        } catch (ChannelNotFoundException $e) {}

        $expressionBuilder = $dataSource->getExpressionBuilder();
        
        $dataSource->restrict($expressionBuilder->orX($this->getExpression($expressionBuilder, $type, $options['fields'], $price_format)));
    }

    /**
     * @param float $amount
     * @param int $scale
     *
     * @return int
     */
    private function normalizeAmount(float $amount, int $scale): int
    {
        return (int) round($amount * (10 ** $scale));
    }

    /**
     * @param ExpressionBuilderInterface $expressionBuilder
     * @param string $type
     * @param string $field
     * @param mixed $value
     *
     * @return ExpressionBuilderInterface
     */
    private function getExpression(ExpressionBuilderInterface $expressionBuilder, $type, $field, $value)
    {
        switch ($type) {
            case self::TYPE_GREATER_THAN_OR_EQUAL:
                return $expressionBuilder->greaterThanOrEqual($field, $value);
            case self::TYPE_LESS_THAN_OR_EQUAL:
                return $expressionBuilder->lessThanOrEqual($field, $value);
            default:
                throw new \InvalidArgumentException(sprintf('Could not get an expression for type "%s"!', $type));
        }
    }
}
