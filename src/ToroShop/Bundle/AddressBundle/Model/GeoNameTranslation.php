<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Sylius\Component\Resource\Model\AbstractTranslation;

class GeoNameTranslation extends AbstractTranslation implements GeoNameTranslationInterface
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $abbreviation;

    /**
     * @var string
     */
    protected $geoName;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbbreviation()
    {
        return $this->abbreviation ?: $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * {@inheritdoc}
     */
    public function getGeoName()
    {
        return $this->geoName;
    }

    /**
     * {@inheritdoc}
     */
    public function setGeoName($geoName)
    {
        $this->geoName = $geoName;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}
