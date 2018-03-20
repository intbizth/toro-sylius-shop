<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Model;

use Sylius\Component\Core\Model\TaxonInterface as BaseTaxonInterface;

interface TaxonInterface extends BaseTaxonInterface
{
    /**
     * @return array
     */
    public function getConfiguration(): ?array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(?array $configuration);
}
