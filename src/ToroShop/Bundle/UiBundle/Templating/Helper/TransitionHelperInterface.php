<?php

declare(strict_types=1);

namespace ToroShop\Bundle\UiBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\HelperInterface;

interface TransitionHelperInterface extends HelperInterface
{
    /**
     * @return string
     */
    public function getName();
}
