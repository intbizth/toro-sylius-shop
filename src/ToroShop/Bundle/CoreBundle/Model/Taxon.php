<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Model;

use Sylius\Component\Core\Model\Taxon as BaseTaxon;

class Taxon extends BaseTaxon implements TaxonInterface
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(?array $configuration)
    {
        $this->configuration = $configuration;
    }
}
