<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CurrencyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Currency extends Constraint
{
    const NO_SUCH_CURRENCY_ERROR = '69945ac1-2db4-405f-bec7-d2772f73df52';

    protected static $errorNames = array(
        self::NO_SUCH_CURRENCY_ERROR => 'NO_SUCH_CURRENCY_ERROR',
    );

    public $message = 'This value is not a valid currency.';
}
