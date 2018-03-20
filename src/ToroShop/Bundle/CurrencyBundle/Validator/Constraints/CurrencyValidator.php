<?php

declare(strict_types = 1);

namespace ToroShop\Bundle\CurrencyBundle\Validator\Constraints;

use Symfony\Component\Intl\Intl;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use ToroShop\Bundle\CurrencyBundle\CurrencyDataProviderInterface;

class CurrencyValidator extends ConstraintValidator
{
    /**
     * @var CurrencyDataProviderInterface
     */
    protected $dataProvider;

    public function __construct(CurrencyDataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Currency) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Currency');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;
        $currencies = array_merge(Intl::getCurrencyBundle()->getCurrencyNames(), $this->dataProvider->getCurrencyNames());

        if (!isset($currencies[$value])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Currency::NO_SUCH_CURRENCY_ERROR)
                ->addViolation();
        }
    }
}
